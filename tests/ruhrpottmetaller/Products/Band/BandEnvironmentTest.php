<?php

namespace ruhrpottmetaller\Products\Band;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\MysqliConnect;
use ruhrpottmetaller\Products\IProduct;
use ruhrpottmetaller\Storage\Storage;

class BandEnvironmentTest extends TestCase
{
    protected MysqliConnect $mysqliConnect;
    protected IProduct $product;

    protected function setUp(): void
    {
        parent::setUp();
        chdir('deploy/');
        $this->mysqliConnect = new MysqliConnect();
        $this->product = new Product();
    }

    public function testGetProducts_ReturnAStorageObjectWhichContainsAMinimumOfABandObject()
    {
        $productStorage = new Storage();
        $bandGetter = new Environment(
            $this->mysqliConnect,
            $productStorage,
            product: $this->product,
            filters: array(),
            display_type: 'display'
        );
        $productStorage = $bandGetter->getProducts();
        self::assertInstanceOf(Storage::class, $productStorage);
        self::assertInstanceOf(Product::class, $productStorage->getCurrentItem());
    }

}
