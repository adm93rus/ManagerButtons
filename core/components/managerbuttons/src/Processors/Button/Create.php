<?php

namespace ManagerButtons\Processors\Button;

use ManagerButtons\Color;
use ManagerButtons\Icons;
use ManagerButtons\Model\Button;
use ManagerButtons\Model\ButtonGroup;
use ManagerButtons\Processors\ProcessorBase;

class Create extends ProcessorBase
{
    public function process()
    {
        $groupId = (int) $this->getProperty('group_id');
        if (!$this->modx->getCount(ButtonGroup::class, ['id' => $groupId])) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_group_nf'));
        }
        $name = trim((string) $this->getProperty('name', ''));
        $url = trim((string) $this->getProperty('url', ''));
        if ($name === '' || $url === '') {
            return $this->failure($this->modx->lexicon('managerbuttons_err_button_fields'));
        }

        /** @var Button $button */
        $button = $this->modx->newObject(Button::class);
        $button->fromArray([
            'group_id' => $groupId,
            'name' => $name,
            'url' => $url,
            'icon' => Icons::normalizeName((string) $this->getProperty('icon', '')),
            'description' => $this->service->cleanDescription((string) $this->getProperty('description', '')),
            'background' => Color::normalize((string) $this->getProperty('background', '')),
            'cols' => $this->service->normalizeCols($this->getProperty('cols', 1)),
            'rank' => $this->service->nextButtonRank($groupId),
        ], '', true);
        if (!$button->save()) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_save'));
        }

        return $this->success($this->modx->lexicon('managerbuttons_button_created'), [
            'id' => (int) $button->get('id'),
        ]);
    }
}
