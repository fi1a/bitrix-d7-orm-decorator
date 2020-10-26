<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Objectify\EntityObject;
use Fi1a\BitrixD7OrmDecorator\IEntityObjectDecorator;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\OriginalDecoratorEntityObject;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\OriginalDecoratorTable;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\OriginalDecoratorWithoutObjectTable;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\OriginalEntityObject;
use Fi1a\Unit\BitrixD7OrmDecorator\TestCase\OriginalTestCase;

/**
 * Тестирование декоратора Fi1a\BitrixD7OrmDecorator\ATableDecorator
 */
class OriginalTableTest extends OriginalTestCase
{
    /**
     * Тестирование метода getList
     *
     * @depends testAdd
     */
    public function testGetList(): void
    {
        $iterator = OriginalDecoratorTable::getList([
            'filter' => [
                '=code' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var OriginalDecoratorEntityObject $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(OriginalDecoratorEntityObject::class, $item);
        $this->assertEquals('element-2', $item['code']);
    }

    /**
     * Тестирование метода getList
     *
     * @depends testAdd
     */
    public function testGetListWithoutObject(): void
    {
        $iterator = OriginalDecoratorWithoutObjectTable::getList([
            'filter' => [
                '=code' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(OriginalEntityObject::class, $item);
        $this->assertEquals('element-2', $item['code']);
    }

    /**
     * Тестирование getById
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testGetById(): void
    {
        $iterator = OriginalDecoratorTable::getList([
            'filter' => [
                '=code' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var OriginalDecoratorEntityObject $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(OriginalDecoratorEntityObject::class, $item);
        $this->assertEquals('element-2', $item['code']);
        $itemById = OriginalDecoratorTable::getById($item->getId())->fetchObject();
        $this->assertInstanceOf(OriginalDecoratorEntityObject::class, $itemById);
        $this->assertEquals('element-2', $itemById['code']);
    }

    /**
     * Тестирование createObject
     *
     * @depends testAdd
     */
    public function testCreateObject(): void
    {
        $this->assertInstanceOf(IEntityObjectDecorator::class, OriginalDecoratorTable::createObject());
        $this->assertInstanceOf(EntityObject::class, OriginalDecoratorWithoutObjectTable::createObject());
    }
}
