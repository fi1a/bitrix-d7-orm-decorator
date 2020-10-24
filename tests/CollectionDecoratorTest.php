<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

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
}
