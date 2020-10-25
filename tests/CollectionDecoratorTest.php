<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Bitrix\Main\NotImplementedException;
use Fi1a\BitrixD7OrmDecorator\CollectionDecorator;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlockTable;
use Fi1a\Unit\BitrixD7OrmDecorator\TestCase\IBlockTestCase;

/**
 * Тестирование декоратора Fi1a\BitrixD7OrmDecorator\CollectionDecorator
 */
class CollectionDecoratorTest extends IBlockTestCase
{
    /**
     * Тестирование __call
     *
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testCall(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertInstanceOf(CollectionDecorator::class, $collection);
        $this->assertCount(3, $collection->getAll());
    }

    /**
     * Тестирование offsetSet
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testOffsetSet(): void
    {
        $iterator = ElementIBlockTable::getList([
            'filter' => [
                '=CODE' => 'element-1',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertInstanceOf(CollectionDecorator::class, $collection);
        $this->assertCount(1, $collection);
        $iterator = ElementIBlockTable::getList([
            'filter' => [
                '=CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $collection[] = $iterator->fetchObject();
        $this->assertCount(2, $collection);
    }

    /**
     * Тестирование offsetExists
     *
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testOffsetExists(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertInstanceOf(CollectionDecorator::class, $collection);
        $this->expectException(NotImplementedException::class);
        isset($collection[0]);
    }

    /**
     * Тестирование offsetUnset
     *
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testOffsetUnset(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertInstanceOf(CollectionDecorator::class, $collection);
        $this->expectException(NotImplementedException::class);
        unset($collection[0]);
    }

    /**
     * Тестирование offsetGet
     *
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testOffsetGet(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertInstanceOf(CollectionDecorator::class, $collection);
        $this->expectException(NotImplementedException::class);
        $collection[0];
    }
}
