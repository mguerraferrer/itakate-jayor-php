<?php
require_once __DIR__ . '/../../../autoload.php';

class HomeWebController {

    private ProductWebService $productWebService;

    public function __construct() {
        $this->productWebService = new ProductWebService();
    }

    /**
     * Get all active vacancies
     *
     * @return array Array of active vacancies
     */
    public function getHomeProducts(): array {
        try {
            $product['topTen'] = $this->productWebService->getTopTenProducts() ?? [];
            $product['outlet'] = $this->productWebService->getOutletProducts() ?? [];
            return $product;
        } catch (Exception $e) {
            error_log("ProductWebService::getOutletProducts - Exception: " . $e->getMessage());
            return [];
        }
    }

}