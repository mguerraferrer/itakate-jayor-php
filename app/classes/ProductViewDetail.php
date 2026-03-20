<?php

require_once __DIR__ . '/ProductInfo.php';

/**
 * ProductViewDetail class
 * Represents a product view detail with product information and metadata
 * Equivalent to Java ProductViewDetail
 */
class ProductViewDetail {
    private string $sku;
    private string $img;
    private bool $topTen;
    private ?int $topTenOrder;
    private bool $outlet;
    private bool $inStock;
    private array $products; // Array of ProductInfo objects

    /**
     * Constructor
     *
     * @param array $products List of ProductInfo objects or arrays
     */
    public function __construct(array $products) {
        if (empty($products)) {
            throw new InvalidArgumentException("Products list cannot be empty");
        }

        // Get first product to extract metadata
        $firstProduct = reset($products);
        
        // If first product is ProductInfo object, extract from it
        if ($firstProduct instanceof ProductInfo) {
            $this->sku = $firstProduct->getSku() ?? '';
            $this->img = $firstProduct->getImg() ?? '';
            $this->topTen = $firstProduct->isTopTen();
            $this->topTenOrder = $firstProduct->getTopTenOrder();
            $this->outlet = $firstProduct->isOutlet();
            $this->inStock = $firstProduct->isInStock();
        } else {
            // Fallback for arrays (backwards compatibility)
            $this->sku = $firstProduct['sku'] ?? '';
            $this->img = $firstProduct['img'] ?? '';
            $this->topTen = (bool)($firstProduct['top_ten'] ?? false);
            $this->topTenOrder = $firstProduct['top_ten_order'] ?? null;
            $this->outlet = (bool)($firstProduct['outlet'] ?? false);
            $this->inStock = (bool)($firstProduct['in_stock'] ?? false);
        }
        
        $this->products = $products;
    }

    /**
     * Get SKU
     */
    public function getSku(): string {
        return $this->sku;
    }

    /**
     * Get image
     */
    public function getImg(): string {
        return $this->img;
    }

    /**
     * Get top ten value
     */
    public function getTopTen(): bool {
        return $this->topTen;
    }

    /**
     * Get top ten order value
     */
    public function getTopTenOrder(): ?int {
        return $this->topTenOrder;
    }

    /**
     * Check if is outlet
     */
    public function isOutlet(): bool {
        return $this->outlet;
    }

    public function isInStock(): bool {
        return $this->inStock;
    }

    /**
     * Get products list
     */
    public function getProducts(): array {
        return $this->products;
    }

    /**
     * Convert to array
     */
    public function toArray(): array {
        // Convert ProductInfo objects to arrays if needed
        $productsArray = array_map(function($product) {
            if ($product instanceof ProductInfo) {
                return $product->toArray();
            }
            return $product;
        }, $this->products);
        
        return [
            'sku' => $this->sku,
            'img' => $this->img,
            'topTen' => $this->topTen,
            'topTenOrder' => $this->topTenOrder,
            'outlet' => $this->outlet,
            'in_stock' => $this->inStock,
            'products' => $productsArray
        ];
    }
}
