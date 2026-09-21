<?php

namespace ManagerButtons\Processors\Group;

use ManagerButtons\Model\ButtonGroup;
use ManagerButtons\Processors\ProcessorBase;

class Remove extends ProcessorBase
{
    public function process()
    {
        $id = (int) $this->getProperty('id');
        /** @var ButtonGroup|null $group */
        $group = $this->modx->getObject(ButtonGroup::class, $id);
        if (!$group) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_group_nf'));
        }
        if (!$this->service->removeGroup($group)) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_remove'));
        }

        return $this->success($this->modx->lexicon('managerbuttons_group_removed'));
    }
}
