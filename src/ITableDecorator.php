<?php

namespace Fi1a\BitrixD7OrmDecorator;

/**
 * Интерфейс декоратора Bitrix\Main\ORM\Data\DataManager
 */
interface ITableDecorator
{
    /**
     * Сбрасывает состояние
     */
    public static function resetState(): void;
}
