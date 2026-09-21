<?php

namespace ManagerButtons\Processors\Icon;

use ManagerButtons\Icons;
use ManagerButtons\Processors\ProcessorBase;

class GetList extends ProcessorBase
{
    public function process()
    {
        $query = mb_strtolower(trim((string) $this->getProperty('query', '')));
        $rows = Icons::catalog();
        if ($query !== '') {
            $rows = array_values(array_filter(
                $rows,
                static fn (array $row) => str_contains(mb_strtolower($row['name']), $query)
            ));
        }

        return $this->outputArray($rows, count($rows));
    }
}
