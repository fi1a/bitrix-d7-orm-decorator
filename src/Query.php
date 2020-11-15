<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Entity;
use Bitrix\Main\ORM\Query\Query as BitrixQuery;

/**
 * Объект запроса
 */
class Query extends BitrixQuery
{
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
     *
     * @param Entity|\Bitrix\Main\ORM\Query\Query|string $source
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     */
    public function __construct($source, string $entityObjectClass, string $collectionClass)
    {
        parent::__construct($source);
        $this->entityObjectClass = $entityObjectClass;
        $this->collectionClass = $collectionClass;
    }

    /**
     * Builds and executes the query and returns the result
     *
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function exec(): IResultDecorator
    {
        return new ResultDecorator(
            parent::exec(),
            $this->entityObjectClass,
            $this->collectionClass
        );
    }
}
