<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlock;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlockTable;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlockWithoutObjectTable;
use Fi1a\Unit\BitrixD7OrmDecorator\TestCase\IBlockTestCase;

/**
 * Тестирование декоратора Fi1a\BitrixD7OrmDecorator\ATableDecorator
 */
class IBlockTableTest extends IBlockTestCase
{
    /**
     * Добавление элементов в инфоблок
     *
     * @throws \Exception
     */
    public function testAdd(): void
    {
        $result = ElementIBlockTable::add([
            'ACTIVE' => 'Y',
            'NAME' => 'Element 1',
            'CODE' => 'element-1',
        ]);
        $this->assertTrue($result->isSuccess());
        $result = ElementIBlockTable::add([
            'ACTIVE' => 'Y',
            'NAME' => 'Element 2',
            'CODE' => 'element-2',
        ]);
        $this->assertTrue($result->isSuccess());
        $result = ElementIBlockTable::add([
            'ACTIVE' => 'Y',
            'NAME' => 'Element 3',
            'CODE' => 'element-3',
        ]);
        $this->assertTrue($result->isSuccess());
    }

    /**
     * Тестирование метода getList
     *
     * @depends testAdd
     */
    public function testGetList(): void
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
     * Тестирование метода getList
     *
     * @depends testAdd
     */
    public function testGetListWithoutObject(): void
    {
        $iterator = ElementIBlockWithoutObjectTable::getList([
            'filter' => [
                '=CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $item = $iterator->fetchObject();
        $this->assertInstanceOf('Bitrix\Iblock\Elements\EO_ElementIBlock', $item);
        $this->assertEquals('element-2', $item['CODE']);
    }
}
