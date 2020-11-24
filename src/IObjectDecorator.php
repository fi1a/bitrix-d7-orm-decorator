<?php

declare(strict_types=1);

namespace Fi1a\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Objectify\EntityObject;

/**
 * Интерфейс декоратора \Bitrix\Main\ORM\Objectify\EntityObject
 *
 * @method mixed[] collectValues($valuesType, $fieldsMask)
 * @method \Bitrix\Main\ORM\Data\Result save()
 * @method \Bitrix\Main\ORM\Data\Result delete()
 * @method mixed fill($fields = \Bitrix\Main\ORM\Fields\FieldTypeMask::ALL)
 * @method int getId()
 * @method mixed get(string $fieldName)
 * @method mixed remindActual(string $fieldName)
 * @method mixed require(string $fieldName)
 * @method mixed set(string $fieldName, mixed $value)
 * @method mixed reset(string $fieldName)
 * @method mixed unset(string $fieldName)
 * @method bool has(string $fieldName)
 * @method bool isFilled(string $fieldName)
 * @method bool isChanged(string $fieldName)
 * @method mixed addTo(string $fieldName, mixed $value)
 * @method mixed removeFrom(string $fieldName, mixed $value)
 * @method mixed removeAll(string $fieldName)
 * @method void defineAuthContext(\Bitrix\Main\Authentication\Context $authContext)
 */
interface IObjectDecorator extends \ArrayAccess
{
    /**
     * Возвращает объект Bitrix\Main\ORM\Objectify\EntityObject
     */
    public function getEntityObject(): EntityObject;
}
