<?php

namespace ManagerButtons\Processors\Group;

use ManagerButtons\Model\Button;
use ManagerButtons\Model\ButtonGroup;
use ManagerButtons\Processors\ProcessorBase;

class Get extends ProcessorBase
{
    public function process()
    {
        $id = (int) $this->getProperty('id');
        /** @var ButtonGroup|null $group */
        $group = $this->modx->getObject(ButtonGroup::class, $id);
        if (!$group) {
            return $this->failure($this->modx->lexicon('managerbuttons_err_group_nf'));
        }
        $usergroups = $this->service->getGroupUserGroups($id);

        return $this->success('', [
            'id' => $id,
            'name' => (string) $group->get('name'),
            'rank' => (int) $group->get('rank'),
            'usergroups' => $usergroups,
            'usergroup_ids' => array_map(static fn ($ug) => $ug['id'], $usergroups),
            'buttons_count' => $this->modx->getCount(Button::class, ['group_id' => $id]),
        ]);
    }
}
