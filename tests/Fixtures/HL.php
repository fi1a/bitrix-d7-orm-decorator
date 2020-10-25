<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use EO_Hl;
use Fi1a\BitrixD7OrmDecorator\AEntityObjectDecorator;

/**
 * Класс для тестирования декоратора объекта highloadblock orm
 */
class HL extends AEntityObjectDecorator
{
    /**
     * @inheritDoc
     */
    protected function getEntityObjectClass(): string
    {
        return EO_Hl::class;
    }
}
