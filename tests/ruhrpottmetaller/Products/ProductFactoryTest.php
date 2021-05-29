<?php

namespace ruhrpottmetaller\Products;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\Storage\Storage;

class ProductFactoryTest extends TestCase
{
    public function  testFactoryMethod_ProductFactoryUsingBandProductNoFilterAndDisplayTypeEqualsDisplayReturnsAStorageContainingBandObject()
    {
        chdir('deploy/');
        $productFactory = new ProductFactory();
        $productFactory->setFilters(array());
        $productFactory->setDisplayType("display");
        $productFactory->setProductName("band");
        $productStorage = $productFactory->factoryMethod()->getProducts();
        self::assertInstanceOf(Storage::class, $productStorage);
        self::assertInstanceOf(Band::class, $productStorage->getCurrentItem());
    }

}
