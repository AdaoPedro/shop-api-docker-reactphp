<?php
    declare(strict_types=1);

    namespace App\Products;

    final class Product {

        public const TABLE = "products";

        public function __construct(
            private int $id, private string $name, private float $price, private int $categoryId
        ) {}

        public function getId(): int { return $this->id; }
        public function getName(): string { return $this->name; }
        public function getPrice(): float { return $this->price; }
        public function getCategoryId(): int { return $this->categoryId; }

    }