<?php

namespace ruhrpottmetaller\Storage;

use PHPUnit\Framework\TestCase;

use ruhrpottmetaller\Commands\GetCommand;
use ruhrpottmetaller\Products\Band\Product;
use ruhrpottmetaller\Products\ProductFactory;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class StorageTest extends TestCase
{
    public function testIsDone_ifNoItemIsAddedIsDoneIsAlwaysTrue()
    {
        $storage = new Storage();
        assertTrue($storage->isDone());
    }

    public function testIsDone_ifOneItemIsAddedAndPointerIsNotSetToNextItemIsDoneReturnsFalse()
    {
        $storage = new Storage();
        $storage->addItem(new Product());
        assertFalse($storage->isDone());
    }

    public function testIsDone_ifOneItemIsAddedAndPointerIsSetToNextItemOnceReturnTrue()
    {
        $storage = new Storage();
        $storage->addItem((new Product()));
        $storage->setPointerToNextItem();
        self::assertTrue($storage->isDone());
    }

    public function testGetCurrentItem_IfNoItemIsAddedThrowException()
    {
        $this->expectExceptionMessage( 'Pointer references to no item.');
        $storage = new Storage();
        $storage->getCurrentItem();
    }

    public function testGetCurrentItem_IfOneItemIsAddedGetTheItemBackIfPointerIsNotMoved()
    {
        $storage = new Storage();
        $item = new Product();
        $storage->addItem($item);
        self::assertEquals($item, $storage->getCurrentItem());

    }

    public function testIsDone_IfPointerIsSetToNextItemAndNoItemIsAddedReturnAlsoTrue()
    {
        $storage = new Storage();
        $storage->setPointerToNextItem();
        assertTrue($storage->isDone());
    }

    public function testGetCurrentItem_IfTwoItemsAreAddedGetCurrentReturnsTheFirstAndGetCurrentAfterPointerIsSetToNextItemReturnsTheSecond()
    {
        $storage = new Storage();
        $item_1 = new Product();
        $item_2 = new GetCommand(new ProductFactory());
        $storage->addItem($item_1);
        $storage->addItem($item_2);
        assertEquals($item_1, $storage->getCurrentItem());
        $storage->setPointerToNextItem();
        assertEquals($item_2, $storage->getCurrentItem());
    }
}
