<?php

/**
 * RANK is reserved in MySQL 8. Lists must quote it, otherwise a saved row
 * never comes back from ORDER BY rank.
 */

$root = dirname(__DIR__);
$sources = [
    $root . '/core/components/managerbuttons/src/Service.php',
    $root . '/core/components/managerbuttons/src/Processors/Group/GetList.php',
    $root . '/core/components/managerbuttons/src/Processors/Button/GetList.php',
    $root . '/_build/resolvers/resolve.widget.php',
];

$failed = 0;

function check(bool $ok, string $message): void
{
    global $failed;
    if ($ok) {
        echo "ok  {$message}\n";
        return;
    }
    $failed++;
    echo "FAIL {$message}\n";
}

foreach ($sources as $file) {
    $code = file_get_contents($file);
    check($code !== false && !preg_match("/sortby\\(\\s*'rank'/", $code), basename($file) . ' does not sort by an unquoted rank');
    check($code !== false && !preg_match('/MAX\\(\\s*rank\\s*\\)/', $code), basename($file) . ' does not aggregate an unquoted rank');
}

$service = file_get_contents($root . '/core/components/managerbuttons/src/Service.php');
check(is_string($service) && str_contains($service, "escape('rank')"), 'Service quotes the rank column');

if (!extension_loaded('pdo_mysql')) {
    echo "skip SQL check: pdo_mysql is not loaded\n";
    exit($failed > 0 ? 1 : 0);
}

$dsn = getenv('MB_DSN') ?: 'mysql:host=127.0.0.1;dbname=managerbuttons_test;charset=utf8mb4';
$user = getenv('MB_DB_USER') ?: 'root';
$pass = getenv('MB_DB_PASS') ?: '';

try {
    $serverDsn = preg_replace('/dbname=[^;]+;?/', '', $dsn);
    $server = new PDO($serverDsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $server->exec('CREATE DATABASE IF NOT EXISTS managerbuttons_test');
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Throwable $e) {
    echo "skip SQL check: {$e->getMessage()}\n";
    exit($failed > 0 ? 1 : 0);
}

$pdo->exec('DROP TABLE IF EXISTS managerbuttons_groups');
$pdo->exec(
    'CREATE TABLE managerbuttons_groups (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL DEFAULT "",
        `rank` INT UNSIGNED NOT NULL DEFAULT 0,
        createdon DATETIME NULL,
        createdby INT UNSIGNED NOT NULL DEFAULT 0
    ) ENGINE=InnoDB'
);
$insert = $pdo->prepare('INSERT INTO managerbuttons_groups (name, `rank`, createdon, createdby) VALUES (?, ?, ?, ?)');
$insert->execute(['Стоимость', 1, '2026-09-22 12:00:00', 1]);

$bareFailed = false;
try {
    $pdo->query('SELECT id, name FROM managerbuttons_groups ORDER BY rank ASC')->fetchAll();
} catch (Throwable $e) {
    $bareFailed = true;
}
echo ($bareFailed ? 'ok  ' : 'note ') . "ORDER BY rank " . ($bareFailed ? 'is rejected (MySQL 8)' : 'is accepted by this server; quoted form is still required') . "\n";

$quoted = $pdo->query('SELECT id, name FROM managerbuttons_groups ORDER BY `rank` ASC, id ASC')->fetchAll(PDO::FETCH_ASSOC);
check(count($quoted) === 1 && $quoted[0]['name'] === 'Стоимость', 'ORDER BY `rank` returns the saved group');

$max = $pdo->query('SELECT MAX(`rank`) FROM managerbuttons_groups')->fetchColumn();
check((int) $max === 1, 'MAX(`rank`) reads the saved rank');

exit($failed > 0 ? 1 : 0);
