<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

/**
 * Интерфейс декоратора \Bitrix\Main\ORM\Query\Result
 *
 * @method void setHiddenObjectFields(string[] $hiddenObjectFields)
 * @method \Bitrix\Main\ORM\Fields\ScalarField[] getFields()
 * @method int getSelectedRowsCount()
 * @method self setIdentityMap(\Bitrix\Main\ORM\Objectify\IdentityMap $map)
 * @method \Bitrix\Main\ORM\Objectify\IdentityMap getIdentityMap()
 * @method resource|null getResource()
 * @method void setReplacedAliases(string[] $replacedAliases)
 * @method void addReplacedAliases(string[] $replacedAliases)
 * @method void setSerializedFields(mixed[] $serializedFields)
 * @method void addFetchDataModifier($fetchDataModifier)
 * @method mixed[]|false fetchRaw()
 * @method mixed[]|false fetch()
 * @method mixed[] fetchAll()
 * @method \Bitrix\Main\Diag\SqlTrackerQuery|null getTrackerQuery()
 * @method callable[] getConverters()
 * @method void setConverters(callable[] $converters)
 * @method void setCount(int $n)
 * @method int getCount()
 * @method \Traversable getIterator()
 */
interface IResultDecorator
{
    /**
     * Вернуть объект
     */
    public function fetchObject(): ?IObjectDecorator;

    /**
     * Вернуть коллекцию
     */
    public function fetchCollection(): ICollectionDecorator;
}
