<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Fi1a\BitrixD7OrmDecorator\ACollectionDecorator;

/**
 * Коллекция
 */
class OriginalDecoratorCollection extends ACollectionDecorator
{
    /**
     * @inheritDoc
     */
    protected static function doGetEntityObjectDecoratorClass(): string
    {
        return OriginalDecoratorObject::class;
    }

    /**
     * @inheritDoc
     */
    protected static function doGetTableDecoratorClass(): string
    {
        return OriginalDecoratorTable::class;
    }
}
