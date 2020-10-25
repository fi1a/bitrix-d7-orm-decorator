<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\TestCase;

use Bitrix\Highloadblock\HighloadBlockLangTable;
use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;
use CUserTypeEntity;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\HLTable;
use PHPUnit\Framework\TestCase;

/**
 * Тесты декоратора orm highloadblock
 */
class HLTestCase extends TestCase
{
    /**
     * @var int
     */
    private static $hlId;

    /**
     * До начала вызова тестов
     */
    public static function setUpBeforeClass(): void
    {
        Loader::IncludeModule('highloadblock');
        $langs = [
            'ru' => 'HL',
            'en' => 'HL',
        ];
        $result = HighloadBlockTable::add([
            'NAME' => 'Hl',
            'TABLE_NAME' => 'fl_hl',
        ]);
        if ($result->isSuccess()) {
            static::$hlId = $result->getId();
            foreach ($langs as $langKey => $langVal) {
                HighloadBlockLangTable::add([
                    'ID' => static::$hlId,
                    'LID' => $langKey,
                    'NAME' => $langVal,
                ]);
            }
            $ufCode = 'HLBLOCK_' . static::$hlId;
            $fields = [
                'UF_CODE' => [
                    'ENTITY_ID' => $ufCode,
                    'FIELD_NAME' => 'UF_CODE',
                    'USER_TYPE_ID' => 'string',
                    'MANDATORY' => 'Y',
                    'EDIT_FORM_LABEL' => ['ru' => '', 'en' => ''],
                    'LIST_COLUMN_LABEL' => ['ru' => '', 'en' => ''],
                    'LIST_FILTER_LABEL' => ['ru' => '', 'en' => ''],
                    'ERROR_MESSAGE' => ['ru' => '', 'en' => ''],
                    'HELP_MESSAGE' => ['ru' => '', 'en' => ''],
                ],
            ];
            $instance  = new CUserTypeEntity();
            foreach ($fields as $field) {
                $instance->Add($field);
            }
        }
    }

    /**
     * После вызова тестов
     */
    public static function tearDownAfterClass(): void
    {
        if (static::$hlId) {
            HighloadBlockTable::delete(static::$hlId);
        }
    }

    /**
     * Тестирование добавления элементов
     */
    public function testAdd(): void
    {
        $result = HLTable::add([
            'UF_CODE' => 'element-1',
        ]);
        $this->assertTrue($result->isSuccess());
        $result = HLTable::add([
            'UF_CODE' => 'element-2',
        ]);
        $this->assertTrue($result->isSuccess());
        $result = HLTable::add([
            'UF_CODE' => 'element-3',
        ]);
        $this->assertTrue($result->isSuccess());
    }
}
