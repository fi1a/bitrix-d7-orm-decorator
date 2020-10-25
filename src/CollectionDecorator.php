<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Objectify\Collection;
use Bitrix\Main\ORM\Objectify\EntityObject;

/**
 * Декоратор Bitrix\Main\ORM\Objectify\Collection
 *
 * @mixin Collection
 */
class CollectionDecorator implements ICollectionDecorator
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * Конструктор
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Вызываем методы коллекции
     *
     * @param mixed[] $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->collection, $name], $arguments);
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if ($value instanceof IEntityObjectDecorator) {
            $value = $value->getEntityObject();
        }
        $this->add($value);
    }

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset
     */
    public function offsetExists($offset)
    {
        $this->collection->offsetExists($offset);
        // @codeCoverageIgnoreStart
    }

    // @codeCoverageIgnoreEnd

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->collection->offsetUnset($offset);
        // @codeCoverageIgnoreStart
    }

    // @codeCoverageIgnoreEnd

    /**
     * ArrayAccess implementation
     *
     * @param mixed $offset
     */
    public function offsetGet($offset)
    {
        $this->collection->offsetGet($offset);
        // @codeCoverageIgnoreStart
    }

    // @codeCoverageIgnoreEnd

    /**
     * Iterator implementation
     */
    public function rewind()
    {
        $this->collection->rewind();
    }

    /**
     * Iterator implementation
     *
     * @return EntityObject|mixed
     */
    public function current()
    {
        return $this->collection->current();
    }

    /**
     * Iterator implementation
     *
     * @return int|mixed|string|null
     */
    public function key()
    {
        return $this->collection->key();
    }

    /**
     * Iterator implementation
     */
    public function next()
    {
        $this->collection->next();
    }

    /**
     * Iterator implementation
     *
     * @return bool
     */
    public function valid()
    {
        return $this->collection->valid();
    }

    /**
     * Countable implementation
     *
     * @return int
     */
    public function count()
    {
        return $this->collection->count();
    }

    /**
     * @inheritDoc
     */
    public function getCollection(): Collection
    {
        return $this->collection;
    }

    /**
     * @inheritDoc
     */
    public function getFirstOccurrence(string $fieldName, $value): ?IEntityObjectDecorator
    {
        foreach ($this as $object) {
            if ($object->get($fieldName) === $value) {
                return $object;
            }
        }

        return null;
    }
}
