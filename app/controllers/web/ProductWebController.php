<?php
require_once __DIR__ . '/../../../autoload.php';

class ProductWebController {

    private ProductWebService $productWebService;
    private LineWebService $lineWebService;
    private BrandWebService $brandWebService;

    public function __construct() {
        $this->productWebService = new ProductWebService();
        $this->lineWebService = new LineWebService();
        $this->brandWebService = new BrandWebService();
    }

    const LINE_CODE_DEFAULT = 'adh';

    /**
     * Get all active vacancies
     *
     * @return array Array of active vacancies
     */
    public function getOutletProducts(): array {
        try {
            return $this->productWebService->getOutletProducts() ?? [];
        } catch (Exception $e) {
            error_log("ProductWebController::getOutletProducts - Exception: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Load products by line or brand
     *
     * @param string|null $lineCode Line code parameter
     * @param string|null $brandCode Brand code parameter
     * @return array Array containing lines, brands, products, loadedBy, lineActive, and brandActive
     */
    public function loadProducts(?string $lineCode, ?string $brandCode): array {
        try {
            if (empty($lineCode) && empty($brandCode)) {
                $lineCode = self::LINE_CODE_DEFAULT;
            } elseif (!empty($lineCode) && !empty($brandCode)) {
                $brandCode = null;
            }

            // Load products based on brand or line
            $lineActive = null;
            $brandActive = null;

            if (!empty($brandCode)) {
                $products = $this->productWebService->getProductsByBrand($brandCode) ?? [];
                $brandActive = $brandCode;
                $loadedBy = 'b';
            } else {
                $products = $this->productWebService->getProductsByLine($lineCode) ?? [];
                $lineActive = $lineCode;
                $loadedBy = 'l';
            }

            // Load lines and brands
            $lines = $this->lineWebService->getLines() ?? [];
            $brands = $this->brandWebService->getBrands() ?? [];

            // Return all data
            return [
                'lines' => $lines,
                'brands' => $brands,
                'products' => $products,
                'loadedBy' => $loadedBy,
                'lineActive' => $lineActive,
                'brandActive' => $brandActive
            ];
        } catch (Exception $e) {
            error_log("ProductWebController::loadProducts - Exception: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Load product details by product group
     * Validates parameters and returns product view detail
     *
     * @param string $productGroup The product group to load
     * @param string|null $loadedBy How the product was loaded (l=line, default)
     * @param string|null $code The code parameter
     * @return ?array Product view detail or null
     */
    public function loadByProductGroup(string $productGroup, ?string $loadedBy, ?string $code): ?array {
        try {
            if (empty(trim($productGroup))) {
                return null;
            }

            if (empty(trim($loadedBy))) {
                $loadedBy = 'l';
            }

            if (empty(trim($code))) {
                $code = self::LINE_CODE_DEFAULT;
            }

            $productDetail = $this->productWebService->getProductsByGroup($productGroup);
            if ($productDetail === null) {
                return null;
            }

            // Return as array with additional parameters
            $result = $productDetail->toArray();
            $result['loadedBy'] = $loadedBy;
            $result['code'] = $code;

            return $result;
        } catch (Exception $e) {
            error_log("ProductWebController::loadByProductGroup - Exception: " . $e->getMessage());
            return null;
        }
    }

}