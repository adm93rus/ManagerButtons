<?php

namespace ManagerButtons\Processors\Group;

use ManagerButtons\Model\ButtonGroup;
use ManagerButtons\Processors\ProcessorBase;

class Remove extends ProcessorBase
{
    public function process()
    {
        $ids = $this->intList('ids');
        $single = (int) $this->getProperty('id');
        if ($single > 0) {
            $ids[] = $single;
        }
        $ids = array_values(array_unique(array_filter($ids)));
        if ($ids === []) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_ns'));
        }

        $removed = 0;
        foreach ($ids as $id) {
            /** @var ButtonGroup|null $group */
            $group = $this->modx->getObject(ButtonGroup::class, $id);
            if ($group && $this->service->removeGroup($group)) {
                $removed++;
            }
        }
        if ($removed === 0) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_remove'));
        }

        return $this->success($this->modx->lexicon('managerbuttons_group_removed'), [
            'removed' => $removed,
        ]);
    }
}
