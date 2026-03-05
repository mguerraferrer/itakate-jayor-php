<?php
require_once __DIR__ . '/QuotationItem.php';
require_once __DIR__ . '/QuotationItemInfo.php';

/**
 * QuotationSession class
 * Session-scoped manager for quotation items
 * Equivalent to Java's @SessionAttributes QuotationSession
 */
class QuotationSession {
    private const SESSION_KEY = 'quotationSession';

    /**
     * Start session if not already started
     */
    /*private function ensureSession(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }*/

    /**
     * Get all items from session
     * 
     * @return array Array of QuotationItemInfo objects
     */
    private function getItemsFromSession(): array {
        //$this->ensureSession();
        
        if (!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = [];
        }
        
        $items = [];
        foreach ($_SESSION[self::SESSION_KEY] as $itemData) {
            $items[] = QuotationItemInfo::fromArray($itemData);
        }
        
        return $items;
    }

    /**
     * Save items to session
     * 
     * @param array $items Array of QuotationItemInfo objects
     */
    private function saveItemsToSession(array $items): void {
        //$this->ensureSession();
        
        $serializedItems = [];
        foreach ($items as $item) {
            if ($item instanceof QuotationItemInfo) {
                $serializedItems[] = $item->toArray();
            }
        }
        
        $_SESSION[self::SESSION_KEY] = $serializedItems;
        session_write_close();
    }

    /**
     * Add product to quotation
     * 
     * @param array $product Product data array
     * @param int $quantity Quantity to add
     */
    public function addItem(array $product, int $quantity): void {
        $items = $this->getItemsFromSession();
        $itemsMap = [];
        
        // Convert to map for easier lookup
        foreach ($items as $item) {
            $itemsMap[$item->getId()] = $item;
        }
        
        $quotationItem = QuotationItem::fromProduct($product);
        $productId = $product['id'] ?? null;
        
        if ($productId && isset($itemsMap[$productId])) {
            // Update existing item
            $existingItem = $itemsMap[$productId];
            $existingItem->setQuantity($existingItem->getQuantity() + $quantity);
        } else {
            // Add new item
            $newItem = new QuotationItemInfo();
            $newItem->setId($productId);
            $newItem->setItem($quotationItem);
            $newItem->setQuantity($quantity);
            $itemsMap[$productId] = $newItem;
        }
        
        // Save back to session
        $this->saveItemsToSession(array_values($itemsMap));
    }

    /**
     * Remove item from quotation
     * 
     * @param int $productId Product ID to remove
     */
    public function removeItem(int $productId): void {
        $items = $this->getItemsFromSession();
        $itemsMap = [];
        
        foreach ($items as $item) {
            if ($item->getId() !== $productId) {
                $itemsMap[$item->getId()] = $item;
            }
        }
        
        $this->saveItemsToSession(array_values($itemsMap));
    }

    /**
     * Get all items
     * 
     * @return array Array of QuotationItemInfo objects
     */
    public function getItems(): array {
        return $this->getItemsFromSession();
    }

    public function getItemsMapped(): array {
        return array_map(function($item) {
            return $item->toArray();
        }, $this->getItems());
    }

    /**
     * Clear all items from quotation
     */
    public function clear(): void {
        //$this->ensureSession();
        $_SESSION[self::SESSION_KEY] = [];
        session_write_close();
    }

    /**
     * Check if quotation is empty
     * 
     * @return bool True if empty
     */
    public function isEmpty(): bool {
        return empty($this->getItemsFromSession());
    }

    /**
     * Get items count
     * 
     * @return int Number of items
     */
    public function getItemsCount(): int {
        return count($this->getItemsFromSession());
    }
}
