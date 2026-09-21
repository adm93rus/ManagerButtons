<?php

namespace ManagerButtons\Processors\Button;

use ManagerButtons\Processors\ProcessorBase;

class Sort extends ProcessorBase
{
    public function process()
    {
        $groupId = (int) $this->getProperty('group_id');
        $ids = $this->intList('ids');
        if ($groupId <= 0 || $ids === []) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_ns'));
        }
        $this->service->sortButtons($groupId, $ids);

        return $this->success();
    }
}
