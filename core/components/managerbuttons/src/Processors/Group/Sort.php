<?php

namespace ManagerButtons\Processors\Group;

use ManagerButtons\Processors\ProcessorBase;

class Sort extends ProcessorBase
{
    public function process()
    {
        $ids = $this->intList('ids');
        if ($ids === []) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_ns'));
        }
        $this->service->sortGroups($ids);

        return $this->success();
    }
}
