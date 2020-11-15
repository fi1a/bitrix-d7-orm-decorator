<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Objectify\Collection;
use Bitrix\Main\ORM\Query\Result;

/**
 * Декоратор \Bitrix\Main\ORM\Data\DataManager
 *
 * @method static getEntity(): \Bitrix\Main\ORM\Entity
 * @method static unsetEntity(string $class): void
 * @method static getTableName(): ?string
 * @method static getConnectionName(): string
 * @method static getTitle(): ?string
 * @method static getObjectClass(): string|\Bitrix\Main\ORM\Objectify\EntityObject
 * @method static getObjectClassName(): string
 * @method static getCollectionClass(): string
 * @method static getCollectionClassName(): string
 * @method static getObjectParentClass(): string
 * @method static getCollectionParentClass(): string
 * @method static getEntityClass(): string
 * @method static getMap(): mixed[]
 * @method static setDefaultScope(\Bitrix\Main\ORM\Query\Query $query): \Bitrix\Main\ORM\Query\Query
 * @method static getRowById(mixed $id): mixed[]|null
 * @method static getRow(mixed[] $parameters): mixed[]|null
 * @method static getCount(mixed[] $filter = [], mixed[] $cache = []): int
 * @method static getQueryClass(): string
 * @method static checkFields(\Bitrix\Main\ORM\Data\Result $result, $primary, mixed[] $data): void
 * @method static add(mixed[] $data): \Bitrix\Main\ORM\Data\AddResult
 * @method static addMulti(mixed[] $rows, bool $ignoreEvents = false): \Bitrix\Main\ORM\Data\AddResult
 * @method static update($primary, mixed[] $data): \Bitrix\Main\ORM\Data\UpdateResult
 * @method static updateMulti(mixed[] $primaries, mixed[] $data, bool $ignoreEvents = false)
 * : \Bitrix\Main\ORM\Data\UpdateResult
 * @method static delete(mixed $primary): \Bitrix\Main\ORM\Data\DeleteResult
 * @method static enableCrypto(string $field, string $table = null, bool $mode = true): void
 * @method static cryptoEnabled(string $field, string $table = null): bool
 */
abstract class ATableDecorator implements ITableDecorator
{
    /**
     * Возвращает класс таблицы
     */
    abstract protected static function doGetTableClass(): string;

    /**
     * Возвращает класс объекта
     */
    protected static function doGetEntityObjectDecoratorClass(): ?string
    {
        return null;
    }

    /**
     * Возвращает класс коллекции
     */
    protected static function doGetCollectionDecoratorClass(): ?string
    {
        return null;
    }

    /**
     * Executes the query and returns selection by parameters of the query.
     * This function is an alias to the Query object functions
     *
     * @param mixed[] $parameters
     *
     * @return IResultDecorator|Result
     */
    public static function getList(array $parameters = [])
    {
        $class = static::getTableClass();

        return static::getResultDecorator(call_user_func_array([$class, 'getList'], [$parameters]));
    }

    /**
     * Returns selection by entity's primary key
     *
     * @param mixed $id
     *
     * @return IResultDecorator|Result
     */
    public static function getById($id)
    {
        $class = static::getTableClass();

        return static::getResultDecorator(call_user_func_array([$class, 'getById'], [$id]));
    }

    /**
     * Returns selection by entity's primary key and optional parameters for getList()
     *
     * @param mixed $primary
     * @param mixed[] $parameters
     *
     * @return IResultDecorator|Result
     */
    public static function getByPrimary($primary, array $parameters = [])
    {
        $class = static::getTableClass();

        return static::getResultDecorator(
            call_user_func_array([$class, 'getByPrimary'], [$primary, $parameters])
        );
    }

    /**
     * Возвращает объект
     *
     * @return IEntityObjectDecorator|\Bitrix\Main\ORM\Objectify\EntityObject
     */
    public static function createObject(bool $setDefaultValues = true)
    {
        $class = static::getTableClass();
        /**
         * @var \Bitrix\Main\ORM\Data\DataManager $class
         */
        $object = $class::createObject($setDefaultValues);
        $decoratorClass = static::doGetEntityObjectDecoratorClass();
        if ($decoratorClass) {
            return new $decoratorClass($object);
        }

        return $object;
    }

    /**
     * Создание коллекции
     *
     * @return ICollectionDecorator|Collection
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     */
    public static function createCollection()
    {
        $class = static::getTableClass();
        /**
         * @var \Bitrix\Main\ORM\Data\DataManager $class
         */
        $collectionClass = static::doGetCollectionDecoratorClass();
        $collection = $class::getEntity()->createCollection();
        if ($collectionClass) {
            return new $collectionClass($collection);
        }

        return $collection;
    }

    /**
     * @see EntityObject::wakeUp()
     *
     * @param mixed[] $row
     *
     * @return IEntityObjectDecorator|\Bitrix\Main\ORM\Objectify\EntityObject
     */
    public static function wakeUpObject(array $row)
    {
        $class = static::getTableClass();
        /**
         * @var \Bitrix\Main\ORM\Data\DataManager $class
         */
        $object = $class::getEntity()->wakeUpObject($row);
        $decoratorClass = static::doGetEntityObjectDecoratorClass();
        if ($decoratorClass) {
            return new $decoratorClass($object);
        }

        return $object;
    }

    /**
     * @see Collection::wakeUp()
     *
     * @param mixed[] $rows
     *
     * @return ICollectionDecorator|Collection
     */
    public static function wakeUpCollection(array $rows)
    {
        $class = static::getTableClass();
        /**
         * @var \Bitrix\Main\ORM\Data\DataManager $class
         */
        $collectionClass = static::doGetCollectionDecoratorClass();
        $collection = $class::getEntity()->wakeUpCollection($rows);
        if ($collectionClass) {
            return new $collectionClass($collection);
        }

        return $collection;
    }

    /**
     * Creates and returns the Query object for the entity
     *
     * @return Query
     */
    public static function query()
    {
        $class = static::getTableClass();
        /**
         * @var \Bitrix\Main\ORM\Data\DataManager $class
         */
        $queryClass = static::getQueryClass();

        if (!static::doGetEntityObjectDecoratorClass() || !static::doGetCollectionDecoratorClass()) {
            return new $queryClass($class::getEntity());
        }

        return new Query(
            $class::getEntity(),
            static::doGetEntityObjectDecoratorClass(),
            static::doGetCollectionDecoratorClass()
        );
    }

    /**
     * Вызываем методы таблицы
     *
     * @param mixed[]  $arguments
     *
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        $class = static::getTableClass();

        return call_user_func_array([$class, $name], $arguments);
    }

    /**
     * Фабричный метод для прокси результатов
     *
     * @return IResultDecorator|Result
     */
    public static function getResultDecorator(Result $result)
    {
        if (!static::doGetEntityObjectDecoratorClass() || !static::doGetCollectionDecoratorClass()) {
            return $result;
        }

        return new ResultDecorator(
            $result,
            static::doGetEntityObjectDecoratorClass(),
            static::doGetCollectionDecoratorClass()
        );
    }

    /**
     * Возвращает класс таблицы
     */
    protected static function getTableClass(): string
    {
        if (is_null(static::$tableClass)) {
            static::$tableClass = static::doGetTableClass();
        }

        return static::$tableClass;
    }

    /**
     * @inheritDoc
     */
    public static function resetState(): void
    {
        static::$tableClass = null;
    }
}
