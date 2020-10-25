<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Fi1a\BitrixD7OrmDecorator\AIBlockTableDecorator;

/**
 * Класс для тестирования декоратора iblock orm
 */
class ElementIBlockTable extends AIBlockTableDecorator
{
    public const API_CODE = 'IBlock';

    /**
     * @var string
     */
    protected static $tableClass = null;

    /**
     * @inheritDoc
     */
    protected static function getApiCode(): string
    {
        return static::API_CODE;
    }

    /**
     * @inheritDoc
     */
    protected static function doGetEntityObjectDecoratorClass(): ?string
    {
        return ElementIBlock::class;
    }
}
