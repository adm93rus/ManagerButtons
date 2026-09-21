<?php

namespace ManagerButtons\Model\mysql;

use xPDO\Om\xPDOObject;

class GroupUserGroup extends \ManagerButtons\Model\GroupUserGroup
{
    public static $metaMap = [
        'package' => 'ManagerButtons\\Model',
        'version' => '3.0',
        'table' => 'managerbuttons_group_usergroups',
        'extends' => 'xPDO\\Om\\xPDOSimpleObject',
        'tableMeta' => [
            'engine' => 'InnoDB',
        ],
        'fields' => [
            'group_id' => 0,
            'usergroup_id' => 0,
        ],
        'fieldMeta' => [
            'group_id' => [
                'dbtype' => 'int',
                'precision' => '10',
                'attributes' => 'unsigned',
                'phptype' => 'integer',
                'null' => false,
                'default' => 0,
                'index' => 'index',
            ],
            'usergroup_id' => [
                'dbtype' => 'int',
                'precision' => '10',
                'attributes' => 'unsigned',
                'phptype' => 'integer',
                'null' => false,
                'default' => 0,
                'index' => 'index',
            ],
        ],
        'indexes' => [
            'group_usergroup' => [
                'alias' => 'group_usergroup',
                'primary' => false,
                'unique' => true,
                'type' => 'BTREE',
                'columns' => [
                    'group_id' => [
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ],
                    'usergroup_id' => [
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ],
                ],
            ],
        ],
        'aggregates' => [
            'Group' => [
                'class' => 'ManagerButtons\\Model\\ButtonGroup',
                'local' => 'group_id',
                'foreign' => 'id',
                'cardinality' => 'one',
                'owner' => 'foreign',
            ],
            'UserGroup' => [
                'class' => 'MODX\\Revolution\\modUserGroup',
                'local' => 'usergroup_id',
                'foreign' => 'id',
                'cardinality' => 'one',
                'owner' => 'foreign',
            ],
        ],
    ];
}
