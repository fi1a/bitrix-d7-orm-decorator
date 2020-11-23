<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\OriginalDecoratorObject;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\OriginalDecoratorTable;
use Fi1a\Unit\BitrixD7OrmDecorator\TestCase\OriginalTestCase;

/**
 * Тестирование результата декоратора для 1С-Битрикс D7 ORM
 */
class OriginalResultTest extends OriginalTestCase
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
        $iterator = OriginalDecoratorTable::getList([
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
        $iterator = OriginalDecoratorTable::getList([
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
        $iterator = OriginalDecoratorTable::getList([
            'count_total' => true,
            'limit' => 1,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $this->assertInstanceOf(OriginalDecoratorObject::class, $iterator->fetchObject());
    }
}
