<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * QuotationCheckoutWebService
 * Service for managing quotations
 */
class QuotationItemWebService extends BaseDAO {

    use QueryTrait;
    private DashboardQuotationItemService $dashboardQuotationItemService;

    public function __construct() {
        parent::__construct();
        $this->dashboardQuotationItemService = new DashboardQuotationItemService();
        $this->table = 'quotation_items';
    }

    /**
     * Save quotation items
     *
     * @param int $quotationId Quotation ID
     * @param array $items Array of QuotationItemInfo objects
     * @return void
     */
    public function saveQuotationItems(int $quotationId, array $items): void {
        $itemIds = [];
        foreach ($items as $item) {
            if ($item instanceof QuotationItemInfo) {
                $quotationItemData = [
                    'quotation_id' => $quotationId,
                    'product_id' => $item->getId(),
                    'quantity' => $item->getQuantity()
                ];
                parent::insert($quotationItemData);
                $itemIds[] = $item->getId();
            }
        }
        // Save quotations items to the dashboard
        $this->dashboardQuotationItemService->saveQuotationItems($itemIds);
    }

}