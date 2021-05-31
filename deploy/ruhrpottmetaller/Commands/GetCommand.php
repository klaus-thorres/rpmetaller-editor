<?php


namespace ruhrpottmetaller\Commands;

use ruhrpottmetaller\Products\ProductFactory;

class GetCommand extends AbstractCommand
{
    public function __construct(
        ProductFactory $productFactory,
    ) {
        $this->productFactory = $productFactory;
    }

    public function execute()
    {
        $productStorage = $this->productFactory->factoryMethod();
        while (!$productStorage->isDone())
        {
            $productStorage->getCurrentItem()->prepareData();
            $productStorage->setPointerToNextItem();
        }
    }
}
