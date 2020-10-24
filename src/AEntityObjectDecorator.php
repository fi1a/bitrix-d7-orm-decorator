<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Objectify\EntityObject;

/**
 * Декоратор Bitrix\Main\ORM\Objectify\EntityObject
 *
 * @mixin EntityObject
 */
abstract class AEntityObjectDecorator implements IEntityObjectDecorator
{
    /**
     * @var EntityObject
     */
    protected $object;

    /**
     * Возвращает класс объекта
     */
    abstract protected function getEntityObjectClass(): string;

    /**
     * Конструктор
     */
    public function __construct(EntityObject $object)
    {
        $this->object = $object;
        $this->primary = &$object->primary;
        $this->state = &$object->state;
        $this->customData = &$object->customData;
        $this->authContext = &$object->authContext;
    }

    /**
     * Вызываем методы Bitrix\Main\ORM\Objectify\EntityObject
     *
     * @param mixed[] $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->object, $name], $arguments);
    }

    /**
     * Вызываем методы Bitrix\Main\ORM\Objectify\EntityObject
     *
     * @param mixed[] $arguments
     *
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        $class = static::getEntityObjectClass();

        return call_user_func_array([$class, $name], $arguments);
    }

    /**
     * Возвращает существующий объект с выбранными данными
     *
     * @param mixed[] $row
     */
    public static function wakeUp(array $row): self
    {
        $class = static::getEntityObjectClass();
        $object = $class::wakeUp($row);

        return new static($object);
    }

    /**
     * ArrayAccess interface implementation.
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->sysHasValue($offset) && $this->sysGetValue($offset) !== null;
    }

    /**
     * ArrayAccess interface implementation.
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->object->offsetGet($offset);
    }

    /**
     * ArrayAccess interface implementation.
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->object->offsetSet($offset, $value);
    }

    /**
     * ArrayAccess interface implementation.
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->object->offsetUnset($offset);
    }

    /**
     * @inheritDoc
     */
    public function getEntityObject(): EntityObject
    {
        return $this->object;
    }
}
