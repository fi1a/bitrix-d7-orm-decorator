<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlock;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlockTable;
use Fi1a\Unit\BitrixD7OrmDecorator\TestCase\IBlockTestCase;

/**
 * Тестирование результата декоратора для iblock orm
 */
class IBlockResultTest extends IBlockTestCase
{
    /**
     * Выбираем коллекцию
     *
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testFetchCollection(): void
    {
        $iterator = ElementIBlockTable::getList([
            'select' => ['code'],
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertEquals(3, $collection->count());
    }

    /**
     * Тестирование __call
     *
     * @depends testAdd
     */
    public function testCall(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
    }

    /**
     * Тестирование fetchObject
     *
     * @depends testAdd
     */
    public function testFetchObject(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
            'limit' => 1,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $this->assertInstanceOf(ElementIBlock::class, $iterator->fetchObject());
    }
}
