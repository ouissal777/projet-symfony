<?php

namespace App\Cart;

use App\DTO\CartItem;

interface CartInterface
{
    public function add(CartItem $item): void;

    public function remove(int $productId): void;

    public function getItems(): array;

    public function clear(): void;

    public function getTotal(): float;
}