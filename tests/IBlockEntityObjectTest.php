<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlock;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlockTable;
use Fi1a\Unit\BitrixD7OrmDecorator\TestCase\IBlockTestCase;

/**
 * Тестирование декоратора Fi1a\BitrixD7OrmDecorator\AEntityObjectDecorator
 */
class IBlockEntityObjectTest extends IBlockTestCase
{
    /**
     * Тестирование __call
     *
     * @depends testAdd
     */
    public function testCall(): void
    {
        $iterator = ElementIBlockTable::getList([
            'filter' => [
                '=CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var ElementIBlock $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(ElementIBlock::class, $item);
        $this->assertEquals('element-2', $item->get('CODE'));
    }

    /**
     * Тестирование __callStatic
     *
     * @depends testAdd
     */
    public function testCallStatic(): void
    {
        $this->assertEquals('Code', ElementIBlock::sysFieldToMethodCase('CODE'));
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
        $iterator = ElementIBlockTable::getList([
            'filter' => [
                '=CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $row = $iterator->fetch();
        /**
         * @var ElementIBlock $item
         */
        $item = ElementIBlock::wakeUp($row);
        $this->assertInstanceOf(ElementIBlock::class, $item);
        $this->assertEquals('element-2', $item->get('CODE'));
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
        $iterator = ElementIBlockTable::getList([
            'filter' => [
                '=CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var ElementIBlock $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(ElementIBlock::class, $item);
        $this->assertTrue(isset($item['CODE']));
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
        $iterator = ElementIBlockTable::getList([
            'filter' => [
                '=CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var ElementIBlock $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(ElementIBlock::class, $item);
        $this->assertEquals('element-2', $item['CODE']);
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
                '=CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var ElementIBlock $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(ElementIBlock::class, $item);
        $this->assertEquals('element-2', $item['CODE']);
        $item['CODE'] = 'new-value';
        $this->assertEquals('new-value', $item['CODE']);
    }
}
