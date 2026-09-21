<?php

namespace ManagerButtons\Model\mysql;

use xPDO\Om\xPDOObject;

class ButtonGroup extends \ManagerButtons\Model\ButtonGroup
{
    public static $metaMap = [
        'package' => 'ManagerButtons\\Model',
        'version' => '3.0',
        'table' => 'managerbuttons_groups',
        'extends' => 'xPDO\\Om\\xPDOSimpleObject',
        'tableMeta' => [
            'engine' => 'InnoDB',
        ],
        'fields' => [
            'name' => '',
            'rank' => 0,
            'createdon' => null,
            'createdby' => 0,
        ],
        'fieldMeta' => [
            'name' => [
                'dbtype' => 'varchar',
                'precision' => '255',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ],
            'rank' => [
                'dbtype' => 'int',
                'precision' => '10',
                'attributes' => 'unsigned',
                'phptype' => 'integer',
                'null' => false,
                'default' => 0,
            ],
            'createdon' => [
                'dbtype' => 'datetime',
                'phptype' => 'datetime',
                'null' => true,
            ],
            'createdby' => [
                'dbtype' => 'int',
                'precision' => '10',
                'attributes' => 'unsigned',
                'phptype' => 'integer',
                'null' => false,
                'default' => 0,
            ],
        ],
        'indexes' => [
            'rank' => [
                'alias' => 'rank',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => [
                    'rank' => [
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ],
                ],
            ],
        ],
        'composites' => [
            'Buttons' => [
                'class' => 'ManagerButtons\\Model\\Button',
                'local' => 'id',
                'foreign' => 'group_id',
                'cardinality' => 'many',
                'owner' => 'local',
            ],
            'UserGroups' => [
                'class' => 'ManagerButtons\\Model\\GroupUserGroup',
                'local' => 'id',
                'foreign' => 'group_id',
                'cardinality' => 'many',
                'owner' => 'local',
            ],
        ],
    ];
}
