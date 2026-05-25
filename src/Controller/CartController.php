<?php
namespace App\Controller;

use App\Cart\CartHandler;
use App\DTO\CartItem;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    public function __construct(private readonly CartHandler $cartHandler) {}

    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function add(int $id, Request $request, ProductRepository $repo): Response{
        $product = $repo->find($id);

        if (!$product) {
            throw $this->createNotFoundException();
        }

        $quantity = max(1, (int) $request->request->get('quantity', 1));

        $item = new CartItem(
            productId: $product->getId(),
            name: $product->getName(),
            price: $product->getPrice(),
            quantity: $quantity,
        );

        $this->cartHandler->addToCart($item);

        $this->addFlash('success', 'Produit ajouté au panier.');

        return $this->redirectToRoute('cart_show');
    }

    #[Route('/cart', name: 'cart_show')]
    public function show(): Response{
        return $this->render('cart/show.html.twig', [
            'items' => $this->cartHandler->getCartItems(),
            'total' => $this->cartHandler->getTotal(),
        ]);
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(int $id): Response{
        $this->cartHandler->removeFromCart($id);
        return $this->redirectToRoute('cart_show');
    }
}