<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Bitrix\Main\Entity\EventResult;
use Bitrix\Main\ORM\Event;
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
    protected static function doGetObjectDecoratorClass(): ?string
    {
        return OriginalDecoratorObject::class;
    }

    /**
     * @inheritDoc
     */
    protected static function doGetCollectionDecoratorClass(): ?string
    {
        return OriginalDecoratorCollection::class;
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
