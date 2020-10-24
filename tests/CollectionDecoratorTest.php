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
}
