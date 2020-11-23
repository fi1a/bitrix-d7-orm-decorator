<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ORM\Fields\FieldTypeMask;
use Bitrix\Main\ORM\Objectify\Collection;
use Bitrix\Main\ORM\Objectify\EntityObject;
use Closure;

/**
 * Декоратор \Bitrix\Main\ORM\Objectify\Collection
 *
 * @method hasByPrimary($primary): bool
 * @method getByPrimary($primary): IObjectDecorator|false
 * @method getAll(): IObjectDecorator[]
 * @method removeByPrimary($primary): void
 * @method save(bool $ignoreEvents = false): \Bitrix\Main\ORM\Data\UpdateResult|\Bitrix\Main\ORM\Data\AddResult
 */
abstract class ACollectionDecorator implements ICollectionDecorator
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * Возвращает класс объекта
     */
    abstract protected static function doGetObjectDecoratorClass(): string;

    /**
     * Возвращает класс таблицы
     */
    abstract protected static function doGetTableDecoratorClass(): string;

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
        $this->add($value);
    }

    /**
     * Добавляет в коллекцию объект
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     */
    public function add(IObjectDecorator $object): void
    {
        $add = Closure::bind(
            function (IObjectDecorator $object) {
                // check object class
                $entityObject = $object->getEntityObject();

                if (!($entityObject instanceof $this->_objectClass)) {
                    throw new ArgumentException(sprintf(
                        'Invalid object class %s for %s collection, expected "%s".',
                        get_class($entityObject),
                        static::class,
                        $this->_objectClass
                    ));
                }
                $primary = $this->sysGetPrimaryKey($entityObject);
                if (!$entityObject->sysHasPrimary()) {
                    // object is new and there is no primary yet
                    $entityObject->sysAddOnPrimarySetListener([$this, 'sysOnObjectPrimarySet']);
                }
                if (
                    !isset($this->_objects[$primary])
                    && (
                        !isset($this->_objectsChanges[$primary])
                        || $this->_objectsChanges[$primary] !== static::OBJECT_REMOVED
                    )
                ) {
                    $this->_objects[$primary] = $object;
                    $this->_objectsChanges[$primary] = static::OBJECT_ADDED;
                } elseif (
                    isset($this->_objectsChanges[$primary])
                    && $this->_objectsChanges[$primary] === static::OBJECT_REMOVED
                ) {
                    // silent add for removed runtime
                    $this->_objects[$primary] = $object;

                    unset($this->_objectsChanges[$primary]);
                    unset($this->_objectsRemoved[$primary]);
                }
            },
            $this->collection,
            get_class($this->collection)
        );

        $add($object);
    }

    /**
     * Проверяет наличие объекта в коллекции
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     */
    public function has(IObjectDecorator $object): bool
    {
        return $this->collection->has($object->getEntityObject());
    }

    /**
     * Удалить объект из коллекции
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     */
    public function remove(IObjectDecorator $object): void
    {
        $this->collection->remove($object->getEntityObject());
    }

    /**
     * ills all the values and relations of object
     *
     * @param int|string[] $fields Names of fields to fill
     *
     * @return self
     *
     * @throws ArgumentException
     * @throws \Bitrix\Main\SystemException
     */
    public function fill($fields = FieldTypeMask::ALL)
    {
        $objects = $this->getObjects();
        $entityObjects = [];
        foreach ($objects as $key => $object) {
            $entityObjects[$key] = $object->getEntityObject();
        }
        $this->setObjects($entityObjects);
        $this->collection->fill($fields);
        $this->setObjects($objects);

        return $this;
    }

    /**
     * Constructs set of existing objects from pre-selected data, including references and relations.
     *
     * @param mixed[] $rows
     */
    public static function wakeUp(array $rows): ICollectionDecorator
    {
        /**
         * @var IObjectDecorator $objectClass
         */
        $objectClass = static::doGetObjectDecoratorClass();
        /**
         * @var ITableDecorator $tableClass
         */
        $tableClass = static::doGetTableDecoratorClass();
        $collection = $tableClass::createCollection();

        $getCollection = Closure::bind(
            function () {
                return $this->collection;
            },
            $collection,
            get_class($collection)
        );
        $originalCollection = $getCollection($collection);

        $sysAddActual = Closure::bind(
            function (IObjectDecorator $object) {
                $this->_objects[$this->sysGetPrimaryKey($object->getEntityObject())] = $object;
            },
            $originalCollection,
            get_class($originalCollection)
        );

        foreach ($rows as $row) {
            $sysAddActual($objectClass::wakeUp($row));
        }

        return $collection;
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
    public function getFirstOccurrence(string $fieldName, $value): ?IObjectDecorator
    {
        foreach ($this as $object) {
            if ($object->get($fieldName) === $value) {
                return $object;
            }
        }

        return null;
    }

    /**
     * Возвращает объекты из коллекции
     *
     * @return IObjectDecorator[]|EntityObject[]
     */
    protected function getObjects(): array
    {
        $getObjects = Closure::bind(
            function () {
                return $this->_objects;
            },
            $this->collection,
            get_class($this->collection)
        );

        return $getObjects();
    }

    /**
     * Устанавливает объекты коллекции
     *
     * @param IObjectDecorator[]|EntityObject[] $objects
     */
    protected function setObjects(array $objects): void
    {
        $setObjects = Closure::bind(
            function ($objects) {
                $this->_objects = $objects;
            },
            $this->collection,
            get_class($this->collection)
        );
        $setObjects($objects);
    }
}
