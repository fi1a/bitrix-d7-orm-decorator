<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\TypeLanguageTable;
use Bitrix\Iblock\TypeTable;
use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlockTable;
use PHPUnit\Framework\TestCase;

/**
 * Тестирование декоратора Fi1a\BitrixD7OrmDecorator\ATableDecorator
 */
class ATableDecoratorTest extends TestCase
{
    /**
     * @var string
     */
    private static $iblockTypeId = '';

    /**
     * @var int
     */
    private static $iblockId = null;

    /**
     * До начала вызова тестов
     */
    public static function setUpBeforeClass(): void
    {
        Loader::includeModule('iblock');
        $typeResult = TypeTable::add([
            'ID' => 'BitrixD7OrmDecorator',
            'SECTIONS' => 'Y',
        ]);
        if (!$typeResult->isSuccess()) {
            throw new \ErrorException();
        }
        self::$iblockTypeId = $typeResult->getId();
        TypeLanguageTable::add([
            'IBLOCK_TYPE_ID' => self::$iblockTypeId,
            'LANGUAGE_ID' => 'ru',
            'NAME' => 'BitrixD7OrmDecorator',
        ]);
        TypeLanguageTable::add([
            'IBLOCK_TYPE_ID' => self::$iblockTypeId,
            'LANGUAGE_ID' => 'en',
            'NAME' => 'BitrixD7OrmDecorator',
        ]);
        $result = IblockTable::add([
            'IBLOCK_TYPE_ID' => self::$iblockTypeId,
            'LID' => Context::getCurrent()->getSite(),
            'CODE' => 'BitrixD7OrmDecorator',
            'API_CODE' => ElementIBlockTable::API_CODE,
            'NAME' => 'BitrixD7OrmDecorator',
            'ACTIVE' => 'Y',
            'WORKFLOW' => 'N',
        ]);
        if (!$result->isSuccess()) {
            throw new \ErrorException();
        }
        self::$iblockId = $result->getId();
    }

    /**
     * После вызова тестов
     */
    public static function tearDownAfterClass(): void
    {
        if (!self::$iblockId || !self::$iblockTypeId) {
            throw new \ErrorException();
        }
        IblockTable::delete(self::$iblockId);
        TypeLanguageTable::deleteByIblockTypeId(self::$iblockTypeId);
        TypeTable::delete(self::$iblockTypeId);
    }

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
        $item = $iterator->fetch();
        $this->assertEquals('element-2', $item['CODE']);
    }
}
