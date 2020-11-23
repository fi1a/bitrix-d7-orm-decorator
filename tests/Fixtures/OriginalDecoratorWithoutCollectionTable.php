<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Fi1a\BitrixD7OrmDecorator\ATableDecorator;

/**
 * Класс для тестирования декоратора 1С-Битрикс D7 ORM
 */
class OriginalDecoratorWithoutCollectionTable extends ATableDecorator
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
        return OriginalTable::class;
    }

    /**
     * @inheritDoc
     */
    protected static function doGetObjectDecoratorClass(): ?string
    {
        return OriginalDecoratorObject::class;
    }
}
