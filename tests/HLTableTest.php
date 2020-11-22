<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Objectify\Collection;
use Bitrix\Main\ORM\Objectify\EntityObject;
use Bitrix\Main\ORM\Query\Query as BitrixQuery;
use Fi1a\BitrixD7OrmDecorator\ICollectionDecorator;
use Fi1a\BitrixD7OrmDecorator\IEntityObjectDecorator;
use Fi1a\BitrixD7OrmDecorator\Query;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\HL;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\HLTable;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\HLWithoutCollectionTable;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\HLWithoutObjectTable;
use Fi1a\Unit\BitrixD7OrmDecorator\TestCase\HLTestCase;

/**
 * Тестирование декоратора Fi1a\BitrixD7OrmDecorator\ATableDecorator для highloadblock orm
 */
class HLTableTest extends HLTestCase
{
    /**
     * Тестирование метода getList
     *
     * @depends testAdd
     */
    public function testGetList(): void
    {
        $iterator = HLTable::getList([
            'filter' => [
                '=UF_CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var HL $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(HL::class, $item);
        $this->assertEquals('element-2', $item['UF_CODE']);
    }

    /**
     * Тестирование метода getList
     *
     * @depends testAdd
     */
    public function testGetListWithoutObject(): void
    {
        $iterator = HLWithoutObjectTable::getList([
            'filter' => [
                '=UF_CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $item = $iterator->fetchObject();
        $this->assertInstanceOf('\\EO_' . HLTable::$hlName, $item);
        $this->assertEquals('element-2', $item['UF_CODE']);
    }

    /**
     * Тестирование метода getList
     *
     * @depends testAdd
     */
    public function testGetListWithoutCollection(): void
    {
        $iterator = HLWithoutCollectionTable::getList([
            'filter' => [
                '=UF_CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertCount(1, $collection);
    }

    /**
     * Тестирование resetState
     */
    public function testResetState(): void
    {
        HLTable::resetState();
        $this->assertTrue(true);
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
        $iterator = HLTable::getList([
            'filter' => [
                '=UF_CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var HL $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(HL::class, $item);
        $this->assertEquals('element-2', $item['UF_CODE']);
        $itemById = HLTable::getById($item->getId())->fetchObject();
        $this->assertInstanceOf(HL::class, $itemById);
        $this->assertEquals('element-2', $itemById['UF_CODE']);
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
        $iterator = HLTable::getList([
            'filter' => [
                '=UF_CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var HL $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(HL::class, $item);
        $this->assertEquals('element-2', $item['UF_CODE']);
        $itemById = HLTable::getByPrimary($item->getId())->fetchObject();
        $this->assertInstanceOf(HL::class, $itemById);
        $this->assertEquals('element-2', $itemById['UF_CODE']);
    }

    /**
     * Тестирование createObject
     *
     * @depends testAdd
     */
    public function testCreateObject(): void
    {
        $this->assertInstanceOf(IEntityObjectDecorator::class, HLTable::createObject());
        $this->assertInstanceOf(EntityObject::class, HLWithoutObjectTable::createObject());
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
            HLTable::createCollection()
        );
        $this->assertInstanceOf(
            Collection::class,
            HLWithoutCollectionTable::createCollection()
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
        $iterator = HLTable::getList([
            'filter' => [
                '=UF_CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $row = $iterator->fetch();
        $item = HLTable::wakeUpObject($row);
        $this->assertInstanceOf(IEntityObjectDecorator::class, $item);
        $this->assertEquals('element-2', $item->get('UF_CODE'));
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
        $iterator = HLWithoutObjectTable::getList([
            'filter' => [
                '=UF_CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $row = $iterator->fetch();
        $item = HLWithoutObjectTable::wakeUpObject($row);
        $this->assertInstanceOf(EntityObject::class, $item);
        $this->assertEquals('element-2', $item->get('UF_CODE'));
    }

    /**
     * Тестирование wakeUpCollection
     *
     * @depends testAdd
     */
    public function testWakeUpCollection(): void
    {
        $iterator = HLTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $rows = $iterator->fetchAll();
        $collection = HLTable::wakeUpCollection($rows);
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
        $iterator = HLWithoutCollectionTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $rows = $iterator->fetchAll();
        $collection = HLWithoutCollectionTable::wakeUpCollection($rows);
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
        $query = HLTable::query();
        $this->assertInstanceOf(Query::class, $query);
    }

    /**
     * Тестирование query
     *
     * @depends testAdd
     */
    public function testQueryWithoutObject(): void
    {
        $query = HLWithoutObjectTable::query();
        $this->assertInstanceOf(BitrixQuery::class, $query);
    }

    /**
     * Тестирование событий
     *
     * @depends testAdd
     */
    public function testBindEvents(): void
    {
        HLTable::bindEvents();
        /**
         * @var HL $item
         */
        $item = HLTable::createObject();
        $item->set('UF_CODE', 'bind-events-1');
        $result = $item->save();
        $this->assertTrue($result->isSuccess());
        $this->assertEquals('bind-events-1-onBeforeAdd', $item->get('UF_CODE'));
        $item->set('UF_CODE', 'bind-events-1');
        $result = $item->save();
        $this->assertTrue($result->isSuccess());
        $item->delete();
    }
}
