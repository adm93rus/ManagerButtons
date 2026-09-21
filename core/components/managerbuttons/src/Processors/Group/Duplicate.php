<?php

namespace ManagerButtons\Processors\Group;

use ManagerButtons\Model\ButtonGroup;
use ManagerButtons\Processors\ProcessorBase;

class Duplicate extends ProcessorBase
{
    public function process()
    {
        $id = (int) $this->getProperty('id');
        /** @var ButtonGroup|null $group */
        $group = $this->modx->getObject(ButtonGroup::class, $id);
        if (!$group) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_group_nf'));
        }
        try {
            $copy = $this->service->duplicateGroup($group);
        } catch (\Throwable $e) {
            return $this->failure($e->getMessage());
        }

        return $this->success($this->modx->lexicon('managerbuttons_group_duplicated'), [
            'id' => (int) $copy->get('id'),
            'name' => (string) $copy->get('name'),
        ]);
    }
}
