<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;

/**
 * Декоратор \Bitrix\Main\ORM\Data\DataManager для highloadblock orm
 */
abstract class AHLTableDecorator extends ATableDecorator
{
    /**
     * Возвращает название highloadblock
     *
     * @return string
     */
    abstract protected static function getName(): string;

    /**
     * @inheritDoc
     */
    protected static function doGetTableClass(): string
    {
        Loader::includeModule('highloadblock');

        return (string) HighloadBlockTable::compileEntity(static::getName())->getDataClass();
    }
}
