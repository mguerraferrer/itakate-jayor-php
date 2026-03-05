<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * QuotationCheckoutWebService
 * Service for managing quotations
 */
class QuotationCheckoutWebService extends BaseDAO {

    use QueryTrait;
    private QuotationItemWebService $quotationItemWebService;

    public function __construct() {
        parent::__construct();
        $this->quotationItemWebService = new QuotationItemWebService();
        $this->table = 'quotations';
    }

    /**
     * Get the next folio number
     * 
     * @return string Next folio number (e.g., "001", "002", etc.)
     */
    public function getNextFolio(): string {
        $queryData = $this->createQueryData(
            columns: 'folio',
            orderBy: 'folio DESC',
            limit: 1,
        );
        $result = parent::findOne($queryData);

        if ($result && !empty($result['folio'])) {
            $lastFolio = $result['folio'];
            $nextFolioNumber = intval($lastFolio) + 1;
            return str_pad($nextFolioNumber, 3, '0', STR_PAD_LEFT);
        }
        return '001';
    }

    public function getQuotationCreationDate($folio): ?array {
        $queryData = $this->createQueryData(
            columns: 'creation_date',
            conditions: ['folio' => $folio]
        );
        return parent::findOne($queryData);
    }

    /**
     * Create a new quotation
     * 
     * @param array $quotationData Quotation form data
     * @return int|null The ID of the created quotation or null on failure
     */
    public function saveQuotation(array $quotationData, array $items): ?int {
        $quotationId = parent::insert($quotationData);
        $this->quotationItemWebService->saveQuotationItems($quotationId, $items);
        return $quotationId;
    }

}