<?php
require_once __DIR__ . '/../../../autoload.php';

class DashboardQuotationItemService extends BaseDAO {

    use QueryTrait;

    public function __construct() {
        parent::__construct();
        $this->table = 'dashboard_quotation_items';
    }

    const TABLE_ALIAS = 'dqi';

    /**
     * Save quotation items to the dashboard
     * 
     * @param array $itemIds List of quotation item IDs
     * @return void
     */
    public function saveQuotationItems(array $itemIds): void {        
        $now = DateTimeUtil::now();
        foreach ($itemIds as $itemId) {
            $clearData = [
                'quotation_item_id' => $itemId,
                'month' => $now->format('m'),
                'date' => $now->format('Y-m-d'),
                'year' => $now->format('Y'),
                'time' => $now->format('H:i:s')
            ];
            parent::insert($clearData);            
        }
    }

    /**
    * Get quotation items by date range
    *
    * @param string $startDate Start date (Y-m-d)
    * @param string $endDate End date (Y-m-d)
    * @return array List of quotation items
    */
    public function getQuotationItemsByDateRange(string $startDate = '', string $endDate = ''): array {
        $columns = 'dqi.date, p.sku, p.code, q.folio, qi.quantity';
        return $this->getQuotationItemData($columns, $startDate, $endDate);
    }

    /**
     * Get quotation item data for report with specified columns and date range
     * 
     * @param string $startDate Start date (Y-m-d)
     * @param string $endDate End date (Y-m-d)
     * @return array List of quotation items with detailed data for report
     */
    public function getQuotationItemsReportData(string $startDate = '', string $endDate = ''): array {
        $columns = '
            dqi.date, 
            q.folio,
            p.sku,
            p.code,
            p.cb_key,
            p.sales_factor,
            p.health_register,
            p.color,
            p.presentation,
            p.capacity,
            p.caliber,
            p.measure,
            p.size,
            p.length,
            p.volume,
            p.needle,
            p.bag_dimensions,
            p.neck_dimensions,
            p.guide_diameter,
            p.weight,
            qi.quantity
        ';
        return $this->getQuotationItemData($columns, $startDate, $endDate);
    }

    /**
     * Get quotation item data with specified columns and date range
     * 
     * @param string $columns Columns to select
     * @param string $startDate Start date (Y-m-d)
     * @param string $endDate End date (Y-m-d)
     * @return array List of quotation items with specified columns
     */
    private function getQuotationItemData(string $columns, string $startDate = '', string $endDate = ''): array {
        $joins = [
            'INNER JOIN quotation_items qi ON dqi.quotation_item_id = qi.id',
            'INNER JOIN quotations q ON qi.quotation_id = q.id',
            'INNER JOIN product p ON qi.product_id = p.id',
        ];

        $conditions = [];
        if ($startDate && $endDate) {
            $startDate = DateTimeUtil::formatDate($startDate, 'Y-m-d');
            $endDate = DateTimeUtil::formatDate($endDate, 'Y-m-d');            
            $conditions['dqi.date BETWEEN'] = [$startDate, $endDate];
        } else {
            $conditions['dqi.month'] = DateTimeUtil::now()->format('m');
            $conditions['dqi.year'] = DateTimeUtil::now()->format('Y');
        }        

        $queryData = $this->createQueryData(
            tableAlias: self::TABLE_ALIAS,
            columns: $columns,
            joins: $joins,
            conditions: $conditions,
            orderBy: 'dqi.date DESC, dqi.time DESC'
        );
        return parent::findAll($queryData);
    }

}