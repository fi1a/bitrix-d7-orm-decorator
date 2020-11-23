<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Fi1a\BitrixD7OrmDecorator\ICollectionDecorator;
use Fi1a\BitrixD7OrmDecorator\IObjectDecorator;
use Fi1a\BitrixD7OrmDecorator\IResultDecorator;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlockTable;
use Fi1a\Unit\BitrixD7OrmDecorator\TestCase\IBlockTestCase;

/**
 * Тестирование объекта запроса
 */
class QueryTest extends IBlockTestCase
{
    /**
     * Тестирование exec
     *
     * @depends testAdd
     */
    public function testExec(): void
    {
        /**
         * @var $result \Fi1a\BitrixD7OrmDecorator\ResultDecorator
         */
        $result = ElementIBlockTable::query()
            ->setFilter([
                '=CODE' => 'element-2',
            ])
            ->setSelect(['*'])
            ->exec();
        $this->assertInstanceOf(IResultDecorator::class, $result);
        $item = $result->fetchObject();
        $this->assertInstanceOf(IObjectDecorator::class, $item);
    }

    /**
     * Тестирование fetch
     *
     * @depends testAdd
     */
    public function testFetch(): void
    {
        /**
         * @var $result \Fi1a\BitrixD7OrmDecorator\ResultDecorator
         */
        $item = ElementIBlockTable::query()
            ->setFilter([
                '=CODE' => 'element-2',
            ])
            ->setSelect(['*'])
            ->fetch();
        $this->assertEquals('element-2', $item['CODE']);
    }

    /**
     * Тестирование fetchAll
     *
     * @depends testAdd
     */
    public function testFetchAll(): void
    {
        /**
         * @var $result \Fi1a\BitrixD7OrmDecorator\ResultDecorator
         */
        $items = ElementIBlockTable::query()
            ->setFilter([
                '=CODE' => 'element-2',
            ])
            ->setSelect(['*'])
            ->fetchAll();
        $this->assertCount(1, $items);
    }

    /**
     * Тестирование fetchObject
     *
     * @depends testAdd
     */
    public function testFetchObject(): void
    {
        /**
         * @var $result \Fi1a\BitrixD7OrmDecorator\ResultDecorator
         */
        $item = ElementIBlockTable::query()
            ->setFilter([
                '=CODE' => 'element-2',
            ])
            ->setSelect(['*'])
            ->fetchObject();
        $this->assertInstanceOf(IObjectDecorator::class, $item);
    }

    /**
     * Тестирование fetchCollection
     *
     * @depends testAdd
     */
    public function testFetchCollection(): void
    {
        /**
         * @var $result \Fi1a\BitrixD7OrmDecorator\ResultDecorator
         */
        $collection = ElementIBlockTable::query()
            ->setFilter([
                '=CODE' => 'element-2',
            ])
            ->setSelect(['*'])
            ->fetchCollection();
        $this->assertInstanceOf(ICollectionDecorator::class, $collection);
        $this->assertCount(1, $collection);
    }
}
