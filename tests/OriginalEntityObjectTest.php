<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\OriginalDecoratorEntityObject;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\OriginalDecoratorTable;
use Fi1a\Unit\BitrixD7OrmDecorator\TestCase\OriginalTestCase;

/**
 * Тестирование декоратора Fi1a\BitrixD7OrmDecorator\AEntityObjectDecorator
 */
class OriginalEntityObjectTest extends OriginalTestCase
{
    /**
     * Тестирование __call
     *
     * @depends testAdd
     */
    public function testCall(): void
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
        $this->assertEquals('element-2', $item->get('code'));
    }

    /**
     * Тестирование __callStatic
     *
     * @depends testAdd
     */
    public function testCallStatic(): void
    {
        $this->assertEquals('Code', OriginalDecoratorEntityObject::sysFieldToMethodCase('code'));
    }

    /**
     * Тестирование wakeUp
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testWakeUp(): void
    {
        $iterator = OriginalDecoratorTable::getList([
            'filter' => [
                '=code' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $row = $iterator->fetch();
        /**
         * @var OriginalDecoratorEntityObject $item
         */
        $item = OriginalDecoratorEntityObject::wakeUp($row);
        $this->assertInstanceOf(OriginalDecoratorEntityObject::class, $item);
        $this->assertEquals('element-2', $item->get('code'));
    }

    /**
     * Тестирование offsetExists
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testOffsetExists(): void
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
        $this->assertTrue(isset($item['code']));
        $this->assertFalse(isset($item['unknown']));
    }

    /**
     * Тестирование offsetGet
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testOffsetGet(): void
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
     * Тестирование offsetSet
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testOffsetSet(): void
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
        $item['code'] = 'new-value';
        $this->assertEquals('new-value', $item['code']);
    }

    /**
     * Тестирование offsetUnset
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testOffsetUnset(): void
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
        unset($item['code']);
        $this->assertNull($item['code']);
    }

    /**
     * Тестирование CRUD
     *
     * @depends testAdd
     */
    public function testCRUD(): void
    {
        $item = OriginalDecoratorTable::createObject();
        $item->set('code', 'new element');
        $this->assertTrue($item->save()->isSuccess());
        $item->set('code', 'update element');
        $this->assertTrue($item->save()->isSuccess());
        $this->assertTrue($item->delete()->isSuccess());
    }
}
