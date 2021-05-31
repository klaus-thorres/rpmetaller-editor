<?php

namespace ruhrpottmetaller\Products;

use ruhrpottmetaller\MysqliConnect;
use ruhrpottmetaller\Storage\Storage;

class ProductFactory
{
    protected string $product_name;
    protected string $display_type;
    protected array $filters;

    public function factoryMethod(): AbstractReadFromDatabase
    {
        $namespace = $this->getNamespaceName();
        $read_from_database_class = $namespace . 'ReadFromDatabase';
        $product_class = $namespace . 'Product';
        return new $read_from_database_class(
            mysqliConnect: new MysqliConnect(),
            productStorage: new Storage(),
            product: new $product_class(),
            filters: $this->filters,
            display_type: $this->display_type
        );
    }

    public function setProductName($product_name):void
    {
        $this->product_name = $product_name;
    }

    public function setFilters($filters):void
    {
        $this->filters = $filters;
    }

    public function setDisplayType($display_type):void
    {
        $this->display_type = $display_type;
    }

    protected function getNamespaceName(): string
    {
        return 'ruhrpottmetaller\\Products\\' . ucfirst($this->product_name) . '\\';
    }
}
