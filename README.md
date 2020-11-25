# Классы декораторы для 1С-Битрикс D7 ORM.

[![Latest Version][badge-release]][packagist]
[![Software License][badge-license]][license]
[![PHP Version][badge-php]][php]
[![Total Downloads][badge-downloads]][downloads]

Библиотека решает следующие задачи:

1. Классы таблиц, объектов и коллекций orm в своем namespace для iblock orm и highloadblock orm;
1. Использование уже сконфигурированных классов таблиц для iblock orm и highloadblock orm;
1. Возможность добавлять к классам таблиц, объектов и коллекций свои методы.

## Установка

Установить этот пакет можно как зависимость, используя Composer.

``` bash
composer require fi1a/bitrix-d7-orm-decorator
```

## Использование

### Декораторы для iblock orm

#### Декоратор таблицы

Для объявления декоратора таблицы необходимо:

1. Статичное свойство ```$tableClass``` со значением ```null```;
1. Метод ```getApiCode``` должен возвращать значение API-кода заданного в настройках инфоблока;
1. Метод ```doGetObjectDecoratorClass``` должен возвращать название класса декоратора объекта;
1. Метод ```doGetCollectionDecoratorClass``` должен возвращать название класса декоратора коллекции.

```php

namespace Foo\Bar;

use Fi1a\BitrixD7OrmDecorator\AIBlockTableDecorator;
use Fi1a\BitrixD7OrmDecorator\ResultDecorator;
use Bitrix\Main\ORM\Event;
use Bitrix\Main\Entity\EntityError;
use Bitrix\Main\Entity\EventResult;

/**
 * Таблица элемента инфоблока
 */
class BazTable extends AIBlockTableDecorator
{
    /**
     * @var string
     */
    protected static $tableClass = null;

    /**
     * @inheritDoc
     */
    protected static function getApiCode(): string
    {
        return 'Baz';
    }

    /**
     * @inheritDoc
     */
    protected static function doGetObjectDecoratorClass(): ?string
    {
        return Baz::class;
    }

    /**
     * @inheritDoc
     */
    protected static function doGetCollectionDecoratorClass(): ?string
    {
        return BazCollection::class;
    }

    /**
     * Поиск элементов по символьному коду
     *
     * @param string $code
     *
     * @return ResultDecorator
     */
    public static function getByCode(string $code): ResultDecorator
    {
        if (!$code) {
            throw new \InvalidArgumentException();
        }

        return static::getList([
            'filter' => [
                'CODE' => $code,
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public static function onBeforeDelete(Event $event): EventResult
    {
        $result = parent::onBeforeDelete($event);
        $result->addError(new EntityError('onBeforeDelete'));
        
        return $result;
    }
}
```

#### Декоратор объекта

Для объявления декоратора объекта необходимо:

1. Метод ```getObjectClass``` должен возвращать название класса объекта сконфигурированный битриксом.

```php

namespace Foo\Bar;

use Fi1a\BitrixD7OrmDecorator\AObjectDecorator;
use Bitrix\Iblock\Elements\EO_ElementBaz;

/**
 * Объект элемента инфоблока
 */
class Baz extends AObjectDecorator
{
    /**
     * @inheritDoc
     */
    protected function getObjectClass(): string
    {
        return EO_ElementBaz::class;
    }

    /**
     * Пользовательский метод объекта
     *
     * @param int $value
     *
     * @return int
     */
    public function getSumm(int $value): int
    {
        $this->fill(['NUMERIC']);

        return $this->get('NUMERIC')->getValue() + $value;
    }
}
```

#### Декоратор коллекции

Для объявления декоратора коллекции необходимо:

1. Метод ```doGetObjectDecoratorClass``` должен возвращать название класса декоратора объекта;
1. Метод ```doGetTableDecoratorClass``` должен возвращать название класса декоратора таблицы;

```php

namespace Foo\Bar;

use Fi1a\BitrixD7OrmDecorator\ACollectionDecorator;

/**
 * Коллекция элемента инфоблока
 */
class BazCollection extends ACollectionDecorator
{
    /**
     * @inheritDoc
     */
    protected static function doGetObjectDecoratorClass(): string
    {
        return Baz::class;
    }

    /**
     * @inheritDoc
     */
    protected static function doGetTableDecoratorClass(): string
    {
        return BazTable::class;
    }
}
```

### Декораторы для highloadblock orm

#### Декоратор таблицы

Для объявления декоратора таблицы необходимо:

1. Статичное свойство ```$tableClass``` со значением ```null```;
1. Метод ```getName``` должен возвращать название highloadblock'а заданного в настройках;
1. Метод ```doGetObjectDecoratorClass``` должен возвращать название класса декоратора объекта;
1. Метод ```doGetCollectionDecoratorClass``` должен возвращать название класса декоратора коллекции.

```php

namespace Foo\Bar;

use Fi1a\BitrixD7OrmDecorator\AHLTableDecorator;
use Fi1a\BitrixD7OrmDecorator\ResultDecorator;
use Bitrix\Main\ORM\Event;
use Bitrix\Main\Entity\EntityError;
use Bitrix\Main\Entity\EventResult;

/**
 * Таблица highloadblock'а
 */
class BazTable extends AHLTableDecorator
{
    /**
     * @var string
     */
    protected static $tableClass = null;

    /**
     * @inheritDoc
     */
    protected static function getName(): string
    {
        return 'Baz';
    }

    /**
     * @inheritDoc
     */
    protected static function doGetObjectDecoratorClass(): ?string
    {
        return Baz::class;
    }

    /**
     * @inheritDoc
     */
    protected static function doGetCollectionDecoratorClass(): ?string
    {
        return BazCollection::class;
    }

    /**
     * Поиск элементов по символьному коду
     *
     * @param string $code
     *
     * @return ResultDecorator
     */
    public static function getByCode(string $code): ResultDecorator
    {
        if (!$code) {
            throw new \InvalidArgumentException();
        }

        return static::getList([
            'filter' => [
                'UF_CODE' => $code,
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public static function onBeforeDelete(Event $event): EventResult
    {
        $result = parent::onBeforeDelete($event);
        $result->addError(new EntityError('onBeforeDelete'));
        
        return $result;
    }
}
```

#### Декоратор объекта

Для объявления декоратора объекта необходимо:

1. Метод ```getObjectClass``` должен возвращать название класса объекта сконфигурированный битриксом.

```php

namespace Foo\Bar;

use Fi1a\BitrixD7OrmDecorator\AObjectDecorator;

/**
 * Объект highloadblock'а
 */
class Baz extends AObjectDecorator
{
    /**
     * @inheritDoc
     */
    protected function getObjectClass(): string
    {
        return '\\EO_Baz';
    }

    /**
     * Пользовательский метод объекта
     *
     * @param int $value
     *
     * @return int
     */
    public function getSumm(int $value): int
    {
        $this->fill(['UF_NUMERIC']);

        return $this->get('UF_NUMERIC') + $value;
    }
}
```

#### Декоратор коллекции

Для объявления декоратора коллекции необходимо:

1. Метод ```doGetObjectDecoratorClass``` должен возвращать название класса декоратора объекта;
1. Метод ```doGetTableDecoratorClass``` должен возвращать название класса декоратора таблицы;

```php

namespace Foo\Bar;

use Fi1a\BitrixD7OrmDecorator\ACollectionDecorator;

/**
 * Коллекция элемента инфоблока
 */
class BazCollection extends ACollectionDecorator
{
    /**
     * @inheritDoc
     */
    protected static function doGetObjectDecoratorClass(): string
    {
        return Baz::class;
    }

    /**
     * @inheritDoc
     */
    protected static function doGetTableDecoratorClass(): string
    {
        return BazTable::class;
    }
}
```

### Примеры использования

Получить декоратор объекта, задать значения полей и свойств, сохранить элемент инфоблока.

```php

use Foo\Bar\BazTable;

$bazObject = BazTable::createObject(true);
get_class($bazObject); // Foo\Bar\Baz
$bazObject->set('NAME', 'Baz element'); // Поле NAME
$bazObject->set('CODE', 'baz-element'); // Поле CODE
$bazObject->set('STRING', 'string'); // Свойство с кодом "STRING"
$bazObject->set('NUMERIC', 100500); // Свойство с кодом "NUMERIC"
$addResult = $bazObject->save();
$addResult->isSuccess(); // true
```

Выбрать все элементы инфоблока с символьным кодом 'baz-element'. Получить декоратор коллекции.
Задать название элементам и сохранить все элементы коллекции методом коллекции ```save```.

```php

use Foo\Bar\BazTable;

$bazCollection = BazTable::getByCode('baz-element')->fetchCollection();
get_class($bazCollection); // Foo\Bar\BazCollection
foreach ($bazCollection as $bazObject) {
    get_class($bazObject); // Foo\Bar\Baz
    $bazObject->set('NAME', 'Baz element collection update');
}
$result = $bazCollection->save();
$result->isSuccess(); // true
```

Используя класс запроса, выбрать все элементы инфоблока с кодом 'baz-element'.

```php

use Foo\Bar\BazTable;

$iterator = BazTable::query()
    ->setSelect(['*', 'NUMERIC'])
    ->where('CODE', 'baz-element')
    ->exec();

get_class($iterator); // Fi1a\BitrixD7OrmDecorator\ResultDecorator
while ($bazObject = $iterator->fetchObject()) {
    get_class($bazObject); // Foo\Bar\Baz
    $bazObject->get('NUMERIC')->getValue(); // 100500
    $bazObject->getSumm(100); // 100600
}
```

### Зарегистрировать обработчики событий

Для регистрации обработчиков событий (onBeforeAdd, onAdd, onAfterAdd, onBeforeUpdate, onUpdate, onAfterUpdate,
onBeforeDelete, onDelete, onAfterDelete) необходимо вызвать метод ```bindEvents``` соответствующего класса декоратора
таблицы (например можно вызвать в файле init.php).

```php

use Foo\Bar\BazTable;

BazTable::bindEvents();

$bazObject = BazTable::getByCode('baz-element')->fetchObject();
$deleteResult = $bazObject->delete();
$deleteResult->isSuccess(); // false
$deleteResult->getErrorMessages(); // ['onBeforeDelete']
```

## Тестирование

Перед использованием библиотеки рекомендуем запустить тесты на вашей версии битрикс (на тестовой установке).
Для этого необходимо создать файл tests/.env (пример: tests/.env.example) где: BITRIX_DIR должен содержать путь
до тестовой установки битрикса на котором будут выполняться тесты.

Запуск тестов из папки библиотеки:

```
phpunit --configuration phpunit.xml.dist
```

[badge-release]: https://img.shields.io/packagist/v/fi1a/bitrix-d7-orm-decorator?label=release
[badge-license]: https://img.shields.io/github/license/fi1a/bitrix-d7-orm-decorator?style=flat-square
[badge-php]: https://img.shields.io/packagist/php-v/fi1a/bitrix-d7-orm-decorator?style=flat-square
[badge-downloads]: https://img.shields.io/packagist/dt/fi1a/bitrix-d7-orm-decorator.svg?style=flat-square&colorB=mediumvioletred

[packagist]: https://packagist.org/packages/fi1a/bitrix-d7-orm-decorator
[license]: https://github.com/fi1a/bitrix-d7-orm-decorator/blob/master/LICENSE
[php]: https://php.net
[downloads]: https://packagist.org/packages/fi1a/bitrix-d7-orm-decorator