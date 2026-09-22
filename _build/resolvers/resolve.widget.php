<?php
/**
 * Place the ManagerButtons widget on the Default dashboard if it is missing.
 *
 * @var xPDOTransport $transport
 * @var array $options
 */

use MODX\Revolution\modDashboard;
use MODX\Revolution\modDashboardWidget;
use MODX\Revolution\modDashboardWidgetPlacement;
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

/** @var modDashboardWidget|null $widget */
$widget = $modx->getObject(modDashboardWidget::class, ['name' => 'managerbuttons.widget']);
if (!$widget) {
    $widget = $modx->newObject(modDashboardWidget::class);
    $widget->fromArray([
        'name' => 'managerbuttons.widget',
        'description' => 'managerbuttons.widget_desc',
        'type' => 'file',
        'content' => '[[++core_path]]components/managerbuttons/elements/widgets/dashboard.widget.php',
        'namespace' => 'managerbuttons',
        'lexicon' => 'managerbuttons:default',
        'size' => 'full',
    ], '', true);
    $widget->set('properties', ['group_id' => '']);
    $widget->save();
}

$props = $widget ? $widget->get('properties') : null;
if (is_string($props)) {
    $decoded = json_decode($props, true);
    $props = is_array($decoded) ? $decoded : [];
}
if ($widget && !is_array($props)) {
    $props = [];
}
if ($widget && !array_key_exists('group_id', $props)) {
    $props['group_id'] = '';
    $widget->set('properties', $props);
    $widget->save();
}

$dashboard = $modx->getObject(modDashboard::class, ['name' => 'Default']);
if (!$dashboard) {
    $dashboard = $modx->getObject(modDashboard::class, ['id' => 1]);
}
if ($dashboard && $widget) {
    $fields = $modx->getFields(modDashboardWidgetPlacement::class) ?: [];
    $criteria = [
        'dashboard' => (int) $dashboard->get('id'),
        'widget' => (int) $widget->get('id'),
    ];
    if (array_key_exists('user', $fields)) {
        $criteria['user'] = 0;
    }
    $exists = $modx->getObject(modDashboardWidgetPlacement::class, $criteria);
    if (!$exists) {
        $c = $modx->newQuery(modDashboardWidgetPlacement::class);
        $c->where(['dashboard' => $dashboard->get('id')]);
        $c->select('MAX(' . $modx->escape('rank') . ')');
        $max = (int) $modx->getValue($c->prepare());
        $placement = $modx->newObject(modDashboardWidgetPlacement::class);
        $data = [
            'dashboard' => (int) $dashboard->get('id'),
            'widget' => (int) $widget->get('id'),
            'rank' => $max + 1,
        ];
        if (array_key_exists('user', $fields)) {
            $data['user'] = 0;
        }
        if (array_key_exists('size', $fields)) {
            $data['size'] = 'full';
        }
        $placement->fromArray($data, '', true);
        $placement->save();
        $modx->log(\MODX\Revolution\modX::LOG_LEVEL_INFO, '[ManagerButtons] Widget placed on the Default dashboard.');
    }
}

return true;
