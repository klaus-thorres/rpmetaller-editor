<?php


namespace ruhrpottmetaller\Products\Band;


use ruhrpottmetaller\Products\IProduct;

class Product implements IProduct
{
    private int $id;
    private string $name;
    private bool $visible;

    public function __clone(): void
    {
    }

    public function setInitialData(array $product_data): void
    {
        $this->id = $product_data['id'];
        $this->name = $product_data['name'];
        $this->visible = $product_data['visible'];
    }

    public function prepareData(): void
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVisibilityStatus(): bool
    {
        return $this->visible;
    }
}
