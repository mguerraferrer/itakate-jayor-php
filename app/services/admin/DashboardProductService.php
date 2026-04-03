<?php
require_once __DIR__ . '/../../../autoload.php';

class DashboardProductService extends BaseDAO {

    use QueryTrait;

    public function __construct() {
        parent::__construct();
        $this->table = 'dashboard_product';
    }

    const TABLE_ALIAS = 'dp';
    
    const COMMON_COLUMNS = '
        p.sku, 
        p.code, 
        l.name AS line_name, 
        b.name AS brand_name, 
        product_id, 
        COUNT(product_id) as total, 
        SUM(quantity) as quantity_total';

    const COMMON_JOINS = [
        'INNER JOIN product p ON dp.product_id = p.id',
        'INNER JOIN line l ON p.line_id IS NULL OR p.line_id = l.id',
        'INNER JOIN brand b ON p.brand_id IS NULL OR p.brand_id = b.id'
    ];

    const COMMON_HAVING = [
        'total >' => 0,
        'quantity_total >' => 0
    ];

    /**
     * Save products to the dashboard
     * 
     * @param array $quotationData Quotation data
     * @param array $items List of quotation items
     * @return void
     */
    public function saveProducts(array $quotationData, array $items): void {        
        $now = DateTimeUtil::now();
        foreach ($items as $item) {
            if ($item instanceof QuotationItemInfo) {
                $clearData = [
                    'folio' => trim($quotationData['folio']),
                    'product_id' => $item->getId(),
                    'quantity' => $item->getQuantity(),
                    'month' => $now->format('m'),
                    'date' => $now->format('Y-m-d'),
                    'year' => $now->format('Y'),
                    'time' => $now->format('H:i:s')
                ];
                parent::insert($clearData);
            }
        }
    }

    /**
     * Get top 10 products with the most interactions (quotes) in general
     * 
     * @return array List of top 10 products with the most interactions
     */
    public function getTop10General(): array {
        $queryData = $this->createQueryData(
            tableAlias: self::TABLE_ALIAS,
            columns: self::COMMON_COLUMNS,
            joins: self::COMMON_JOINS,
            groupBy: 'product_id',
            having: self::COMMON_HAVING,
            orderBy: 'total DESC, quantity_total DESC',
            limit: 10
        );
        return parent::findAll($queryData);
    }

    /**
    * Get top 10 products by month and year
    *
    * @param string $monthYear Month and year in format mm/yyyy
    * @return array List of products
    */
    public function getTop10ByMonthYear(string $monthYear = ''): array {
        $conditions = [];
        if ($monthYear) {
            [$month, $year] = explode('/', $monthYear);
            $conditions['month'] = $month;
            $conditions['year'] = $year;
        } else {
            $conditions['month'] = DateTimeUtil::now()->format('m');
            $conditions['year'] = DateTimeUtil::now()->format('Y');
        }        

        $queryData = $this->createQueryData(
            tableAlias: self::TABLE_ALIAS,
            columns: self::COMMON_COLUMNS,
            joins: self::COMMON_JOINS,
            conditions: $conditions,
            groupBy: 'product_id',
            having: self::COMMON_HAVING,
            orderBy: 'total DESC, quantity_total DESC',
            limit: 10
        );
        return parent::findAll($queryData);
    }

}