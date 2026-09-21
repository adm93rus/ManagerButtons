<?php

namespace ManagerButtons\Processors\Group;

use ManagerButtons\Model\ButtonGroup;
use ManagerButtons\Processors\ProcessorBase;

class Update extends ProcessorBase
{
    public function process()
    {
        $id = (int) $this->getProperty('id');
        /** @var ButtonGroup|null $group */
        $group = $this->modx->getObject(ButtonGroup::class, $id);
        if (!$group) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_group_nf'));
        }
        $name = trim((string) $this->getProperty('name', $group->get('name')));
        if ($name === '') {
            return $this->failure($this->modx->lexicon('managerbuttons_err_name'));
        }
        $exists = $this->modx->getObject(ButtonGroup::class, ['name' => $name]);
        if ($exists && (int) $exists->get('id') !== $id) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_name_ae'));
        }
        $group->set('name', $name);
        if (!$group->save()) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_save'));
        }
        if ($this->getProperty('usergroup_ids') !== null) {
            $this->service->syncGroupUserGroups($id, $this->intList('usergroup_ids'));
        }

        return $this->success($this->modx->lexicon('managerbuttons_group_updated'), [
            'id' => $id,
        ]);
    }
}
