<?php

if (php_sapi_name() !== 'cli') {
    @ini_set('display_errors', '0');
}

try {
    $configCore = dirname(__FILE__, 4) . '/config.core.php';
    if (!file_exists($configCore)) {
        $configCore = dirname(__FILE__, 5) . '/config.core.php';
    }
    require_once $configCore;
    require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
    require_once MODX_CONNECTORS_PATH . 'index.php';

    $autoload = MODX_CORE_PATH . 'components/managerbuttons/autoload.php';
    if (is_file($autoload)) {
        require_once $autoload;
    }
    $modx->lexicon->load('managerbuttons:default');
    $modx->getRequest();
    $modx->request->handleRequest([
        'processors_path' => $modx->getOption('core_path') . 'components/managerbuttons/src/Processors/',
        'location' => '',
    ]);
} catch (Throwable $e) {
    header('Content-Type: application/json; charset=UTF-8');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}
