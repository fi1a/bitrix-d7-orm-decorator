<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Objectify\Collection;
use Bitrix\Main\ORM\Objectify\EntityObject;
use Bitrix\Main\ORM\Query\Query as BitrixQuery;
use Fi1a\BitrixD7OrmDecorator\ICollectionDecorator;
use Fi1a\BitrixD7OrmDecorator\IObjectDecorator;
use Fi1a\BitrixD7OrmDecorator\Query;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\OriginalDecoratorObject;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\OriginalDecoratorTable;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\OriginalDecoratorWithoutCollectionTable;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\OriginalDecoratorWithoutObjectTable;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\OriginalObject;
use Fi1a\Unit\BitrixD7OrmDecorator\TestCase\OriginalTestCase;

/**
 * Тестирование декоратора Fi1a\BitrixD7OrmDecorator\ATableDecorator
 */
class OriginalTableTest extends OriginalTestCase
{
    /**
     * Тестирование метода getList
     *
     * @depends testAdd
     */
    public function testGetList(): void
    {
        $iterator = OriginalDecoratorTable::getList([
            'filter' => [
                '=code' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var OriginalDecoratorObject $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(OriginalDecoratorObject::class, $item);
        $this->assertEquals('element-2', $item['code']);
    }

    /**
     * Тестирование метода getList
     *
     * @depends testAdd
     */
    public function testGetListWithoutObject(): void
    {
        $iterator = OriginalDecoratorWithoutObjectTable::getList([
            'filter' => [
                '=code' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(OriginalObject::class, $item);
        $this->assertEquals('element-2', $item['code']);
    }

    /**
     * Тестирование метода getList
     *
     * @depends testAdd
     */
    public function testGetListWithoutCollection(): void
    {
        $iterator = OriginalDecoratorWithoutCollectionTable::getList([
            'filter' => [
                '=code' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(1, $collection);
    }

    /**
     * Тестирование getById
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testGetById(): void
    {
        $iterator = OriginalDecoratorTable::getList([
            'filter' => [
                '=code' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var OriginalDecoratorObject $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(OriginalDecoratorObject::class, $item);
        $this->assertEquals('element-2', $item['code']);
        $itemById = OriginalDecoratorTable::getById($item->getId())->fetchObject();
        $this->assertInstanceOf(OriginalDecoratorObject::class, $itemById);
        $this->assertEquals('element-2', $itemById['code']);
    }

    /**
     * Тестирование getById
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testGetByPrimary(): void
    {
        $iterator = OriginalDecoratorTable::getList([
            'filter' => [
                '=code' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var OriginalDecoratorObject $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(OriginalDecoratorObject::class, $item);
        $this->assertEquals('element-2', $item['code']);
        $itemById = OriginalDecoratorTable::getByPrimary($item->getId())->fetchObject();
        $this->assertInstanceOf(OriginalDecoratorObject::class, $itemById);
        $this->assertEquals('element-2', $itemById['code']);
    }

    /**
     * Тестирование createObject
     *
     * @depends testAdd
     */
    public function testCreateObject(): void
    {
        $this->assertInstanceOf(IObjectDecorator::class, OriginalDecoratorTable::createObject());
        $this->assertInstanceOf(EntityObject::class, OriginalDecoratorWithoutObjectTable::createObject());
    }

    /**
     * Тестирование createCollection
     *
     * @depends testAdd
     */
    public function testCreateCollection(): void
    {
        $this->assertInstanceOf(
            ICollectionDecorator::class,
            OriginalDecoratorTable::createCollection()
        );
        $this->assertInstanceOf(
            Collection::class,
            OriginalDecoratorWithoutCollectionTable::createCollection()
        );
    }

    /**
     * Тестирование wakeUpObject
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testWakeUpObject(): void
    {
        $iterator = OriginalDecoratorTable::getList([
            'filter' => [
                '=code' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $row = $iterator->fetch();
        $item = OriginalDecoratorTable::wakeUpObject($row);
        $this->assertInstanceOf(IObjectDecorator::class, $item);
        $this->assertEquals('element-2', $item->get('code'));
    }

    /**
     * Тестирование wakeUpObject
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testWakeUpObjectWithoutObject(): void
    {
        $iterator = OriginalDecoratorWithoutObjectTable::getList([
            'filter' => [
                '=code' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $row = $iterator->fetch();
        $item = OriginalDecoratorWithoutObjectTable::wakeUpObject($row);
        $this->assertInstanceOf(EntityObject::class, $item);
        $this->assertEquals('element-2', $item->get('code'));
    }

    /**
     * Тестирование wakeUpCollection
     *
     * @depends testAdd
     */
    public function testWakeUpCollection(): void
    {
        $iterator = OriginalDecoratorTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $rows = $iterator->fetchAll();
        $collection = OriginalDecoratorTable::wakeUpCollection($rows);
        $this->assertInstanceOf(ICollectionDecorator::class, $collection);
        $this->assertCount(3, $collection);
    }

    /**
     * Тестирование wakeUpCollection
     *
     * @depends testAdd
     */
    public function testWakeUpCollectionWithoutCollection(): void
    {
        $iterator = OriginalDecoratorWithoutCollectionTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $rows = $iterator->fetchAll();
        $collection = OriginalDecoratorWithoutCollectionTable::wakeUpCollection($rows);
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(3, $collection);
    }

    /**
     * Тестирование query
     *
     * @depends testAdd
     */
    public function testQuery(): void
    {
        $query = OriginalDecoratorTable::query();
        $this->assertInstanceOf(Query::class, $query);
    }

    /**
     * Тестирование query
     *
     * @depends testAdd
     */
    public function testQueryWithoutObject(): void
    {
        $query = OriginalDecoratorWithoutObjectTable::query();
        $this->assertInstanceOf(BitrixQuery::class, $query);
    }

    /**
     * Тестирование событий
     */
    public function testBindEvents(): void
    {
        OriginalDecoratorTable::bindEvents();
        /**
         * @var OriginalDecoratorObject $item
         */
        $item = OriginalDecoratorTable::createObject();
        $item->set('code', 'bind-events-1');
        $result = $item->save();
        $this->assertTrue($result->isSuccess());
        $this->assertEquals('bind-events-1-onBeforeAdd', $item->get('code'));
        $item->set('code', 'bind-events-1');
        $result = $item->save();
        $this->assertTrue($result->isSuccess());
        $item->delete();
    }
}
