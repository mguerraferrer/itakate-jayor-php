<?php

/**
 * QuotationItem class
 * Simplified product information for quotation items
 * Contains only essential product data needed for quotations
 */
class QuotationItem {
    // Brand information    
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

    /**
     * Map from product array to QuotationItem
     * 
     * @param array $product Product data array
     * @return QuotationItem Quotation item
     */
    public static function fromProduct(array $product): QuotationItem {
        $item = new QuotationItem();
        
        $item->setBrandName($product['brand_name'] ?? $product['brandName'] ?? null);
        $item->setId($product['id'] ?? null);
        $item->setSku($product['sku'] ?? null);
        $item->setCode($product['code'] ?? null);
        $item->setProductGroup($product['product_group'] ?? $product['productGroup'] ?? null);
        $item->setCbKey($product['cb_key'] ?? $product['cbKey'] ?? null);
        $item->setSalesFactor($product['sales_factor'] ?? $product['salesFactor'] ?? null);
        $item->setHealthRegister($product['health_register'] ?? $product['healthRegister'] ?? null);
        $item->setImg($product['img'] ?? null);
        $item->setColor($product['color'] ?? null);
        $item->setPresentation($product['presentation'] ?? null);
        $item->setCapacity($product['capacity'] ?? null);
        $item->setCaliber($product['caliber'] ?? null);
        $item->setMeasure($product['measure'] ?? null);
        $item->setSize($product['size'] ?? null);
        $item->setLength($product['length'] ?? null);
        $item->setVolume($product['volume'] ?? null);
        $item->setNeedle($product['needle'] ?? null);
        $item->setBagDimensions($product['bag_dimensions'] ?? $product['bagDimensions'] ?? null);
        $item->setNeckDimensions($product['neck_dimensions'] ?? $product['neckDimensions'] ?? null);
        $item->setGuideDiameter($product['guide_diameter'] ?? $product['guideDiameter'] ?? null);
        $item->setWeight($product['weight'] ?? null);
        
        return $item;
    }

    // Getters and Setters
    public function getBrandName(): ?string {
        return $this->brandName;
    }

    public function setBrandName(?string $brandName): void {
        $this->brandName = $brandName;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getSku(): ?string {
        return $this->sku;
    }

    public function setSku(?string $sku): void {
        $this->sku = $sku;
    }

    public function getCode(): ?string {
        return $this->code;
    }

    public function setCode(?string $code): void {
        $this->code = $code;
    }

    public function getProductGroup(): ?string {
        return $this->productGroup;
    }

    public function setProductGroup(?string $productGroup): void {
        $this->productGroup = $productGroup;
    }

    public function getCbKey(): ?string {
        return $this->cbKey;
    }

    public function setCbKey(?string $cbKey): void {
        $this->cbKey = $cbKey;
    }

    public function getSalesFactor(): ?string {
        return $this->salesFactor;
    }

    public function setSalesFactor(?string $salesFactor): void {
        $this->salesFactor = $salesFactor;
    }

    public function getHealthRegister(): ?string {
        return $this->healthRegister;
    }

    public function setHealthRegister(?string $healthRegister): void {
        $this->healthRegister = $healthRegister;
    }

    public function getImg(): ?string {
        return $this->img;
    }

    public function setImg(?string $img): void {
        $this->img = $img;
    }

    public function getColor(): ?string {
        return $this->color;
    }

    public function setColor(?string $color): void {
        $this->color = $color;
    }

    public function getPresentation(): ?string {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): void {
        $this->presentation = $presentation;
    }

    public function getCapacity(): ?string {
        return $this->capacity;
    }

    public function setCapacity(?string $capacity): void {
        $this->capacity = $capacity;
    }

    public function getCaliber(): ?string {
        return $this->caliber;
    }

    public function setCaliber(?string $caliber): void {
        $this->caliber = $caliber;
    }

    public function getMeasure(): ?string {
        return $this->measure;
    }

    public function setMeasure(?string $measure): void {
        $this->measure = $measure;
    }

    public function getSize(): ?string {
        return $this->size;
    }

    public function setSize(?string $size): void {
        $this->size = $size;
    }

    public function getLength(): ?string {
        return $this->length;
    }

    public function setLength(?string $length): void {
        $this->length = $length;
    }

    public function getVolume(): ?string {
        return $this->volume;
    }

    public function setVolume(?string $volume): void {
        $this->volume = $volume;
    }

    public function getNeedle(): ?string {
        return $this->needle;
    }

    public function setNeedle(?string $needle): void {
        $this->needle = $needle;
    }

    public function getBagDimensions(): ?string {
        return $this->bagDimensions;
    }

    public function setBagDimensions(?string $bagDimensions): void {
        $this->bagDimensions = $bagDimensions;
    }

    public function getNeckDimensions(): ?string {
        return $this->neckDimensions;
    }

    public function setNeckDimensions(?string $neckDimensions): void {
        $this->neckDimensions = $neckDimensions;
    }

    public function getGuideDiameter(): ?string {
        return $this->guideDiameter;
    }

    public function setGuideDiameter(?string $guideDiameter): void {
        $this->guideDiameter = $guideDiameter;
    }

    public function getWeight(): ?string {
        return $this->weight;
    }

    public function setWeight(?string $weight): void {
        $this->weight = $weight;
    }

    /**
     * Convert to array
     * 
     * @return array
     */
    public function toArray(): array {
        return [
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
            'weight' => $this->weight
        ];
    }
}
