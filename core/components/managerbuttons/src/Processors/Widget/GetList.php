<?php

namespace ManagerButtons\Processors\Widget;

use ManagerButtons\Processors\ProcessorBase;

class GetList extends ProcessorBase
{
    public function process()
    {
        $groupId = (int) $this->getProperty('group_id', 0);
        $groups = $this->service->getDashboardGroups($groupId ?: null);

        return $this->outputArray($groups, count($groups));
    }
}
