<?php

/**
 * ProductInfo class
 * Represents detailed product information with all attributes
 * Equivalent to Java ProductInfo DTO
 */
class ProductInfo {
    // Line information
    private ?int $lineId = null;
    private ?string $lineCode = null;
    private ?string $lineName = null;
    
    // Brand information
    private ?int $brandId = null;
    private ?string $brandCode = null;
    private ?string $brandName = null;
    
    // Product basic info
    private ?int $id = null;
    private ?string $sku = null;
    private ?string $code = null;
    private ?string $productGroup = null;
    private ?string $cbKey = null;
    private ?string $salesFactor = null;
    private ?string $healthRegister = null;
    private ?string $img = null;
    
    // Product specifications
    private ?string $color = null;
    private ?string $presentation = null;
    private ?string $capacity = null;
    private ?string $caliber = null;
    private ?string $measure = null;
    private ?string $size = null;
    private ?string $length = null;
    private ?string $volume = null;
    private ?string $needle = null;
    private ?string $bagDimensions = null;
    private ?string $neckDimensions = null;
    private ?string $guideDiameter = null;
    private ?string $weight = null;
    
    // Product flags
    private bool $topTen = false;
    private ?int $topTenOrder = null;
    private bool $outlet = false;
    private bool $inStock = true;
    
    // Computed details
    private ?string $details = null;

    /**
     * Map from database array to ProductInfo object
     * 
     * @param array $product Product data from database
     * @return ProductInfo
     */
    public static function map(array $product): ProductInfo {
        $dto = new ProductInfo();
        
        // Line information
        $dto->setLineId($product['line_id'] ?? null);
        $dto->setLineCode($product['line_code'] ?? null);
        $dto->setLineName($product['line_name'] ?? null);
        
        // Brand information
        $dto->setBrandId($product['brand_id'] ?? null);
        $dto->setBrandCode($product['brand_code'] ?? null);
        $dto->setBrandName($product['brand_name'] ?? null);
        
        // Product basic info
        $dto->setId($product['id'] ?? null);
        $dto->setSku($product['sku'] ?? null);
        $dto->setCode($product['code'] ?? null);
        $dto->setProductGroup(isset($product['product_group']) ? strtolower($product['product_group']) : null);
        $dto->setCbKey($product['cb_key'] ?? null);
        $dto->setSalesFactor($product['sales_factor'] ?? null);
        $dto->setHealthRegister($product['health_register'] ?? null);
        $dto->setImg($product['img'] ?? null);
        
        // Product specifications
        $dto->setColor($product['color'] ?? null);
        $dto->setPresentation($product['presentation'] ?? null);
        $dto->setCapacity($product['capacity'] ?? null);
        $dto->setCaliber($product['caliber'] ?? null);
        $dto->setMeasure($product['measure'] ?? null);
        $dto->setSize($product['size'] ?? null);
        $dto->setLength($product['length'] ?? null);
        $dto->setVolume($product['volume'] ?? null);
        $dto->setNeedle($product['needle'] ?? null);
        $dto->setBagDimensions($product['bag_dimensions'] ?? null);
        $dto->setNeckDimensions($product['neck_dimensions'] ?? null);
        $dto->setGuideDiameter($product['guide_diameter'] ?? null);
        $dto->setWeight($product['weight'] ?? null);
        
        // Product flags
        $dto->setTopTen(!empty($product['top_ten']));
        $dto->setTopTenOrder($product['top_ten_order'] ?? null);
        $dto->setOutlet(!empty($product['outlet']));
        $dto->setInStock(!empty($product['in_stock']));

        // Build product details string
        $dto->setDetails(self::productDetails($product));
        
        return $dto;
    }

    /**
     * Build product details string from product data
     * 
     * @param array $product Product data
     * @return string Product details string
     */
    private static function productDetails(array $product): string {
        $details = [];
        
        // By default, the product's brand is added
        $brandName = $product['brand_name'] ?? null;
        if (!empty($brandName)) {
            $details[] = $brandName;
        }
        
        // Get product details from database (assuming they are stored in a field or related table)
        // If product doesn't have specific details, only sales factor is added
        $hasProductDetails = !empty($product['product_details']) || !empty($product['has_details']);
        
        if (!$hasProductDetails) {
            // If no specific details, add sales factor
            $salesFactor = $product['sales_factor'] ?? null;
            if (!empty($salesFactor)) {
                $details[] = $salesFactor;
            }
        } else {
            // Map of detail codes to product fields
            $detailGetters = [
                'COD' => $product['code'] ?? null,
                'CLA' => $product['cb_key'] ?? null,
                'FVE' => $product['sales_factor'] ?? null,
                'RSA' => $product['health_register'] ?? null,
                'COL' => $product['color'] ?? null,
                'PRE' => $product['presentation'] ?? null,
                'CAP' => $product['capacity'] ?? null,
                'CAL' => $product['caliber'] ?? null,
                'MED' => $product['measure'] ?? null,
                'TAM' => $product['size'] ?? null,
                'LON' => $product['length'] ?? null,
                'VOL' => $product['volume'] ?? null,
                'AGU' => $product['needle'] ?? null,
                'DBO' => $product['bag_dimensions'] ?? null,
                'DCU' => $product['neck_dimensions'] ?? null,
                'DGU' => $product['guide_diameter'] ?? null,
                'PES' => $product['weight'] ?? null
            ];
            
            // If we have product_details from database, use those codes to determine order
            if (!empty($product['product_details']) && is_array($product['product_details'])) {
                foreach ($product['product_details'] as $detail) {
                    $code = $detail['code'] ?? null;
                    if (!empty($code) && isset($detailGetters[$code])) {
                        $value = $detailGetters[$code];
                        if (!empty($value)) {
                            $details[] = $value;
                        }
                    }
                }
            } else {
                // Fallback: Add each detail that has a value (old behavior)
                foreach ($detailGetters as $code => $value) {
                    if (!empty($value)) {
                        $details[] = $value;
                    }
                }
            }
        }
        
        return implode(' . ', $details);
    }

    /**
     * Convert to array
     * 
     * @return array
     */
    public function toArray(): array {
        return [
            'lineId' => $this->lineId,
            'lineCode' => $this->lineCode,
            'lineName' => $this->lineName,
            'brandId' => $this->brandId,
            'brandCode' => $this->brandCode,
            'brandName' => $this->brandName,
            'id' => $this->id,
            'sku' => $this->sku,
            'code' => $this->code,
            'productGroup' => $this->productGroup,
            'cbKey' => $this->cbKey,
            'salesFactor' => $this->salesFactor,
            'healthRegister' => $this->healthRegister,
            'img' => $this->img,
            'color' => $this->color,
            'presentation' => $this->presentation,
            'capacity' => $this->capacity,
            'caliber' => $this->caliber,
            'measure' => $this->measure,
            'size' => $this->size,
            'length' => $this->length,
            'volume' => $this->volume,
            'needle' => $this->needle,
            'bagDimensions' => $this->bagDimensions,
            'neckDimensions' => $this->neckDimensions,
            'guideDiameter' => $this->guideDiameter,
            'weight' => $this->weight,
            'topTen' => $this->topTen,
            'topTenOrder' => $this->topTenOrder,
            'outlet' => $this->outlet,
            'inStock' => $this->inStock,
            'details' => $this->details
        ];
    }

    // Getters and Setters
    public function getLineId(): ?int { return $this->lineId; }
    public function setLineId(?int $lineId): void { $this->lineId = $lineId; }
    
    public function getLineCode(): ?string { return $this->lineCode; }
    public function setLineCode(?string $lineCode): void { $this->lineCode = $lineCode; }
    
    public function getLineName(): ?string { return $this->lineName; }
    public function setLineName(?string $lineName): void { $this->lineName = $lineName; }
    
    public function getBrandId(): ?int { return $this->brandId; }
    public function setBrandId(?int $brandId): void { $this->brandId = $brandId; }
    
    public function getBrandCode(): ?string { return $this->brandCode; }
    public function setBrandCode(?string $brandCode): void { $this->brandCode = $brandCode; }
    
    public function getBrandName(): ?string { return $this->brandName; }
    public function setBrandName(?string $brandName): void { $this->brandName = $brandName; }
    
    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }
    
    public function getSku(): ?string { return $this->sku; }
    public function setSku(?string $sku): void { $this->sku = $sku; }
    
    public function getCode(): ?string { return $this->code; }
    public function setCode(?string $code): void { $this->code = $code; }
    
    public function getProductGroup(): ?string { return $this->productGroup; }
    public function setProductGroup(?string $productGroup): void { $this->productGroup = $productGroup; }
    
    public function getCbKey(): ?string { return $this->cbKey; }
    public function setCbKey(?string $cbKey): void { $this->cbKey = $cbKey; }
    
    public function getSalesFactor(): ?string { return $this->salesFactor; }
    public function setSalesFactor(?string $salesFactor): void { $this->salesFactor = $salesFactor; }
    
    public function getHealthRegister(): ?string { return $this->healthRegister; }
    public function setHealthRegister(?string $healthRegister): void { $this->healthRegister = $healthRegister; }
    
    public function getImg(): ?string { return $this->img; }
    public function setImg(?string $img): void { $this->img = $img; }
    
    public function getColor(): ?string { return $this->color; }
    public function setColor(?string $color): void { $this->color = $color; }
    
    public function getPresentation(): ?string { return $this->presentation; }
    public function setPresentation(?string $presentation): void { $this->presentation = $presentation; }
    
    public function getCapacity(): ?string { return $this->capacity; }
    public function setCapacity(?string $capacity): void { $this->capacity = $capacity; }
    
    public function getCaliber(): ?string { return $this->caliber; }
    public function setCaliber(?string $caliber): void { $this->caliber = $caliber; }
    
    public function getMeasure(): ?string { return $this->measure; }
    public function setMeasure(?string $measure): void { $this->measure = $measure; }
    
    public function getSize(): ?string { return $this->size; }
    public function setSize(?string $size): void { $this->size = $size; }
    
    public function getLength(): ?string { return $this->length; }
    public function setLength(?string $length): void { $this->length = $length; }
    
    public function getVolume(): ?string { return $this->volume; }
    public function setVolume(?string $volume): void { $this->volume = $volume; }
    
    public function getNeedle(): ?string { return $this->needle; }
    public function setNeedle(?string $needle): void { $this->needle = $needle; }
    
    public function getBagDimensions(): ?string { return $this->bagDimensions; }
    public function setBagDimensions(?string $bagDimensions): void { $this->bagDimensions = $bagDimensions; }
    
    public function getNeckDimensions(): ?string { return $this->neckDimensions; }
    public function setNeckDimensions(?string $neckDimensions): void { $this->neckDimensions = $neckDimensions; }
    
    public function getGuideDiameter(): ?string { return $this->guideDiameter; }
    public function setGuideDiameter(?string $guideDiameter): void { $this->guideDiameter = $guideDiameter; }
    
    public function getWeight(): ?string { return $this->weight; }
    public function setWeight(?string $weight): void { $this->weight = $weight; }
    
    public function isTopTen(): bool { return $this->topTen; }
    public function setTopTen(bool $topTen): void { $this->topTen = $topTen; }
    
    public function getTopTenOrder(): ?int { return $this->topTenOrder; }
    public function setTopTenOrder(?int $topTenOrder): void { $this->topTenOrder = $topTenOrder; }
    
    public function isOutlet(): bool { return $this->outlet; }
    public function setOutlet(bool $outlet): void { $this->outlet = $outlet; }

    public function isInStock(): bool { return $this->inStock; }
    public function setInStock(bool $inStock): void { $this->inStock = $inStock; }
    
    public function getDetails(): ?string { return $this->details; }
    public function setDetails(?string $details): void { $this->details = $details; }
}
