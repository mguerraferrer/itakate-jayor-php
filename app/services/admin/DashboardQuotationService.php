<?php
require_once __DIR__ . '/../../../autoload.php';

class DashboardQuotationService extends BaseDAO {

    use QueryTrait;

    public function __construct() {
        parent::__construct();
        $this->table = 'dashboard_quotation';
    }

    const TABLE_ALIAS = 'dq';

    /**
     * Save quotation to the dashboard
     * 
     * @param int $quotationId Quotation ID
     * @return void
     */
    public function saveQuotation(int $quotationId): void {        
        $now = DateTimeUtil::now();
        $clearData = [
            'quotation_id' => $quotationId,
            'month' => $now->format('m'),
            'date' => $now->format('Y-m-d'),
            'year' => $now->format('Y'),
            'time' => $now->format('H:i:s')
        ];
        parent::insert($clearData);            
    }

    /**
    * Get quotations by date range
    *
    * @param string $startDate Start date (Y-m-d)
    * @param string $endDate End date (Y-m-d)
    * @return array List of quotations
    */
    public function getQuotationByDateRange(string $startDate = '', string $endDate = ''): array {
        $columns = 'dq.date, q.name, q.business_name, q.email, q.folio, q.product_use';
        return $this->getQuotationData($columns, $startDate, $endDate);
    }

    /**
     * Get quotation data for report with specified columns and date range
     * 
     * @param string $startDate Start date (Y-m-d)
     * @param string $endDate End date (Y-m-d)
     * @return array List of quotations with detailed data for report
     */
    public function getQuotationReportData(string $startDate = '', string $endDate = ''): array {        
        $columns = '
            dq.date, 
            q.folio, 
            q.name, 
            q.business_name, 
            q.rfc, 
            q.email, 
            q.phone,
            q.cell,
            q.product_use,
            q.street,
            q.outside_number,
            q.inside_number,
            q.colony,
            q.state,
            q.country,
            q.zip_code,
            q.comments';
        return $this->getQuotationData($columns, $startDate, $endDate);
    }

    /**
     * Get quotation data with specified columns and date range
     * 
     * @param string $columns Columns to select
     * @param string $startDate Start date (Y-m-d)
     * @param string $endDate End date (Y-m-d)
     * @return array List of quotations with specified columns
     */
    private function getQuotationData(string $columns, string $startDate = '', string $endDate = ''): array {
        $joins = ['INNER JOIN quotations q ON dq.quotation_id = q.id'];

        $conditions = [];
        if ($startDate && $endDate) {
            $startDate = DateTimeUtil::formatDate($startDate, 'Y-m-d');
            $endDate = DateTimeUtil::formatDate($endDate, 'Y-m-d');            
            $conditions['dq.date BETWEEN'] = [$startDate, $endDate];
        } else {
            $conditions['dq.month'] = DateTimeUtil::now()->format('m');
            $conditions['dq.year'] = DateTimeUtil::now()->format('Y');
        }        

        $queryData = $this->createQueryData(
            tableAlias: self::TABLE_ALIAS,
            columns: $columns,
            joins: $joins,
            conditions: $conditions,
            orderBy: 'dq.date DESC, dq.time DESC'
        );
        return parent::findAll($queryData);
    }

}