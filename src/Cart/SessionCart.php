<?php
namespace App\Cart;

use App\DTO\CartItem;
use Symfony\Component\HttpFoundation\RequestStack;

class SessionCart implements CartInterface
{
    private const SESSION_KEY = 'cart';
    public function __construct(private readonly RequestStack $requestStack) 
    {}
    private function getSession(): \Symfony\Component\HttpFoundation\Session\SessionInterface
    {
        return $this->requestStack->getSession();
    }
    public function add(CartItem $item): void{
        $items = $this->getItems();
        // Si le produit existant on incrémente la quantité
        if (isset($items[$item->productId])) {
            $items[$item->productId]->quantity += $item->quantity;
        } else {
            $items[$item->productId] = $item;
        }
        $this->getSession()->set(self::SESSION_KEY, $items);
    }

    public function remove(int $productId): void{
        $items = $this->getItems();
        unset($items[$productId]);
        $this->getSession()->set(self::SESSION_KEY, $items);
    }

    public function getItems(): array{
        return $this->getSession()->get(self::SESSION_KEY, []);
    }
    public function clear(): void{
        $this->getSession()->remove(self::SESSION_KEY);
    }
    public function getTotal(): float {
        return array_reduce(
            $this->getItems(),
            fn(float $carry, CartItem $item) => $carry + ($item->price * $item->quantity),
            0.0
        );
    }
}