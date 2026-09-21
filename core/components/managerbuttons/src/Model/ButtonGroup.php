<?php

namespace ManagerButtons\Model;

use xPDO\Om\xPDOSimpleObject;

/**
 * @property int $id
 * @property string $name
 * @property int $rank
 * @property string $createdon
 * @property int $createdby
 *
 * @property Button[] $Buttons
 * @property GroupUserGroup[] $UserGroups
 */
class ButtonGroup extends xPDOSimpleObject
{
}
