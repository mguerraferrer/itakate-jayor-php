<?php

/**
 * QuotationItemInfo class
 * Represents a quotation item with product and quantity
 */
class QuotationItemInfo {
    private ?int $id = null; // Product ID
    private ?QuotationItem $item = null; // Quotation item (simplified product)
    private int $quantity = 0;

    // Getters and Setters
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getItem(): ?QuotationItem {
        return $this->item;
    }

    public function setItem(?QuotationItem $item): void {
        $this->item = $item;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void {
        $this->quantity = $quantity;
    }

    /**
     * Convert to array for serialization
     * 
     * @return array
     */
    public function toArray(): array {
        return [
            'id' => $this->id,
            'item' => $this->item?->toArray(),
            'quantity' => $this->quantity
        ];
    }

    /**
     * Create from array (for session deserialization)
     * 
     * @param array $data
     * @return QuotationItemInfo
     */
    public static function fromArray(array $data): QuotationItemInfo {
        $itemInfo = new QuotationItemInfo();
        $itemInfo->setId($data['id'] ?? null);
        $itemInfo->setQuantity($data['quantity'] ?? 0);
        
        // Reconstruct QuotationItem if data exists
        if (!empty($data['item'])) {
            $item = new QuotationItem();
            foreach ($data['item'] as $key => $value) {
                $setter = 'set' . ucfirst($key);
                if (method_exists($item, $setter)) {
                    $item->$setter($value);
                }
            }
            $itemInfo->setItem($item);
        }
        
        return $itemInfo;
    }
}
