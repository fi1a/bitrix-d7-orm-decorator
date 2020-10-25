<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\TestCase;

use Bitrix\Main\Application;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\OriginalDecoratorTable;
use PHPUnit\Framework\TestCase;

/**
 * Тесты декоратора 1С-Битрикс D7 ORM
 */
class OriginalTestCase extends TestCase
{
    /**
     * До начала вызова тестов
     */
    public static function setUpBeforeClass(): void
    {
        Application::getConnection()->createTable(
            OriginalDecoratorTable::getTableName(),
            OriginalDecoratorTable::getMap(),
            ['id'],
            ['id']
        );
    }

    /**
     * После вызова тестов
     */
    public static function tearDownAfterClass(): void
    {
        Application::getConnection()->dropTable(OriginalDecoratorTable::getTableName());
    }

    /**
     * Тестирование добавления элементов
     */
    public function testAdd(): void
    {
        $result = OriginalDecoratorTable::add([
            'code' => 'element-1',
        ]);
        $this->assertTrue($result->isSuccess());
        $result = OriginalDecoratorTable::add([
            'code' => 'element-2',
        ]);
        $this->assertTrue($result->isSuccess());
        $result = OriginalDecoratorTable::add([
            'code' => 'element-3',
        ]);
        $this->assertTrue($result->isSuccess());
    }
}
