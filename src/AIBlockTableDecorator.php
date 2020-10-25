<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Iblock\Iblock;
use Bitrix\Iblock\IblockTable;
use Bitrix\Main\Loader;
use Fi1a\BitrixD7OrmDecorator\Exception\ErrorException;

/**
 * Декоратор \Bitrix\Main\ORM\Data\DataManager для iblock orm
 */
abstract class AIBlockTableDecorator extends ATableDecorator
{
    /**
     * Возвращает название highloadblock
     *
     * @return string
     */
    abstract protected static function getApiCode(): string;

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
                '=API_CODE' => static::getApiCode(),
            ],
        ])->fetchObject();

        if (!$iblock) {
            throw new ErrorException(sprintf('Iblock with API_CODE="%s" not found', static::getApiCode()));
        }

        return (string) $iblock->getEntityDataClass();
    }
}
