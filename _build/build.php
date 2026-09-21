<?php
/**
 * Build ManagerButtons.
 *
 * Preferred: php _build/pack.php (no live MODX required).
 * If this file is run from a MODX tree, it still delegates to pack.php
 * so the zip in _packages/ stays the source of truth.
 */

$pack = __DIR__ . '/pack.php';
if (!is_file($pack)) {
    fwrite(STDERR, "pack.php is missing.\n");
    exit(1);
}

passthru('php ' . escapeshellarg($pack), $code);
exit($code);
