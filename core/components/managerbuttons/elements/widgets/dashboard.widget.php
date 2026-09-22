<?php

use ManagerButtons\Icons;
use ManagerButtons\Service;
use MODX\Revolution\modDashboardWidgetInterface;

class ManagerButtonsDashboardWidget extends modDashboardWidgetInterface
{
    public function render()
    {
        $this->modx->lexicon->load('managerbuttons:default');

        if ($this->modx->services->has('managerbuttons')) {
            $service = $this->modx->services->get('managerbuttons');
        } else {
            $service = new Service($this->modx);
        }

        $properties = $this->widget->get('properties');
        if (is_string($properties)) {
            $decoded = json_decode($properties, true);
            $properties = is_array($decoded) ? $decoded : [];
        }
        if (!is_array($properties)) {
            $properties = [];
        }
        $groupId = (int) ($properties['group_id'] ?? 0);
        $groups = $service->getDashboardGroups($groupId ?: null);

        $widgetKey = 'managerbuttons-widget-' . (int) $this->widget->get('id');
        $payload = [
            'id' => $widgetKey,
            'groups' => $groups,
            'emptyText' => $this->modx->lexicon('managerbuttons_widget_empty'),
            'appearance' => $service->getAppearance(),
        ];

        $js = $service->versionedAsset('js/mgr/vue-dist/widget.min.js');
        $css = $service->versionedAsset('css/mgr/vue-dist/widget.min.css');
        $cssFile = $this->modx->getOption('assets_path') . 'components/managerbuttons/css/mgr/vue-dist/widget.min.css';
        if (is_file($cssFile)) {
            $this->controller->addCss($css);
        }
        $service->addVueModule($this->controller, $js);

        $json = htmlspecialchars(json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), ENT_QUOTES);

        $fallback = $this->renderFallback($groups);

        return '<div id="' . htmlspecialchars($widgetKey, ENT_QUOTES) . '" class="vueApp managerbuttons-widget" data-payload="' . $json . '">' . $fallback . '</div>';
    }

    /**
     * @param list<array<string, mixed>> $groups
     */
    protected function renderFallback(array $groups): string
    {
        if ($groups === []) {
            return '<p>' . htmlspecialchars($this->modx->lexicon('managerbuttons_widget_empty'), ENT_QUOTES) . '</p>';
        }
        $html = '';
        foreach ($groups as $group) {
            $html .= '<h3>' . htmlspecialchars((string) $group['name'], ENT_QUOTES) . '</h3>';
            $html .= '<p>';
            foreach ($group['buttons'] as $button) {
                $icon = Icons::cssClass((string) $button['icon']);
                $html .= '<a href="' . htmlspecialchars((string) $button['url'], ENT_QUOTES) . '">';
                $html .= '<i class="' . htmlspecialchars($icon, ENT_QUOTES) . '"></i> ';
                $html .= htmlspecialchars((string) $button['name'], ENT_QUOTES);
                if (!empty($button['description'])) {
                    $html .= ' <small>' . htmlspecialchars((string) $button['description'], ENT_QUOTES) . '</small>';
                }
                $html .= '</a> ';
            }
            $html .= '</p>';
        }

        return $html;
    }
}

return ManagerButtonsDashboardWidget::class;
