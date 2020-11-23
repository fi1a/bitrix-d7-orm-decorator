<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Fi1a\BitrixD7OrmDecorator\AObjectDecorator;

/**
 * Класс для тестирования декоратора объекта highloadblock orm
 */
class HL extends AObjectDecorator
{
    /**
     * @inheritDoc
     */
    protected function getEntityObjectClass(): string
    {
        return '\\EO_' . HLTable::$hlName;
    }
}
