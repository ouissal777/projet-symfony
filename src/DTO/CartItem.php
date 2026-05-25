<?php
namespace App\DTO;

class CartItem
{
    public function __construct(
        public readonly int $productId,
        public readonly string $name,
        public readonly float $price,
        public int $quantity = 1,
    ) {}

    public function getTotal(): float
    {
        return $this->price * $this->quantity;
    }
}