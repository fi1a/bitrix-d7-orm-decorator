<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Bitrix\Main\Entity\EventResult;
use Bitrix\Main\ORM\Event;
use Fi1a\BitrixD7OrmDecorator\AIBlockTableDecorator;

/**
 * Класс для тестирования декоратора iblock orm
 */
class ElementIBlockTable extends AIBlockTableDecorator
{
    public const API_CODE = 'IBlock';

    /**
     * @var string
     */
    protected static $tableClass = null;

    /**
     * @inheritDoc
     */
    protected static function getApiCode(): string
    {
        return static::API_CODE;
    }

    /**
     * @inheritDoc
     */
    protected static function doGetObjectDecoratorClass(): ?string
    {
        return ElementIBlock::class;
    }

    /**
     * @inheritDoc
     */
    protected static function doGetCollectionDecoratorClass(): ?string
    {
        return ElementIBlockCollection::class;
    }

    /**
     * @inheritDoc
     */
    public static function onBeforeAdd(Event $event): EventResult
    {
        $result = parent::onBeforeAdd($event);
        $fields = $event->getParameter('fields');

        if ($fields['CODE'] === 'bind-events-1') {
            $result->modifyFields(array_merge($fields, [
                'CODE' => 'bind-events-1-onBeforeAdd',
            ]));
        }

        return $result;
    }
}
