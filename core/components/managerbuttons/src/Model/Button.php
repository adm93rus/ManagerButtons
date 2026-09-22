<?php

namespace ManagerButtons\Model;

use xPDO\Om\xPDOSimpleObject;

/**
 * @property int $id
 * @property int $group_id
 * @property string $name
 * @property string $url
 * @property string $icon
 * @property string $description
 * @property string $background
 * @property int $cols
 * @property int $rank
 *
 * @property ButtonGroup $Group
 */
class Button extends xPDOSimpleObject
{
}
