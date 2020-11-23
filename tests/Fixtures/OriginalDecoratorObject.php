<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Fi1a\BitrixD7OrmDecorator\AObjectDecorator;

/**
 * Класс для тестирования объекта декоратора 1С-Битрикс D7 ORM
 */
class OriginalDecoratorObject extends AObjectDecorator
{
    /**
     * @inheritDoc
     */
    protected function getEntityObjectClass(): string
    {
        return OriginalObject::class;
    }
}
