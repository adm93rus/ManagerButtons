<?php

namespace ManagerButtons\Model\mysql;

use xPDO\Om\xPDOObject;

class Button extends \ManagerButtons\Model\Button
{
    public static $metaMap = [
        'package' => 'ManagerButtons\\Model',
        'version' => '3.0',
        'table' => 'managerbuttons_buttons',
        'extends' => 'xPDO\\Om\\xPDOSimpleObject',
        'tableMeta' => [
            'engine' => 'InnoDB',
        ],
        'fields' => [
            'group_id' => 0,
            'name' => '',
            'url' => '',
            'icon' => '',
            'description' => '',
            'background' => '',
            'cols' => 1,
            'rank' => 0,
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
            'name' => [
                'dbtype' => 'varchar',
                'precision' => '255',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ],
            'url' => [
                'dbtype' => 'varchar',
                'precision' => '2048',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ],
            'icon' => [
                'dbtype' => 'varchar',
                'precision' => '128',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ],
            'description' => [
                'dbtype' => 'varchar',
                'precision' => '500',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ],
            'background' => [
                'dbtype' => 'varchar',
                'precision' => '16',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ],
            'cols' => [
                'dbtype' => 'tinyint',
                'precision' => '1',
                'attributes' => 'unsigned',
                'phptype' => 'integer',
                'null' => false,
                'default' => 1,
            ],
            'rank' => [
                'dbtype' => 'int',
                'precision' => '10',
                'attributes' => 'unsigned',
                'phptype' => 'integer',
                'null' => false,
                'default' => 0,
            ],
        ],
        'indexes' => [
            'group_id' => [
                'alias' => 'group_id',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => [
                    'group_id' => [
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ],
                ],
            ],
            'group_rank' => [
                'alias' => 'group_rank',
                'primary' => false,
                'unique' => false,
                'type' => 'BTREE',
                'columns' => [
                    'group_id' => [
                        'length' => '',
                        'collation' => 'A',
                        'null' => false,
                    ],
                    'rank' => [
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
        ],
    ];
}
