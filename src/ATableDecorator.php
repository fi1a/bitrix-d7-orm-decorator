<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Query\Result;

/**
 * Декоратор Bitrix\Main\ORM\Data\DataManager
 *
 * @mixin \Bitrix\Main\ORM\Data\DataManager
 */
abstract class ATableDecorator
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
    protected static function doGetCollectionDecoratorClass(): string
    {
        return CollectionDecorator::class;
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

        return static::factoryResultDecorator(call_user_func_array([$class, 'getList'], [$parameters]));
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
     * @return ResultDecorator|Result
     */
    public static function factoryResultDecorator(Result $result)
    {
        if (!static::doGetEntityObjectDecoratorClass()) {
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
}
