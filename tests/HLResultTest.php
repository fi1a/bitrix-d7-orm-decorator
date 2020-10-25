<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\HL;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\HLTable;
use Fi1a\Unit\BitrixD7OrmDecorator\TestCase\HLTestCase;

/**
 * Тестирование результата декоратора для highloadblock orm
 */
class HLResultTest extends HLTestCase
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
        $iterator = HLTable::getList([
            'select' => ['UF_CODE'],
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
        $iterator = HLTable::getList([
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
        $iterator = HLTable::getList([
            'count_total' => true,
            'limit' => 1,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $this->assertInstanceOf(HL::class, $iterator->fetchObject());
    }
}
