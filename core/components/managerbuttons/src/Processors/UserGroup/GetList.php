<?php

namespace ManagerButtons\Processors\UserGroup;

use ManagerButtons\Processors\ProcessorBase;
use MODX\Revolution\modUserGroup;

class GetList extends ProcessorBase
{
    public function process()
    {
        $query = trim((string) $this->getProperty('query', ''));
        $c = $this->modx->newQuery(modUserGroup::class);
        $c->where(['id:!=' => 0]);
        if ($query !== '') {
            $c->where(['name:LIKE' => '%' . $query . '%']);
        }
        $c->sortby('name', 'ASC');
        $rows = [];
        foreach ($this->modx->getIterator(modUserGroup::class, $c) as $group) {
            $rows[] = [
                'id' => (int) $group->get('id'),
                'name' => (string) $group->get('name'),
            ];
        }

        return $this->outputArray($rows, count($rows));
    }
}
