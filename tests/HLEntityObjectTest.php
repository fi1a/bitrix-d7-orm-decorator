<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\HL;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\HLTable;
use Fi1a\Unit\BitrixD7OrmDecorator\TestCase\HLTestCase;

/**
 * Тестирование декоратора Fi1a\BitrixD7OrmDecorator\AEntityObjectDecorator для highloadblock orm
 */
class HLEntityObjectTest extends HLTestCase
{
    /**
     * Тестирование __call
     *
     * @depends testAdd
     */
    public function testCall(): void
    {
        $iterator = HLTable::getList([
            'filter' => [
                '=UF_CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var HL $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(HL::class, $item);
        $this->assertEquals('element-2', $item->get('UF_CODE'));
    }

    /**
     * Тестирование __callStatic
     *
     * @depends testAdd
     */
    public function testCallStatic(): void
    {
        $this->assertEquals('Code', HL::sysFieldToMethodCase('CODE'));
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
        $iterator = HLTable::getList([
            'filter' => [
                '=UF_CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $row = $iterator->fetch();
        /**
         * @var HL $item
         */
        $item = HL::wakeUp($row);
        $this->assertInstanceOf(HL::class, $item);
        $this->assertEquals('element-2', $item->get('UF_CODE'));
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
        $iterator = HLTable::getList([
            'filter' => [
                '=UF_CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var HL $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(HL::class, $item);
        $this->assertTrue(isset($item['UF_CODE']));
        $this->assertFalse(isset($item['UNKNOW']));
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
        $iterator = HLTable::getList([
            'filter' => [
                '=UF_CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var HL $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(HL::class, $item);
        $this->assertEquals('element-2', $item['UF_CODE']);
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
        $iterator = HLTable::getList([
            'filter' => [
                '=UF_CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var HL $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(HL::class, $item);
        $this->assertEquals('element-2', $item['UF_CODE']);
        $item['UF_CODE'] = 'new-value';
        $this->assertEquals('new-value', $item['UF_CODE']);
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
        $iterator = HLTable::getList([
            'filter' => [
                '=UF_CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var HL $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(HL::class, $item);
        $this->assertEquals('element-2', $item['UF_CODE']);
        unset($item['UF_CODE']);
        $this->assertNull($item['UF_CODE']);
    }

    /**
     * Тестирование CRUD
     *
     * @depends testAdd
     */
    public function testCRUD(): void
    {
        $item = HLTable::createObject();
        $item->set('UF_CODE', 'new element');
        $this->assertTrue($item->save()->isSuccess());
        $item->set('UF_CODE', 'update element');
        $this->assertTrue($item->save()->isSuccess());
        $this->assertTrue($item->delete()->isSuccess());
    }
}
