<?php
/**
 * Standalone transport packer for ManagerButtons.
 * Does not require a live MODX installation.
 *
 * Usage: php _build/pack.php
 */

$config = require __DIR__ . '/config.inc.php';
define('PKG_NAME', $config['name'] ?? 'ManagerButtons');
define('PKG_NAME_LOWER', $config['name_lower'] ?? 'managerbuttons');
define('PKG_VERSION', $config['version'] ?? '1.0.0');
define('PKG_RELEASE', $config['release'] ?? 'pl');

$root = dirname(__DIR__) . '/';
$signature = PKG_NAME . '-' . PKG_VERSION . '-' . PKG_RELEASE;
$buildDir = sys_get_temp_dir() . '/mb-build-' . uniqid() . '/';
$pkgDir = $buildDir . $signature . '/';
$outDir = $root . '_packages/';

$coreSrc = $root . 'core/components/' . PKG_NAME_LOWER . '/';
$assetsSrc = $root . 'assets/components/' . PKG_NAME_LOWER . '/';

if (!is_dir($coreSrc) || !is_dir($assetsSrc)) {
    fwrite(STDERR, "Source directories are missing.\n");
    exit(1);
}

function mb_guid(): string
{
    return md5(uniqid((string) mt_rand(), true));
}

function mb_write_vehicle(string $path, array $data): void
{
    $dir = dirname($path);
    if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
        throw new RuntimeException('Cannot create ' . $dir);
    }
    $export = var_export($data, true);
    file_put_contents($path, "<?php return {$export};\n");
}

function mb_copy_dir(string $src, string $dst): void
{
    if (!is_dir($dst) && !mkdir($dst, 0777, true) && !is_dir($dst)) {
        throw new RuntimeException('Cannot create ' . $dst);
    }
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($src, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($iterator as $item) {
        $target = $dst . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
        if ($item->isDir()) {
            if (!is_dir($target) && !mkdir($target, 0777, true) && !is_dir($target)) {
                throw new RuntimeException('Cannot create ' . $target);
            }
        } else {
            copy($item->getPathname(), $target);
        }
    }
}

function mb_zip_dir(string $source, string $zipFile): void
{
    $zip = new ZipArchive();
    if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        throw new RuntimeException('Cannot create zip ' . $zipFile);
    }
    $source = rtrim($source, '/\\') . '/';
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($iterator as $file) {
        if (!$file->isFile()) {
            continue;
        }
        $local = substr($file->getPathname(), strlen($source));
        $zip->addFile($file->getPathname(), str_replace('\\', '/', $local));
    }
    $zip->close();
}

if (is_dir($buildDir)) {
    // unique path
}

mkdir($pkgDir, 0777, true);

$nsGuid = mb_guid();
$nsSig = md5($nsGuid . 'ns');
$coreGuid = mb_guid();
$coreSig = md5($coreGuid . 'core');
$assetsGuid = mb_guid();
$assetsSig = md5($assetsGuid . 'assets');
$menuGuid = mb_guid();
$menuSig = md5($menuGuid . 'menu');
$catGuid = mb_guid();
$catSig = md5($catGuid . 'cat');

$coreVehicleDir = $pkgDir . 'xPDO/Transport/xPDOFileVehicle/' . $coreSig . '/' . PKG_NAME_LOWER . '/';
$assetsVehicleDir = $pkgDir . 'xPDO/Transport/xPDOFileVehicle/' . $assetsSig . '/' . PKG_NAME_LOWER . '/';

echo "Copying core files...\n";
mb_copy_dir($coreSrc, $coreVehicleDir);
echo "Copying assets files...\n";
mb_copy_dir($assetsSrc, $assetsVehicleDir);

$license = file_get_contents($coreSrc . 'docs/license.txt');
$readme = file_get_contents($coreSrc . 'docs/readme.txt');
$changelog = file_get_contents($coreSrc . 'docs/changelog.txt');

$manifestVehicles = [];

$nsFile = 'MODX/Revolution/modNamespace/' . $nsSig . '.vehicle';
mb_write_vehicle($pkgDir . $nsFile, [
    'unique_key' => 'name',
    'preserve_keys' => true,
    'update_object' => true,
    'resolve_files' => true,
    'resolve_php' => true,
    'namespace' => PKG_NAME_LOWER,
    'resolve' => null,
    'validate' => null,
    'vehicle_class' => 'xPDO\\Transport\\xPDOObjectVehicle',
    'guid' => $nsGuid,
    'package' => '',
    'class' => 'MODX\\Revolution\\modNamespace',
    'signature' => $nsSig,
    'native_key' => PKG_NAME_LOWER,
    'object' => json_encode([
        'name' => PKG_NAME_LOWER,
        'path' => '{core_path}components/' . PKG_NAME_LOWER . '/',
        'assets_path' => '{assets_path}components/' . PKG_NAME_LOWER . '/',
    ]),
]);
$manifestVehicles[] = [
    'vehicle_package' => '',
    'vehicle_class' => 'xPDO\\Transport\\xPDOObjectVehicle',
    'class' => 'MODX\\Revolution\\modNamespace',
    'guid' => $nsGuid,
    'native_key' => PKG_NAME_LOWER,
    'filename' => $nsFile,
    'namespace' => PKG_NAME_LOWER,
];

$resolvers = [];
foreach (['resolve.tables', 'resolve.widget'] as $name) {
    $src = $root . '_build/resolvers/' . $name . '.php';
    if (!is_file($src)) {
        continue;
    }
    $resolverFile = 'xPDO/Transport/xPDOFileVehicle/' . $coreSig . '.' . $name . '.resolver';
    copy($src, $pkgDir . $resolverFile);
    $resolvers[] = [
        'type' => 'php',
        'body' => json_encode([
            'source' => $signature . '/' . $resolverFile,
            'type' => 'php',
            'name' => $name,
        ]),
    ];
}

$coreFile = 'xPDO/Transport/xPDOFileVehicle/' . $coreSig . '.vehicle';
mb_write_vehicle($pkgDir . $coreFile, [
    'class' => 'xPDO\\Transport\\xPDOFileVehicle',
    'object' => [
        'source' => $signature . '/xPDO/Transport/xPDOFileVehicle/' . $coreSig . '/',
        'target' => "return MODX_CORE_PATH . 'components/';",
        'name' => PKG_NAME_LOWER,
    ],
    'vehicle_class' => 'xPDO\\Transport\\xPDOFileVehicle',
    'abort_install_on_vehicle_fail' => true,
    'namespace' => PKG_NAME_LOWER,
    'resolve' => $resolvers ?: null,
    'validate' => null,
    'guid' => $coreGuid,
    'package' => '',
    'signature' => $coreSig,
    'native_key' => $coreGuid,
]);
$manifestVehicles[] = [
    'vehicle_package' => '',
    'vehicle_class' => 'xPDO\\Transport\\xPDOFileVehicle',
    'class' => 'xPDO\\Transport\\xPDOFileVehicle',
    'guid' => $coreGuid,
    'native_key' => $coreGuid,
    'filename' => $coreFile,
    'namespace' => PKG_NAME_LOWER,
];

$assetsFile = 'xPDO/Transport/xPDOFileVehicle/' . $assetsSig . '.vehicle';
mb_write_vehicle($pkgDir . $assetsFile, [
    'class' => 'xPDO\\Transport\\xPDOFileVehicle',
    'object' => [
        'source' => $signature . '/xPDO/Transport/xPDOFileVehicle/' . $assetsSig . '/',
        'target' => "return MODX_ASSETS_PATH . 'components/';",
        'name' => PKG_NAME_LOWER,
    ],
    'vehicle_class' => 'xPDO\\Transport\\xPDOFileVehicle',
    'abort_install_on_vehicle_fail' => true,
    'namespace' => PKG_NAME_LOWER,
    'resolve' => null,
    'validate' => null,
    'guid' => $assetsGuid,
    'package' => '',
    'signature' => $assetsSig,
    'native_key' => $assetsGuid,
]);
$manifestVehicles[] = [
    'vehicle_package' => '',
    'vehicle_class' => 'xPDO\\Transport\\xPDOFileVehicle',
    'class' => 'xPDO\\Transport\\xPDOFileVehicle',
    'guid' => $assetsGuid,
    'native_key' => $assetsGuid,
    'filename' => $assetsFile,
    'namespace' => PKG_NAME_LOWER,
];

$catFile = 'MODX/Revolution/modCategory/' . $catSig . '.vehicle';
mb_write_vehicle($pkgDir . $catFile, [
    'unique_key' => 'category',
    'preserve_keys' => false,
    'update_object' => true,
    'namespace' => PKG_NAME_LOWER,
    'resolve' => null,
    'validate' => null,
    'vehicle_class' => 'xPDO\\Transport\\xPDOObjectVehicle',
    'guid' => $catGuid,
    'package' => '',
    'class' => 'MODX\\Revolution\\modCategory',
    'signature' => $catSig,
    'native_key' => null,
    'object' => json_encode([
        'parent' => 0,
        'category' => PKG_NAME,
        'rank' => 0,
    ]),
]);
$manifestVehicles[] = [
    'vehicle_package' => '',
    'vehicle_class' => 'xPDO\\Transport\\xPDOObjectVehicle',
    'class' => 'MODX\\Revolution\\modCategory',
    'guid' => $catGuid,
    'native_key' => null,
    'filename' => $catFile,
    'namespace' => PKG_NAME_LOWER,
];

$menuFile = 'MODX/Revolution/modMenu/' . $menuSig . '.vehicle';
mb_write_vehicle($pkgDir . $menuFile, [
    'unique_key' => 'text',
    'preserve_keys' => true,
    'update_object' => true,
    'namespace' => PKG_NAME_LOWER,
    'resolve' => null,
    'validate' => null,
    'vehicle_class' => 'xPDO\\Transport\\xPDOObjectVehicle',
    'guid' => $menuGuid,
    'package' => '',
    'class' => 'MODX\\Revolution\\modMenu',
    'signature' => $menuSig,
    'native_key' => PKG_NAME,
    'object' => json_encode([
        'text' => PKG_NAME,
        'parent' => 'components',
        'action' => 'home',
        'description' => 'managerbuttons_menu_desc',
        'icon' => '',
        'menuindex' => 0,
        'params' => '',
        'handler' => '',
        'permissions' => '',
        'namespace' => PKG_NAME_LOWER,
    ]),
]);
$manifestVehicles[] = [
    'vehicle_package' => '',
    'vehicle_class' => 'xPDO\\Transport\\xPDOObjectVehicle',
    'class' => 'MODX\\Revolution\\modMenu',
    'guid' => $menuGuid,
    'native_key' => PKG_NAME,
    'filename' => $menuFile,
    'namespace' => PKG_NAME_LOWER,
];

$manifest = [
    'manifest-version' => '1.1',
    'manifest-attributes' => [
        'license' => $license,
        'readme' => $readme,
        'changelog' => $changelog,
        'requires' => [
            'php' => '>=8.1.0',
            'modx' => '>=3.0.0',
            'vuetools' => '>=1.2.0',
        ],
    ],
    'manifest-vehicles' => $manifestVehicles,
];
mb_write_vehicle($pkgDir . 'manifest.php', $manifest);

if (!is_dir($outDir) && !mkdir($outDir, 0777, true) && !is_dir($outDir)) {
    throw new RuntimeException('Cannot create ' . $outDir);
}

$zipPath = $outDir . $signature . '.transport.zip';
echo "Writing {$zipPath}...\n";
mb_zip_dir($buildDir, $zipPath);

$tmpCleanup = static function (string $dir): void {
    if (!is_dir($dir)) {
        return;
    }
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($files as $file) {
        $file->isDir() ? rmdir($file->getPathname()) : unlink($file->getPathname());
    }
    rmdir($dir);
};
$tmpCleanup($buildDir);

echo "Package: {$zipPath}\n";
echo 'Size: ' . round(filesize($zipPath) / 1024, 1) . " KB\n";
