<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create categories with updated name
        $categories = [
            "Electronic" => "Gadgets, computers, and electronic devices",
            "Clothing" => "Fashionable clothes and accessories",
            "Books" => "Best-selling books and novels",
            "Sports" => "Sports equipment and gear",
            "Home" => "Furniture and home decor"
        ];
        
        foreach ($categories as $catName => $catDesc) {
            $category = new Category();
            $category->setName($catName);
            $category->setDescription($catDesc);
            $manager->persist($category);
            
            // Create 3-5 products for each category
            $productCount = rand(3, 5);
            for ($i = 1; $i <= $productCount; $i++) {
                $product = new Product();
                $product->setName($catName . " Product " . $i);
                $product->setDescription("This is an amazing " . $catName . " product. High quality and durable. Perfect for everyday use.");
                $product->setPrice(rand(10, 200) + 0.99);
                $product->setCategory($category);
                
                // Assign a random image
                $images = ["airbod.png", "item.png", "mouse.png", "thumbnail.png"];
                $product->setImage($images[array_rand($images)]);
                
                $manager->persist($product);
            }
        }
        
        $manager->flush();
        
        echo "Created " . count($categories) . " categories and multiple products!\n";
    }
}
