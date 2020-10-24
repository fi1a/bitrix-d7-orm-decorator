<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Bitrix\Iblock\Elements\EO_ElementIBlock;
use Fi1a\BitrixD7OrmDecorator\AEntityObjectDecorator;

/**
 * Класс для тестирования объекта iblock orm
 */
class ElementIBlock extends AEntityObjectDecorator
{
    /**
     * @inheritDoc
     */
    protected function getEntityObjectClass(): string
    {
        return EO_ElementIBlock::class;
    }
}
