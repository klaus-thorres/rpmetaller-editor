<?php

namespace ruhrpottmetaller\Products;

use ruhrpottmetaller\MysqliConnect;
use ruhrpottmetaller\Storage\Storage;

class ProductFactory
{
    protected string $product_name;
    protected string $display_type;
    protected array $filters;

    public function factoryMethod(): AbstractProductEnvironment
    {
        $namespace = $this->getNamespaceName();
        $productEnvironmentClassName = $namespace . $this->getProductEnvironmentClassName();
        $productClassName = $namespace . $this->getProductClassName();
        return new $productEnvironmentClassName(
            mysqliConnect: new MysqliConnect(),
            productStorage: new Storage(),
            product: new $productClassName(),
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

    protected function getProductClassName(): string
    {
        return ucfirst(string: $this->product_name);
    }

    protected function getProductEnvironmentClassName(): string
    {
        return ucfirst(string: $this->product_name) . 'Environment';
    }

    protected function getNamespaceName(): string
    {
        return 'ruhrpottmetaller\\Products\\' . ucfirst($this->product_name) . '\\';
    }
}
