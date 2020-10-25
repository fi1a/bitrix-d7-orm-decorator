<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Bitrix\Main\ORM\Objectify\EntityObject;

/**
 * 1С-Битрикс D7 ORM объект
 */
class OriginalEntityObject extends EntityObject
{
    public static $dataClass = OriginalTable::class;
}
