<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Objectify\Collection;

/**
 * Интерфейс декоратора \Bitrix\Main\ORM\Objectify\Collection
 *
 * @method bool hasByPrimary($primary)
 * @method IObjectDecorator|false getByPrimary($primary)
 * @method IObjectDecorator[] getAll()
 * @method void removeByPrimary($primary)
 * @method \Bitrix\Main\ORM\Data\UpdateResult|\Bitrix\Main\ORM\Data\AddResult save(bool $ignoreEvents = false)
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
    public function getFirstOccurrence(string $fieldName, $value): ?IObjectDecorator;
}
