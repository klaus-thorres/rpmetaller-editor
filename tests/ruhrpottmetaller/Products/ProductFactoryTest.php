<?php

namespace ruhrpottmetaller\Products;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Storage;

class ProductFactoryTest extends TestCase
{
    public function  testFactoryMethod_ProductFactoryUsingBandProductNoFilterAndDisplayTypeEqualsDisplayReturnsAStorageContainingBandObject()
    {
        chdir('../../../deploy/');
        $productFactory = new ProductFactory();
        $productFactory->setFilters(array());
        $productFactory->setDisplayType("display");
        $productFactory->setProductName("band");
        $productStorage = $productFactory->factoryMethod();
        self::assertInstanceOf(Storage::class, $productStorage);
        self::assertInstanceOf(Band::class, $productStorage->getNextItem());
    }

}
