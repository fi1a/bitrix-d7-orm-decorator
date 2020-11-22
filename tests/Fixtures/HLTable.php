<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Bitrix\Main\Entity\EventResult;
use Bitrix\Main\ORM\Event;
use Fi1a\BitrixD7OrmDecorator\AHLTableDecorator;

/**
 * Класс для тестирования декоратора highloadblock orm
 */
class HLTable extends AHLTableDecorator
{
    /**
     * @var string
     */
    public static $hlName;

    /**
     * @var string
     */
    protected static $tableClass = null;

    /**
     * @inheritDoc
     */
    protected static function getName(): string
    {
        return static::$hlName;
    }

    /**
     * @inheritDoc
     */
    protected static function doGetEntityObjectDecoratorClass(): ?string
    {
        return HL::class;
    }

    /**
     * @inheritDoc
     */
    protected static function doGetCollectionDecoratorClass(): ?string
    {
        return HLCollection::class;
    }

    /**
     * @inheritDoc
     */
    public static function onBeforeAdd(Event $event): EventResult
    {
        $result = parent::onBeforeAdd($event);

        $fields = $event->getParameter('fields');

        if ($fields['UF_CODE'] === 'bind-events-1') {
            $result->modifyFields(array_merge($fields, [
                'UF_CODE' => 'bind-events-1-onBeforeAdd',
            ]));
        }

        return $result;
    }
}
