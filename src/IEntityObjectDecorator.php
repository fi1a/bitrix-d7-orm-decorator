<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Objectify\EntityObject;

/**
 * Интерфейс декоратора \Bitrix\Main\ORM\Objectify\EntityObject
 */
interface IEntityObjectDecorator extends \ArrayAccess
{
    /**
     * Возвращает объект Bitrix\Main\ORM\Objectify\EntityObject
     */
    public function getEntityObject(): EntityObject;
}
