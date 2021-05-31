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
        $product_environment_class_name = $namespace . $this->getProductEnvironmentClassName();
        $product_class_name = $namespace . 'Product';
        echo $product_class_name;
        return new $product_environment_class_name(
            mysqliConnect: new MysqliConnect(),
            productStorage: new Storage(),
            product: new $product_class_name(),
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

    protected function getProductEnvironmentClassName(): string
    {
        return ucfirst(string: $this->product_name) . 'Environment';
    }

    protected function getNamespaceName(): string
    {
        return 'ruhrpottmetaller\\Products\\' . ucfirst($this->product_name) . '\\';
    }
}
