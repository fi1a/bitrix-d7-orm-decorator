<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Query\Result;
use Closure;

/**
 * Декоратор \Bitrix\Main\ORM\Query\Result
 *
 * @method setHiddenObjectFields(string[] $hiddenObjectFields): void
 * @method getFields(): \Bitrix\Main\ORM\Fields\ScalarField[]
 * @method getSelectedRowsCount(): int
 * @method setIdentityMap(\Bitrix\Main\ORM\Objectify\IdentityMap $map): self
 * @method getIdentityMap(): \Bitrix\Main\ORM\Objectify\IdentityMap
 * @method getResource(): null|resource
 * @method setReplacedAliases(string[] $replacedAliases): void
 * @method addReplacedAliases(string[] $replacedAliases): void
 * @method setSerializedFields(mixed[] $serializedFields): void
 * @method addFetchDataModifier($fetchDataModifier): void
 * @method fetchRaw(): mixed[]|false
 * @method fetch(): mixed[]|false
 * @method fetchAll(): mixed[]
 * @method getTrackerQuery(): \Bitrix\Main\Diag\SqlTrackerQuery|null
 * @method getConverters(): callable[]
 * @method setConverters(callable[] $converters): void
 * @method setCount(int $n): void
 * @method getCount(): int
 * @method getIterator(): \Traversable
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
