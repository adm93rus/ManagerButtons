<?php

namespace ManagerButtons\Processors\Widget;

use ManagerButtons\Processors\ProcessorBase;

class GetList extends ProcessorBase
{
    public function checkPermissions()
    {
        return $this->modx->user && $this->modx->user->hasSessionContext('mgr');
    }

    public function process()
    {
        $groupId = (int) $this->getProperty('group_id', 0);
        $groups = $this->service->getDashboardGroups($groupId ?: null);

        return $this->outputArray($groups, count($groups));
    }
}
