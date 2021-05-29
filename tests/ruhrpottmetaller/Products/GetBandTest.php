<?php

namespace ruhrpottmetaller\Products;

use PHPUnit\Framework\TestCase;
use ruhrpottmetaller\MysqliConnect;
use ruhrpottmetaller\Storage\Storage;

class GetBandTest extends TestCase
{
    protected MysqliConnect $mysqliConnect;
    protected IProduct $product;

    protected function setUp(): void
    {
        parent::setUp();
        chdir('deploy/');
        $this->mysqliConnect = new MysqliConnect();
        $this->product = new Band();
    }

    public function testGetProducts_ReturnAStorageObjectWhichContainsAMinimumOfABandObject()
    {
        $productStorage = new Storage();
        $bandGetter = new BandEnvironment(
            $this->mysqliConnect,
            $productStorage,
            product: $this->product,
            filters: array(),
            display_type: 'display'
        );
        $productStorage = $bandGetter->getProducts();
        self::assertInstanceOf(Storage::class, $productStorage);
        self::assertInstanceOf(Band::class, $productStorage->getCurrentItem());
    }

}
