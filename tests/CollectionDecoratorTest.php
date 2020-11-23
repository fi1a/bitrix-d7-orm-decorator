<?php

declare(strict_types=1);

namespace Fi1a\Unit\BitrixD7OrmDecorator;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\NotImplementedException;
use Fi1a\BitrixD7OrmDecorator\ICollectionDecorator;
use Fi1a\BitrixD7OrmDecorator\IObjectDecorator;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\ElementIBlockTable;
use Fi1a\Unit\BitrixD7OrmDecorator\Fixtures\OriginalDecoratorTable;
use Fi1a\Unit\BitrixD7OrmDecorator\TestCase\IBlockTestCase;

/**
 * Тестирование декоратора Fi1a\BitrixD7OrmDecorator\CollectionDecorator
 */
class CollectionDecoratorTest extends IBlockTestCase
{
    /**
     * Тестирование __call
     *
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testCall(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertInstanceOf(ICollectionDecorator::class, $collection);
        $this->assertCount(3, $collection->getAll());
    }

    /**
     * Тестирование offsetSet
     *
     * @throws ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testOffsetSet(): void
    {
        $iterator = ElementIBlockTable::getList([
            'filter' => [
                '=CODE' => 'element-1',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertInstanceOf(ICollectionDecorator::class, $collection);
        $this->assertCount(1, $collection);
        $iterator = ElementIBlockTable::getList([
            'filter' => [
                '=CODE' => 'element-2',
            ],
            'count_total' => true,
        ]);
        $collection[] = $iterator->fetchObject();
        $this->assertCount(2, $collection);
    }

    /**
     * Исключение при добавлении другого объекта
     *
     * @throws ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testAddToCollectionException(): void
    {
        $iterator = ElementIBlockTable::getList([
            'filter' => [
                '=CODE' => 'element-1',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertInstanceOf(ICollectionDecorator::class, $collection);
        $this->assertCount(1, $collection);
        $this->expectException(ArgumentException::class);
        $collection->add(OriginalDecoratorTable::createObject());
    }

    /**
     * Добавление нового элемента в коллекцию
     *
     * @throws ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testAddToCollectionNewItem(): void
    {
        $iterator = ElementIBlockTable::getList([
            'filter' => [
                '=CODE' => 'element-1',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(1, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertInstanceOf(ICollectionDecorator::class, $collection);
        $this->assertCount(1, $collection);
        $collection->add(ElementIBlockTable::createObject());
        $this->assertCount(2, $collection);
    }

    /**
     * Тестирование метода remove
     *
     * @throws ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testRemove(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertInstanceOf(ICollectionDecorator::class, $collection);
        $this->assertCount(3, $collection);
        $item = $collection->getFirstOccurrence('CODE', 'element-2');
        $this->assertInstanceOf(IObjectDecorator::class, $item);
        $collection->remove($item);
        $this->assertCount(2, $collection);
    }

    /**
     * Удаление и добавление элемента
     *
     * @throws ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testAddToCollectionAddAfterRemove(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertInstanceOf(ICollectionDecorator::class, $collection);
        $this->assertCount(3, $collection);
        $item = $collection->getFirstOccurrence('CODE', 'element-2');
        $this->assertInstanceOf(IObjectDecorator::class, $item);
        $collection->remove($item);
        $this->assertCount(2, $collection);
        $collection->add($item);
        $this->assertCount(3, $collection);
    }

    /**
     * Тестирование offsetExists
     *
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testOffsetExists(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertInstanceOf(ICollectionDecorator::class, $collection);
        $this->expectException(NotImplementedException::class);
        isset($collection[0]);
    }

    /**
     * Тестирование offsetUnset
     *
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testOffsetUnset(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertInstanceOf(ICollectionDecorator::class, $collection);
        $this->expectException(NotImplementedException::class);
        unset($collection[0]);
    }

    /**
     * Тестирование offsetGet
     *
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testOffsetGet(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertInstanceOf(ICollectionDecorator::class, $collection);
        $this->expectException(NotImplementedException::class);
        $collection[0];
    }

    /**
     * Тестирование методов интерфейсов \Iterator и \Countable
     *
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testIterator(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertEquals(3, $collection->count());
        foreach ($collection as $item) {
            $this->assertInstanceOf(IObjectDecorator::class, $item);
        }
        $this->assertNull($collection->key());
        $collection->rewind();
        $this->assertIsInt($collection->key());
    }

    /**
     * Тестирование метода getFirstOccurrence
     *
     * @throws ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testGetFirstOccurrence(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $item = $collection->getFirstOccurrence('CODE', 'element-2');
        $this->assertInstanceOf(IObjectDecorator::class, $item);
        $this->assertEquals('element-2', $item->get('CODE'));
        $this->assertNull($collection->getFirstOccurrence('CODE', 'not-exists'));
    }

    /**
     * Тестирование метода has
     *
     * @throws ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testHas(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $item = $collection->getFirstOccurrence('CODE', 'element-2');
        $this->assertTrue($collection->has($item));
    }

    /**
     * Тестирование fill у коллекции
     *
     * @throws ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testFill(): void
    {
        $iterator = ElementIBlockTable::getList([
            'select' => [
                'CODE',
            ],
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $item = $collection->getFirstOccurrence('CODE', 'element-2');
        $this->assertNull($item->get('NAME'));
        $collection->fill(['NAME']);
        $this->assertEquals('Element 2', $item->get('NAME'));
    }

    /**
     * Тестирование метода hasByPrimary
     *
     * @depends testAdd
     */
    public function testHasByPrimary(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $item = $collection->getFirstOccurrence('CODE', 'element-2');
        $this->assertTrue($collection->hasByPrimary($item->get('ID')));
        $this->assertFalse($collection->hasByPrimary('unknown'));
    }

    /**
     * Тестирование метода getByPrimary
     *
     * @depends testAdd
     */
    public function testGetByPrimary(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $item = $collection->getFirstOccurrence('CODE', 'element-2');
        $this->assertInstanceOf(
            IObjectDecorator::class,
            $collection->getByPrimary($item->get('ID'))
        );
        $this->assertFalse($collection->hasByPrimary('unknown'));
    }

    /**
     * Тестирование метода getAll
     *
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testGetAll(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $this->assertCount(3, $collection->getAll());
    }

    /**
     * Тестирование метода removeByPrimary
     *
     * @depends testAdd
     */
    public function testRemoveByPrimary(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $item = $collection->getFirstOccurrence('CODE', 'element-2');
        $collection->removeByPrimary($item->get('ID'));
        $this->assertCount(2, $collection);
        $this->assertNull($collection->getFirstOccurrence('CODE', 'element-2'));
    }

    /**
     * Тестирование метода save
     *
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testSave(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $item = $collection->getFirstOccurrence('CODE', 'element-2');
        $this->assertEquals('Element 2', $item->get('NAME'));
        $item->set('NAME', 'Element 2 Updated');
        $result = $collection->save();
        $this->assertTrue($result->isSuccess());
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $collection = $iterator->fetchCollection();
        $item = $collection->getFirstOccurrence('CODE', 'element-2');
        $this->assertEquals('Element 2 Updated', $item->get('NAME'));
        $item->set('NAME', 'Element 2');
        $result = $collection->save();
        $this->assertTrue($result->isSuccess());
    }

    /**
     * Тестирование метода wakeUp
     *
     * @throws ArgumentException
     * @throws \Bitrix\Main\SystemException
     *
     * @depends testAdd
     */
    public function testWakeUp(): void
    {
        $iterator = ElementIBlockTable::getList([
            'count_total' => true,
        ]);
        $this->assertEquals(3, $iterator->getSelectedRowsCount());
        $rows = $iterator->fetchAll();
        $collection = ElementIBlockTable::createCollection();
        $this->assertInstanceOf(ICollectionDecorator::class, $collection);
        $this->assertCount(0, $collection);
        $wakeupCollection = $collection::wakeUp($rows);
        $this->assertCount(3, $wakeupCollection);
        $item = $wakeupCollection->getFirstOccurrence('CODE', 'element-2');
        $this->assertEquals('element-2', $item->get('CODE'));
    }
}
