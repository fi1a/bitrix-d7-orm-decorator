<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Bitrix\Iblock\Iblock;
use Bitrix\Iblock\IblockTable;
use Bitrix\Main\Loader;
use Fi1a\BitrixD7OrmDecorator\ATableDecorator;

/**
 * Класс для тестирования декоратора iblock orm
 */
class ElementIBlockWithoutObjectTable extends ATableDecorator
{
    public const API_CODE = 'IBlock';

    /**
     * @var string
     */
    protected static $tableClass = null;

    /**
     * @inheritDoc
     */
    protected static function doGetTableClass(): string
    {
        Loader::includeModule('iblock');

        /**
         * @var Iblock $iblock
         */
        $iblock = IblockTable::getList([
            'filter' => [
                '=API_CODE' => static::API_CODE,
            ],
        ])->fetchObject();

        $iblock->getEntityDataClass();

        return $iblock->getEntityDataClass();
    }
}
