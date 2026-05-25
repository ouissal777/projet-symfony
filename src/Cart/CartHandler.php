<?php
namespace App\Cart;

use App\DTO\CartItem;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class CartHandler
{
    public function __construct(
        #[Autowire(service: SessionCart::class)]
        private readonly CartInterface $cart,
    ) {}
    public function addToCart(CartItem $item): void{
        $this->cart->add($item);
    }

    public function removeFromCart(int $productId): void {
        $this->cart->remove($productId);
    }

    public function getCartItems(): array{
        return $this->cart->getItems();
    }

    public function getTotal(): float{
        return $this->cart->getTotal();
    }
    public function clearCart(): void{
        $this->cart->clear();
    }
}