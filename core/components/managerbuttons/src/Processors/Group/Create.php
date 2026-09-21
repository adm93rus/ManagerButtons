<?php

namespace ManagerButtons\Processors\Group;

use ManagerButtons\Model\ButtonGroup;
use ManagerButtons\Processors\ProcessorBase;

class Create extends ProcessorBase
{
    public function process()
    {
        $name = trim((string) $this->getProperty('name', ''));
        if ($name === '') {
            return $this->failure($this->modx->lexicon('managerbuttons_err_name'));
        }
        if ($this->modx->getCount(ButtonGroup::class, ['name' => $name])) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_name_ae'));
        }

        /** @var ButtonGroup $group */
        $group = $this->modx->newObject(ButtonGroup::class);
        $group->fromArray([
            'name' => $name,
            'rank' => $this->service->nextGroupRank(),
            'createdon' => date('Y-m-d H:i:s'),
            'createdby' => (int) $this->modx->user->get('id'),
        ], '', true);
        if (!$group->save()) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_save'));
        }

        $this->service->syncGroupUserGroups((int) $group->get('id'), $this->intList('usergroup_ids'));

        return $this->success($this->modx->lexicon('managerbuttons_group_created'), [
            'id' => (int) $group->get('id'),
        ]);
    }
}
