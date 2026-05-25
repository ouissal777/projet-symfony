<?php
namespace App\Cart;

use App\DTO\CartItem;

class ApiCart implements CartInterface
{
    public function add(CartItem $item): void{
        dd('ApiCart::add()', $item);
        }
    public function remove(int $productId): void{
        dd('ApiCart::remove()', $productId);
    }
    public function getItems(): array{
        dd('ApiCart::getItems()');
    }
    public function clear(): void{
        dd('ApiCart::clear()');
    }
    public function getTotal(): float{
        dd('ApiCart::getTotal()');
    }
}