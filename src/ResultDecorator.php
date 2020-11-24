<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Query\Result;
use Closure;

/**
 * Декоратор \Bitrix\Main\ORM\Query\Result
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
     * @inheritDoc
     */
    public function fetchObject(): ?IObjectDecorator
    {
        $object = $this->result->fetchObject();

        if ($object) {
            $object = new $this->entityObjectClass($object);
        }

        return $object;
    }

    /**
     * @inheritDoc
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
    protected function sysAddActual(ICollectionDecorator $collection, IObjectDecorator $object): void
    {
        $sysAddActual = Closure::bind(
            function (IObjectDecorator $object): void {
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
