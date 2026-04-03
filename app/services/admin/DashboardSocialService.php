<?php
require_once __DIR__ . '/../../../autoload.php';

class DashboardSocialService extends BaseDAO {

    use QueryTrait;

    public function __construct() {
        parent::__construct();
        $this->table = 'dashboard_social_networks';
    }

    /**
     * Save a social network interaction to the database
     * 
     * @param string $social Social network identifier (F, Y, L, W)
     * @return void
     */
    public function saveSocial(string $social): void {
        $now = DateTimeUtil::now();
        $clearData = [
            'social_network' => self::determineSocialType($social),
            'month' => $now->format('m'),
            'date' => $now->format('Y-m-d'),
            'year' => $now->format('Y'),
            'time' => $now->format('H:i:s')
        ];
        parent::insert($clearData);
    }

    private static function determineSocialType(string $social): string {
        return match (mb_strtoupper(trim($social))) {
            'F' => 'FACEBOOK',
            'Y' => 'YOUTUBE',
            'L' => 'LINKEDIN',
            'W' => 'WHATSAPP',
            default => throw new RuntimeException("Tipo de red social no reconocido: $social")
        };
    }

    /**
     * Get social network interactions received in the current month
     * 
     * @param string $socialNetwork Social network identifier (F, Y, L, W)
     * @return int Number of social network interactions received in the current month
     */
    public function getHistoricalCount(string $socialNetwork): int {
        $conditions = [
            'social_network' => self::determineSocialType($socialNetwork),    
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
    * Get social network interactions by month and year
    *
    * @param string $monthYear Month and year (mm/yyyy)
    * @return array List of social network interactions
    */
    public function getSocialByMonthYear(string $monthYear = ''): array {
        $columns = 'social_network, COUNT(*) AS count';

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
            groupBy: 'social_network',
            orderBy: 'count DESC, social_network ASC'
        );
        return parent::findAll($queryData);
    }

}