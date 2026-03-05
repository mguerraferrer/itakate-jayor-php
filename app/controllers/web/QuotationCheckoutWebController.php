<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * QuotationWebController
 * Controller for handling quotation requests
 */
class QuotationCheckoutWebController {

    private QuotationCheckoutWebService $quotationCheckoutWebService;
    private ProductWebService $productWebService;
    private QuotationSession $quotationSession;
    private MailWebService $mailWebService;

    public function __construct() {
        $this->quotationCheckoutWebService = new QuotationCheckoutWebService();
        $this->productWebService = new ProductWebService();
        $this->quotationSession = new QuotationSession();
        $this->mailWebService = new MailWebService();
    }

    /**
     * Add product to quotation (AJAX endpoint)
     * 
     * @param int $productId Product ID to add
     * @return array JSON response
     */
    public function checkout(array $products, array $data): array {
        try {
            // Validate that all products have quantity > 0
            if (empty($products)) {
                return Response::error('No se han agregado productos a la cotización');
            }

            foreach ($products as $product) {
                if (!isset($product['quantity']) || $product['quantity'] <= 0) {
                    return Response::error('Todos los productos deben tener una cantidad mayor a 0');
                }
            }

            // Get full product information from session
            $quotationItems = $this->quotationSession->getItemsMapped();
            if (empty($quotationItems)) {
                return Response::error('No hay productos en la sesión de cotización');
            }

            // Build array of QuotationItemInfo with updated quantities
            $itemsToSave = [];
            foreach ($products as $productData) {
                $productId = (int)$productData['id'];
                $quantity = (int)$productData['quantity'];

                // Find the item in session
                foreach ($quotationItems as $sessionItem) {
                    $itemData = $sessionItem instanceof QuotationItemInfo ? $sessionItem->toArray() : $sessionItem;
                    if (!empty($itemData['item'])) {
                        if ($itemData['id'] === $productId) {
                            $quotationItemInfo = new QuotationItemInfo();
                            $quotationItemInfo->setId($productId);
                            $quotationItemInfo->setQuantity($quantity);

                            $item = $sessionItem['item'];
                            $quotationItem = QuotationItem::fromProduct($item);
                            $quotationItemInfo->setItem($quotationItem);

                            $itemsToSave[] = $quotationItemInfo;
                            break;
                        }
                    }
                }
            }

            if (empty($itemsToSave)) {
                return Response::error('No se pudieron procesar los productos de la cotización');
            }

            // Validate form fields
            $rules = $this->getValidationRules();
            $validation = Validator::validateFields($data, $rules);
            if (!$validation['success']) {
                return $validation;
            }

            // Prepare clean data with next folio
            $nextFolio = $this->quotationCheckoutWebService->getNextFolio();
            $cleanData = [
                'folio' => $nextFolio,
                'name' => trim($data['name']),
                'business_name' => trim($data['businessName']),
                'rfc' => trim($data['rfc']),
                'email' => trim($data['email']),
                'phone' => trim($data['phone']),
                'cell' => trim($data['cell']),
                'product_use' => self::getProductUse(trim($data['use'])),
                'street' => trim($data['street']),
                'outside_number' => trim($data['outsideNumber']),
                'inside_number' => trim($data['insideNumber']),
                'colony' => trim($data['colony']),
                'state' => trim($data['state']),
                'country' => trim($data['country']),
                'zip_code' => trim($data['zipcode']),
                'comments' => trim($data['comments'])
            ];

            // Save quotation and items to database
            $quotationId = $this->quotationCheckoutWebService->saveQuotation($cleanData, $itemsToSave);
            if ($quotationId) {
                // Send email notification
                $sent = $this->mailWebService->sendQuotation($itemsToSave, $cleanData);
                // Clear quotation session
                $this->quotationSession->clear();

                $registeredFolio = ['folio' => $nextFolio];
                $responseMessage = $sent['success']
                    ? 'Gracias por tu solicitud. En breve te daremos respuesta'
                    : 'La cotización se registró correctamente. Te contactaremos pronto';
                return Response::success($responseMessage, $registeredFolio);
            }

            return Response::error('Ha ocurrido un error inesperado procesando tu solicitud. Por favor, intenta más tarde');
        } catch (Exception $e) {
            return Response::error('Error inesperado al enviar la cotización: ' . $e->getMessage());
        }
    }

    /**
     * Validation rules for checkout form
     *
     * @return array Validation rules
     */
    private function getValidationRules(): array {
        return [
            'name' => ['required' => true],
            'businessName' => ['required' => true],
            'rfc' => ['required' => true],
            'email' => ['required' => true, 'type' => 'email'],
            'cell' => ['required' => true, 'length' => 10],
            'use' => [
                'required' => true,
                'enum' => ['values' => ['endUse', 'saleUse'], 'frontEndField' => 'Uso del producto']
            ],
            'street' => ['required' => true],
            'zipcode' => ['required' => true, 'length' => 5, 'type' => 'number'],
            'colony' => ['required' => true],
            'state' => ['required' => true],
            'country' => ['required' => true]
        ];
    }

    /**
     * Get gender description from code
     *
     * @param string $gender Gender code
     * @return string Gender description
     */
    private static function getProductUse(string $use): string {
        return match ($use) {
            'endUse' => 'Para uso final',
            'saleUse' => 'Para distribuidor'
        };
    }
}
