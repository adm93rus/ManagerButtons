<?php
/**
 * @var xPDOTransport $transport
 * @var array $options
 */

use ManagerButtons\Service;
use xPDO\Transport\xPDOTransport;

$modx = $transport->xpdo ?? null;
if (!$modx) {
    return true;
}

$action = $options[xPDOTransport::PACKAGE_ACTION] ?? null;
if (!in_array($action, [xPDOTransport::ACTION_INSTALL, xPDOTransport::ACTION_UPGRADE], true)) {
    return true;
}

$corePath = MODX_CORE_PATH . 'components/managerbuttons/';
require_once $corePath . 'autoload.php';
$modx->addPackage('ManagerButtons\\Model', $corePath . 'src/', null, 'ManagerButtons\\');

if ($modx->services->has('managerbuttons')) {
    $service = $modx->services->get('managerbuttons');
} else {
    $service = new Service($modx);
}
$service->createTables();

$modx->log(\MODX\Revolution\modX::LOG_LEVEL_INFO, '[ManagerButtons] Database tables are ready.');

return true;
