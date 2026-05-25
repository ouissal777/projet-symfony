<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route("/product/{id}", name: "app_product_details")]
    public function details(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);
        
        if (!$product) {
            throw $this->createNotFoundException("Product not found");
        }
        
        return $this->render("product/details.html.twig", [
            "product" => $product,
            "product_id" => $id
        ]);
    }

    #[Route('/', name: 'product_list')]
    public function list(ProductRepository $productRepository): Response{
    return $this->render('product/list.html.twig', [
        'products' => $productRepository->findAll(),
    ]);
    }
}
