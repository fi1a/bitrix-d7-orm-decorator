<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Fi1a\BitrixD7OrmDecorator\ATableDecorator;

/**
 * Класс для тестирования декоратора 1С-Битрикс D7 ORM
 */
class OriginalDecoratorTable extends ATableDecorator
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
    protected static function doGetEntityObjectDecoratorClass(): ?string
    {
        return OriginalDecoratorEntityObject::class;
    }

    /**
     * @inheritDoc
     */
    protected static function doGetCollectionDecoratorClass(): ?string
    {
        return OriginalDecoratorCollection::class;
    }
}
