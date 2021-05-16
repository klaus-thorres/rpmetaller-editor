<?php

namespace ruhrpottmetaller\Products;

use ruhrpottmetaller\MysqliConnect;
use ruhrpottmetaller\Storage;

class ProductFactory
{
    protected string $product_name;
    protected string $display_type;
    protected array $filters;

    public function factoryMethod(): Storage
    {
        $namespace = "ruhrpottmetaller\\Products\\";
        $productGetterClassName = $namespace . $this->getProductGetterClassName(product_name: $this->product_name);
        $productClassName = $namespace . $this->getProductClassName(product_name: $this->product_name);
        $productGetter = new $productGetterClassName(
            mysqliConnect: new MysqliConnect(db_config_file: "includes/db_preferences.inc.php"),
            productStorage: new Storage(),
            product: new $productClassName(),
            filters: $this->filters,
            display_type: $this->display_type
        );
        return $productGetter->getProducts();
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

    protected function getProductClassName(string $product_name): string
    {
        return ucfirst(string: $product_name);
    }

    protected function getProductGetterClassName(string $product_name): string
    {
        return 'Get' . ucfirst(string: $product_name);
    }


}