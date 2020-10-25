<?php

declare(strict_types=1);

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
