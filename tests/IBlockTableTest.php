<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Bitrix\Main\ORM\Objectify\Collection;
use Bitrix\Main\ORM\Objectify\EntityObject;
use Bitrix\Main\ORM\Query\Query as BitrixQuery;
use Fi1a\BitrixD7OrmDecorator\Exception\ErrorException;
use Fi1a\BitrixD7OrmDecorator\ICollectionDecorator;
use Fi1a\BitrixD7OrmDecorator\IEntityObjectDecorator;
use Fi1a\BitrixD7OrmDecorator\Query;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlock;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlockTable;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlockUnknownTable;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlockWithoutCollectionTable;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlockWithoutObjectTable;
use Fi1a\Unit\BitrixD7OrmDecorator\TestCase\IBlockTestCase;

/**
 * Тестирование декоратора Fi1a\BitrixD7OrmDecorator\ATableDecorator для iblock orm
 */
class IBlockTableTest extends IBlockTestCase
{
    /**
     * Тестирование метода getList
     *
     * @depends testAdd
     */
    public function testGetList(): void
    {
        $iterator = ElementIBlockTable::getList([
            'filter' => [
                '=CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var ElementIBlock $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(ElementIBlock::class, $item);
        $this->assertEquals('element-2', $item['CODE']);
    }

    /**
     * Тестирование метода getList
     *
     * @depends testAdd
     */
    public function testGetListWithoutObject(): void
    {
        $iterator = ElementIBlockWithoutObjectTable::getList([
            'filter' => [
                '=CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $item = $iterator->fetchObject();
        $this->assertInstanceOf('Bitrix\Iblock\Elements\EO_ElementIBlock', $item);
        $this->assertEquals('element-2', $item['CODE']);
    }

    /**
     * Тестирование метода getList
     *
     * @depends testAdd
     */
    public function testGetListWithoutCollection(): void
    {
        $iterator = ElementIBlockWithoutCollectionTable::getList([
            'filter' => [
                '=CODE' => 'element-2',
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
     *
     * @depends testAdd
     */
    public function testResetState(): void
    {
        ElementIBlockTable::resetState();
        $this->assertTrue(true);
    }

    /**
     * Тестирование doGetTableClass
     *
     * @depends testAdd
     */
    public function testDoGetTableClassException(): void
    {
        $this->expectException(ErrorException::class);
        ElementIBlockUnknownTable::getList();
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
        $iterator = ElementIBlockTable::getList([
            'filter' => [
                '=CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var ElementIBlock $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(ElementIBlock::class, $item);
        $this->assertEquals('element-2', $item['CODE']);
        $itemById = ElementIBlockTable::getById($item->getId())->fetchObject();
        $this->assertInstanceOf(ElementIBlock::class, $itemById);
        $this->assertEquals('element-2', $itemById['CODE']);
    }

    /**
     * Тестирование getByPrimary
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testGetByPrimary(): void
    {
        $iterator = ElementIBlockTable::getList([
            'filter' => [
                '=CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        /**
         * @var ElementIBlock $item
         */
        $item = $iterator->fetchObject();
        $this->assertInstanceOf(ElementIBlock::class, $item);
        $this->assertEquals('element-2', $item['CODE']);
        $itemById = ElementIBlockTable::getByPrimary($item->getId())->fetchObject();
        $this->assertInstanceOf(ElementIBlock::class, $itemById);
        $this->assertEquals('element-2', $itemById['CODE']);
    }

    /**
     * Тестирование createObject
     *
     * @depends testAdd
     */
    public function testCreateObject(): void
    {
        $this->assertInstanceOf(IEntityObjectDecorator::class, ElementIBlockTable::createObject());
        $this->assertInstanceOf(EntityObject::class, ElementIBlockWithoutObjectTable::createObject());
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
            ElementIBlockTable::createCollection()
        );
        $this->assertInstanceOf(
            Collection::class,
            ElementIBlockWithoutCollectionTable::createCollection()
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
        $iterator = ElementIBlockTable::getList([
            'filter' => [
                '=CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $row = $iterator->fetch();
        $item = ElementIBlockTable::wakeUpObject($row);
        $this->assertInstanceOf(IEntityObjectDecorator::class, $item);
        $this->assertEquals('element-2', $item->get('CODE'));
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
        $iterator = ElementIBlockWithoutObjectTable::getList([
            'filter' => [
                '=CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $row = $iterator->fetch();
        $item = ElementIBlockWithoutObjectTable::wakeUpObject($row);
        $this->assertInstanceOf(EntityObject::class, $item);
        $this->assertEquals('element-2', $item->get('CODE'));
    }

    /**
     * Тестирование wakeUpCollection
     *
     * @depends testAdd
     */
    public function testWakeUpCollection(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $rows = $iterator->fetchAll();
        $collection = ElementIBlockTable::wakeUpCollection($rows);
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
        $iterator = ElementIBlockWithoutCollectionTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $rows = $iterator->fetchAll();
        $collection = ElementIBlockWithoutCollectionTable::wakeUpCollection($rows);
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
        $query = ElementIBlockTable::query();
        $this->assertInstanceOf(Query::class, $query);
    }

    /**
     * Тестирование query
     *
     * @depends testAdd
     */
    public function testQueryWithoutObject(): void
    {
        $query = ElementIBlockWithoutObjectTable::query();
        $this->assertInstanceOf(BitrixQuery::class, $query);
    }
}
