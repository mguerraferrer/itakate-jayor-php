<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * QuotationWebController
 * Controller for handling quotation requests
 */
class QuotationWebController {

    private ProductWebService $productWebService;
    private QuotationSession $quotationSession;

    public function __construct() {
        $this->productWebService = new ProductWebService();
        $this->quotationSession = new QuotationSession();
    }

    /**
     * Display quotation page
     * 
     * @return array View data or redirect info
     */
    public function showQuotation(): array {
        if ($this->quotationSession->isEmpty()) {
            return [
                'redirect' => 'products'
            ];
        }

        return [
            'data' => [
                'quotation' => [
                    'items' => $this->quotationSession->getItemsMapped()
                ]
            ]
        ];
    }

    public function getQuotation(): array {
        $items = $this->quotationSession->getItemsMapped();
        return Response::listSource($items);
    }

    /**
     * Add product to quotation (AJAX endpoint)
     * 
     * @param int $productId Product ID to add
     * @return array JSON response
     */
    public function addToQuotation(int $productId): array {
        try {
            // Find product by ID
            $product = $this->productWebService->getProductById($productId);
            if ($product === null) {
                return Response::notFound('Producto no encontrado');
            }

            // Add to QuotationSession
            $this->quotationSession->addItem($product, 1);

            $items = $this->quotationSession->getItemsMapped();
            return Response::listSource($items);
        } catch (Exception $e) {
            return Response::error('Error al agregar el producto al cotizador: ' . $e->getMessage());
        }
    }

    /**
     * Remove product from quotation (AJAX endpoint)
     * 
     * @param int $productId Product ID to remove
     * @return array JSON response
     */
    public function removeFromQuotation(int $productId): array {
        try {
            $this->quotationSession->removeItem($productId);
            $items = $this->quotationSession->getItemsMapped();
            return Response::listSource($items);
        } catch (Exception $e) {
            return Response::error('Error al eliminar el producto del cotizador: ' . $e->getMessage());
        }
    }

}