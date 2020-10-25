<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Fi1a\BitrixD7OrmDecorator\AIBlockTableDecorator;

/**
 * Класс для тестирования декоратора iblock orm
 */
class ElementIBlockUnknownTable extends AIBlockTableDecorator
{
    /**
     * @var string
     */
    protected static $tableClass = null;

    /**
     * @inheritDoc
     */
    protected static function getApiCode(): string
    {
        return 'unknown';
    }
}
