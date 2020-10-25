<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Fi1a\BitrixD7OrmDecorator\AEntityObjectDecorator;

/**
 * Класс для тестирования объекта 1С-Битрикс D7 ORM
 */
class OriginalDecoratorEntityObject extends AEntityObjectDecorator
{
    /**
     * @inheritDoc
     */
    protected function getEntityObjectClass(): string
    {
        return OriginalEntityObject::class;
    }
}
