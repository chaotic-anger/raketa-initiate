<?php

declare(strict_types=1);


namespace Raketa\BackendTestTask\View\DTO;


class ProductDto
{
    public int $id;
    public string $uuid;
    public string $name;
    public string $thumbnail;
    public float $price;
    public string $description;
    public string $category;
}