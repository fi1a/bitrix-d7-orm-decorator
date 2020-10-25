<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;
use Fi1a\BitrixD7OrmDecorator\ATableDecorator;

/**
 * Класс для тестирования декоратора highloadblock orm
 */
class HLTable extends ATableDecorator
{
    /**
     * @var string
     */
    protected static $tableClass = null;

    /**
     * @inheritDoc
     */
    protected static function doGetTableClass(): string
    {
        Loader::includeModule('highloadblock');

        return (string) HighloadBlockTable::compileEntity('Hl')->getDataClass();
    }

    /**
     * @inheritDoc
     */
    protected static function doGetEntityObjectDecoratorClass(): ?string
    {
        return HL::class;
    }
}
