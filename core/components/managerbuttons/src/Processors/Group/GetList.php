<?php

namespace ManagerButtons\Processors\Group;

use ManagerButtons\Model\Button;
use ManagerButtons\Model\ButtonGroup;
use ManagerButtons\Processors\ProcessorBase;

class GetList extends ProcessorBase
{
    public function process()
    {
        $limit = (int) $this->getProperty('limit', 20);
        $start = (int) $this->getProperty('start', 0);
        $query = trim((string) $this->getProperty('query', ''));

        $c = $this->modx->newQuery(ButtonGroup::class);
        if ($query !== '') {
            $c->where(['name:LIKE' => '%' . $query . '%']);
        }
        $total = $this->modx->getCount(ButtonGroup::class, clone $c);
        $this->service->applyRankOrder($c);
        if ($limit > 0) {
            $c->limit($limit, $start);
        }

        $rows = [];
        foreach ($this->modx->getIterator(ButtonGroup::class, $c) as $group) {
            $id = (int) $group->get('id');
            $usergroups = $this->service->getGroupUserGroups($id);
            $rows[] = [
                'id' => $id,
                'name' => (string) $group->get('name'),
                'rank' => (int) $group->get('rank'),
                'createdon' => (string) $group->get('createdon'),
                'buttons_count' => $this->modx->getCount(Button::class, ['group_id' => $id]),
                'usergroups' => $usergroups,
                'usergroup_ids' => array_map(static fn ($ug) => $ug['id'], $usergroups),
                'usergroup_names' => array_map(static fn ($ug) => $ug['name'], $usergroups),
            ];
        }

        return $this->outputArray($rows, $total);
    }
}
