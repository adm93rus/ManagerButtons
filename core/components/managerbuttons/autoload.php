<?php

spl_autoload_register(static function (string $class): void {
    $prefix = 'ManagerButtons\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $relative = str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    $file = __DIR__ . '/src/' . $relative;
    if (is_file($file)) {
        require_once $file;
    }
});
