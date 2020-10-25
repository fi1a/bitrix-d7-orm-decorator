<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\HL;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\HLTable;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\HLWithoutObjectTable;
use Fi1a\Unit\BitrixD7OrmDecorator\TestCase\HLTestCase;

/**
 * Тестирование декоратора Fi1a\BitrixD7OrmDecorator\ATableDecorator для highloadblock orm
 */
class HLTableTest extends HLTestCase
{
    /**
     * Тестирование метода getList
     *
     * @depends testAdd
     */
    public function testGetList(): void
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
     * Тестирование метода getList
     *
     * @depends testAdd
     */
    public function testGetListWithoutObject(): void
    {
        $iterator = HLWithoutObjectTable::getList([
            'filter' => [
                '=UF_CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $item = $iterator->fetchObject();
        $this->assertInstanceOf('\\EO_' . HLTable::$hlName, $item);
        $this->assertEquals('element-2', $item['UF_CODE']);
    }

    /**
     * Тестирование resetState
     */
    public function testResetState(): void
    {
        HLTable::resetState();
        $this->assertTrue(true);
    }
}
