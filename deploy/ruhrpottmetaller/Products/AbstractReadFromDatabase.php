<?php

namespace ruhrpottmetaller\Products;

use mysqli;
use mysqli_result;
use mysqli_stmt;
use ruhrpottmetaller\MysqliConnect;
use ruhrpottmetaller\Storage\Storage;

abstract class AbstractReadFromDatabase
{
    protected MysqliConnect $mysqliConnect;
    protected Storage $productStorage;
    protected IProduct $product;

    public function  __construct(
        MysqliConnect $mysqliConnect,
        Storage $productStorage,
        IProduct $product,
    ) {
        $this->mysqliConnect = $mysqliConnect;
        $this->productStorage = $productStorage;
        $this->product = $product;
    }

    abstract protected function getPreparedMysqliStatement(mysqli $mysqli, array $filters);

    public function getProducts(array $filters): Storage
    {
        $mysqli = $this->mysqliConnect->getMysqli();
        $mysqliStatement = $this->getPreparedMysqliStatement(
            mysqli: $mysqli,
            filters: $filters,
        );
        $mysqliResult = $this->getMysqliResult(mysqliStatement: $mysqliStatement);
        $this->fillProductStorage(mysqliResult: $mysqliResult);
        return $this->productStorage;
    }

    private function getMysqliResult(mysqli_stmt $mysqliStatement): mysqli_result
    {
        $mysqliStatement->execute();
        $mysqliResult = $mysqliStatement->get_result();
        $mysqliStatement->close();
        return $mysqliResult;
    }

    private function fillProductStorage(mysqli_result $mysqliResult): void
    {
        while ($product_data = $mysqliResult->fetch_assoc()) {
            $this->productStorage->addItem($this->fillProduct(product_data: $product_data));
        }
    }

    private function fillProduct(array $product_data): IProduct
    {
        $product = clone $this->product;
        $product->setInitialData($product_data);
        return $product;
    }
}

