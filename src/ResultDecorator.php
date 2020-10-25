<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Query\Result;
use Closure;

/**
 * Декоратор Bitrix\Main\ORM\Query\Result
 */
class ResultDecorator implements IResultDecorator
{
    /**
     * @var Result
     */
    protected $result;

    /**
     * @var string
     */
    protected $entityObjectClass;

    /**
     * @var string
     */
    protected $collectionClass;

    /**
     * Конструктор
     */
    public function __construct(Result $result, string $entityObjectClass, string $collectionClass)
    {
        $this->result = $result;
        $this->entityObjectClass = $entityObjectClass;
        $this->collectionClass = $collectionClass;
    }

    /**
     * Вызываем методы Bitrix\Main\ORM\Query\Result
     *
     * @param mixed[] $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->result, $name], $arguments);
    }

    /**
     * Вернуть объект
     */
    public function fetchObject(): ?IEntityObjectDecorator
    {
        $object = $this->result->fetchObject();

        if ($object) {
            $object = new $this->entityObjectClass($object);
        }

        return $object;
    }

    /**
     * Вернуть коллекцию
     */
    public function fetchCollection(): ICollectionDecorator
    {
        $collection = $this->createCollection();

        while ($object = $this->fetchObject()) {
            $this->sysAddActual($collection, $object);
        }

        return $collection;
    }

    /**
     * Добавляет объект в коллекцию
     */
    protected function sysAddActual(ICollectionDecorator $collection, IEntityObjectDecorator $object): void
    {
        $sysAddActual = Closure::bind(
            function (IEntityObjectDecorator $object): void {
                $primary = $this->sysSerializePrimaryKey($object->primary);
                $this->_objects[$primary] = $object;
            },
            $collection->getCollection(),
            get_class($collection->getCollection())
        );

        $sysAddActual($object);
    }

    /**
     * Создает коллекцию
     */
    protected function createCollection(): ICollectionDecorator
    {
        $createCollection = Closure::bind(
            function (string $class) {
                return new $class($this->query->getEntity()->createCollection());
            },
            $this->result,
            get_class($this->result)
        );

        return $createCollection($this->collectionClass);
    }
}
