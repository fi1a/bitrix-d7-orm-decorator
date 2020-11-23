<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Bitrix\Iblock\Elements\EO_ElementIBlock;
use Fi1a\BitrixD7OrmDecorator\AObjectDecorator;

/**
 * Класс для тестирования объекта iblock orm
 */
class ElementIBlock extends AObjectDecorator
{
    /**
     * @inheritDoc
     */
    protected function getObjectClass(): string
    {
        return EO_ElementIBlock::class;
    }
}
