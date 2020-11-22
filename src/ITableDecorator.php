<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Main\Entity\EventResult;
use Bitrix\Main\ORM\Event;

/**
 * Интерфейс декоратора \Bitrix\Main\ORM\Data\DataManager
 */
interface ITableDecorator
{
    /**
     * Сбрасывает состояние
     */
    public static function resetState(): void;

    /**
     * Подписывает события
     */
    public static function bindEvents(): void;

    /**
     * Событие до дабавления
     */
    public static function onBeforeAdd(Event $event): EventResult;

    /**
     * Событие при добавлении
     */
    public static function onAdd(Event $event): EventResult;

    /**
     * Событие после добавления
     */
    public static function onAfterAdd(Event $event): EventResult;

    /**
     * Событие до обновления
     */
    public static function onBeforeUpdate(Event $event): EventResult;

    /**
     * Событие при обновлении
     */
    public static function onUpdate(Event $event): EventResult;

    /**
     * Событие после обновления
     */
    public static function onAfterUpdate(Event $event): EventResult;

    /**
     * Событие до удаления
     */
    public static function onBeforeDelete(Event $event): EventResult;

    /**
     * Событие при удалении
     */
    public static function onDelete(Event $event): EventResult;

    /**
     * Событие после удаления
     */
    public static function onAfterDelete(Event $event): EventResult;
}
