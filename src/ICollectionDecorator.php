<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Objectify\Collection;

/**
 * Интерфейс декоратора Bitrix\Main\ORM\Objectify\Collection
 *
 * @method add(EntityObject $object)
 */
interface ICollectionDecorator extends \ArrayAccess, \Iterator, \Countable
{
    /**
     * Возвращает коллекцию битрикс
     */
    public function getCollection(): Collection;

    /**
     * Находит первое вхождение
     *
     * @param mixed $value
     */
    public function getFirstOccurrence(string $fieldName, $value): ?IEntityObjectDecorator;
}
