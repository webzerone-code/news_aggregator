<?php

namespace App\__OOThroughProcess\Chapter05\Product;

// Class
class Product {
    public function __construct(
        private ShippingServiceInterface $shipping,
        private TaxServiceInterface $tax,
        private float $price
    ) {}

    public function ship(): void {
        $this->shipping->ship($this);
    }

    public function calculateTax(): float {
        return $this->tax->calculate($this->price);
    }
}
// Interface
class ProductService {
    public function __construct(
        private ShippingServiceInterface $shipping,
        private TaxServiceInterface $tax
    ) {}

    public function createProduct(float $price): ProductInterface {
        return new Product($this->shipping, $this->tax, $price);
    }

    public function shipProduct(ProductInterface $product): void {
        $product->ship();
    }
}
// Client or User
$productService = new ProductService(new FedExShippingService(), new DefaultTaxService());
$product = $productService->createProduct(100);
$productService->shipProduct($product);
/*
 * and u forgot 2 things 1 is the product is good to implement interface so its easy to switch and the user need di
 */
