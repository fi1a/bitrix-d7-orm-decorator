<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Main\Entity\EventResult;
use Bitrix\Main\ORM\Event;

/**
 * Интерфейс декоратора \Bitrix\Main\ORM\Data\DataManager
 *
 * @method static \Bitrix\Main\ORM\Entity getEntity()
 * @method static void unsetEntity(string $class)
 * @method static string|null getTableName()
 * @method static string getConnectionName()
 * @method static string|null getTitle()
 * @method static string|\Bitrix\Main\ORM\Objectify\EntityObject getObjectClass()
 * @method static string getObjectClassName()
 * @method static string getCollectionClass()
 * @method static string getCollectionClassName()
 * @method static string getObjectParentClass()
 * @method static string getCollectionParentClass()
 * @method static string getEntityClass()
 * @method static mixed[] getMap()
 * @method static \Bitrix\Main\ORM\Query\Query setDefaultScope(\Bitrix\Main\ORM\Query\Query $query)
 * @method static mixed[]|null getRowById(mixed $id)
 * @method static mixed[]|null getRow(mixed[] $parameters)
 * @method static int getCount(mixed[] $filter = [], mixed[] $cache = [])
 * @method static string getQueryClass()
 * @method static void checkFields(\Bitrix\Main\ORM\Data\Result $result, $primary, mixed[] $data)
 * @method static \Bitrix\Main\ORM\Data\AddResult add(mixed[] $data)
 * @method static \Bitrix\Main\ORM\Data\AddResult addMulti(mixed[] $rows, bool $ignoreEvents = false)
 * @method static \Bitrix\Main\ORM\Data\UpdateResult update($primary, mixed[] $data)
 * @method static \Bitrix\Main\ORM\Data\UpdateResult updateMulti(mixed[] $primaries, $data, bool $ignoreEvents = false)
 * @method static \Bitrix\Main\ORM\Data\DeleteResult delete(mixed $primary)
 * @method static void enableCrypto(string $field, string $table = null, bool $mode = true)
 * @method static bool cryptoEnabled(string $field, string $table = null)
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
     * Событие до добавления
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
