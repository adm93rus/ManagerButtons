<?php
/**
 * Grant the managerbuttons permission to the Administrator policy.
 *
 * @var xPDOTransport $transport
 * @var array $options
 */

use MODX\Revolution\modAccessPermission;
use MODX\Revolution\modAccessPolicy;
use xPDO\Transport\xPDOTransport;

$modx = $transport->xpdo ?? null;
if (!$modx) {
    return true;
}

$action = $options[xPDOTransport::PACKAGE_ACTION] ?? null;
if (!in_array($action, [xPDOTransport::ACTION_INSTALL, xPDOTransport::ACTION_UPGRADE], true)) {
    return true;
}

$modx->lexicon->load('managerbuttons:default');

/** @var modAccessPolicy|null $policy */
$policy = $modx->getObject(modAccessPolicy::class, ['name' => 'Administrator']);
if ($policy) {
    $templateId = (int) $policy->get('template');
    if ($templateId > 0) {
        $perm = $modx->getObject(modAccessPermission::class, [
            'template' => $templateId,
            'name' => 'managerbuttons',
        ]);
        if (!$perm) {
            $perm = $modx->newObject(modAccessPermission::class);
            $perm->fromArray([
                'template' => $templateId,
                'name' => 'managerbuttons',
                'description' => 'managerbuttons_permission_desc',
                'value' => 1,
            ], '', true);
            $perm->save();
        }
    }

    $data = $policy->get('data');
    if (is_string($data)) {
        $decoded = $modx->fromJSON($data);
        $data = is_array($decoded) ? $decoded : [];
    }
    if (!is_array($data)) {
        $data = [];
    }
    if (empty($data['managerbuttons'])) {
        $data['managerbuttons'] = true;
        $policy->set('data', $data);
        $policy->save();
    }
}

$cacheRoot = rtrim((string) $modx->getCachePath(), '/\\');
$topicRoot = $cacheRoot . '/lexicon_topics/lexicon';
if (is_dir($topicRoot)) {
    foreach (glob($topicRoot . '/*/managerbuttons', GLOB_ONLYDIR) ?: [] as $dir) {
        foreach (glob($dir . '/*') ?: [] as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}

if ($modx->getCacheManager()) {
    $modx->cacheManager->refresh([
        'access' => [],
        'namespaces' => [],
        'lexicon_topics' => [],
    ]);
}

$modx->log(\MODX\Revolution\modX::LOG_LEVEL_INFO, '[ManagerButtons] Permission managerbuttons is on the Administrator policy. Sign in again if the menu item is missing.');

return true;
