<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Objectify\Collection;
use Bitrix\Main\ORM\Query\Result;

/**
 * Декоратор Bitrix\Main\ORM\Data\DataManager
 *
 * @mixin \Bitrix\Main\ORM\Data\DataManager
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
     * @return Result
     */
    public static function getList(array $parameters = [])
    {
        $class = static::getTableClass();

        return static::getResultDecorator(call_user_func_array([$class, 'getList'], [$parameters]));
    }

    /**
     * @inheritDoc
     */
    public static function getById($id)
    {
        $class = static::getTableClass();

        return static::getResultDecorator(call_user_func_array([$class, 'getById'], [$id]));
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
