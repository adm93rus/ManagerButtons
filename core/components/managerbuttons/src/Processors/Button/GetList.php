<?php

namespace ManagerButtons\Processors\Button;

use ManagerButtons\Model\Button;
use ManagerButtons\Processors\ProcessorBase;

class GetList extends ProcessorBase
{
    public function process()
    {
        $groupId = (int) $this->getProperty('group_id');
        if ($groupId <= 0) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_group_ns'));
        }
        $c = $this->modx->newQuery(Button::class);
        $c->where(['group_id' => $groupId]);
        $c->sortby('rank', 'ASC');
        $c->sortby('id', 'ASC');
        $rows = [];
        foreach ($this->modx->getIterator(Button::class, $c) as $button) {
            $rows[] = [
                'id' => (int) $button->get('id'),
                'group_id' => (int) $button->get('group_id'),
                'name' => (string) $button->get('name'),
                'url' => (string) $button->get('url'),
                'icon' => (string) $button->get('icon'),
                'icon_class' => \ManagerButtons\Icons::cssClass((string) $button->get('icon')),
                'cols' => $this->service->normalizeCols($button->get('cols')),
                'rank' => (int) $button->get('rank'),
            ];
        }

        return $this->outputArray($rows, count($rows));
    }
}
