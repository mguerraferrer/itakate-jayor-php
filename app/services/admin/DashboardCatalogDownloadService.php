<?php
require_once __DIR__ . '/../../../autoload.php';

class DashboardCatalogDownloadService extends BaseDAO {

    use QueryTrait;

    public function __construct() {
        parent::__construct();
        $this->table = 'dashboard_catalog_downloads';
    }

    /**
     * Save a catalog download to the database
     * 
     * @return void
     */
    public function saveCatalogDownload(): void {
        $now = DateTimeUtil::now();
        $clearData = [
            'month' => $now->format('m'),
            'date' => $now->format('Y-m-d'),
            'year' => $now->format('Y'),
            'time' => $now->format('H:i:s')
        ];
        parent::insert($clearData);
    }

    /**
     * Get catalog downloads received in the current month
     * 
     * @return int Number of catalog downloads received in the current month
     */
    public function getHistoricalCount(): int {
        $conditions = [
            'date <=' => DateTimeUtil::now()->format('Y-m-d')      
        ];        
        $queryData = $this->createQueryData(
            columns: 'COUNT(*) AS count',
            conditions: $conditions
        );
        $result = parent::findOne($queryData);
        return $result ? $result['count'] : 0;
    }

    /**
    * Get catalog downloads by month and year
    *
    * @param string $monthYear Month and year (mm/yyyy)
    * @return array List of catalog downloads
    */
    public function getCatalogDownloadsByMonthYear(string $monthYear = ''): array {
        $columns = 'COUNT(*) AS count';

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
            columns: $columns,
            conditions: $conditions,
            orderBy: 'count DESC'
        );
        return parent::findAll($queryData);
    }

}