<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator\Fixtures;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\TextField;

/**
 * 1С-Битрикс D7 ORM таблица
 */
class OriginalTable extends DataManager
{
    /**
     * @inheritDoc
     */
    public static function getTableName()
    {
        return 'fl_original';
    }

    /**
     * @inheritDoc
     */
    public static function getMap()
    {
        return [
            'id' => new IntegerField('id', [
                'primary' => true,
                'autocomplete' => true,
            ]),
            'code' => new TextField('code', [
                'required' => true,
            ]),
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getObjectClass()
    {
        return OriginalEntityObject::class;
    }
}
