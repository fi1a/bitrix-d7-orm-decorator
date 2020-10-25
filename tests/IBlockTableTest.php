<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Fi1a\BitrixD7OrmDecorator\Exception\ErrorException;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlock;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlockTable;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlockUnknownTable;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlockWithoutObjectTable;
use Fi1a\Unit\BitrixD7OrmDecorator\TestCase\IBlockTestCase;

/**
 * Тестирование декоратора Fi1a\BitrixD7OrmDecorator\ATableDecorator для iblock orm
 */
class IBlockTableTest extends IBlockTestCase
{
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

    /**
     * Тестирование resetState
     *
     * @depends testAdd
     */
    public function testResetState(): void
    {
        ElementIBlockTable::resetState();
        $this->assertTrue(true);
    }

    /**
     * Тестирование doGetTableClass
     *
     * @depends testAdd
     */
    public function testDoGetTableClassException(): void
    {
        $this->expectException(ErrorException::class);
        ElementIBlockUnknownTable::getList();
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
        $itemById = ElementIBlockTable::getById($item->getId())->fetchObject();
        $this->assertInstanceOf(ElementIBlock::class, $itemById);
        $this->assertEquals('element-2', $itemById['CODE']);
    }
}
