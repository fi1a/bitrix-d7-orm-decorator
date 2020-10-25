<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Fi1a\BitrixD7OrmDecorator\AHLTableDecorator;

/**
 * Класс для тестирования декоратора highloadblock orm
 */
class HLTable extends AHLTableDecorator
{
    /**
     * @var string
     */
    public static $hlName;

    /**
     * @var string
     */
    protected static $tableClass = null;

    /**
     * @inheritDoc
     */
    protected static function getName(): string
    {
        return static::$hlName;
    }

    /**
     * @inheritDoc
     */
    protected static function doGetEntityObjectDecoratorClass(): ?string
    {
        return HL::class;
    }
}
