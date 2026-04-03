<?php
require_once __DIR__ . '/../../../autoload.php';

class DashboardPharmaService extends BaseDAO {

    use QueryTrait;

    public function __construct() {
        parent::__construct();
        $this->table = 'dashboard_farmacovigilancia';
    }

    /**
     * Save a pharmacovigilance report to the database
     * 
     * @param string $name Reporter's name
     * @param string $email Reporter's email
     * @param string $phone Reporter's phone
     * @param string $personType Reporter's person type
     * @return void
     */
    public function savePharma(string $name, string $email, string $phone, string $personType): void {
        $now = DateTimeUtil::now();
        $clearData = [
            'nombre' => trim($name),
            'correo_electronico' => trim($email),
            'telefono' => trim($phone),
            'tipo' => trim($personType),
            'month' => $now->format('m'),
            'date' => $now->format('Y-m-d'),
            'year' => $now->format('Y'),
            'time' => $now->format('H:i:s')
        ];
        parent::insert($clearData);
    }

    /**
     * Get contacts received in the current month
     * 
     * @return int Number of pharmacovigilance reports received in the current month
     */
    public function getCountByCurrentMonth(): int {
        $conditions = [
            'month' => DateTimeUtil::now()->format('m'),
            'year' => DateTimeUtil::now()->format('Y')
        ];
        $queryData = $this->createQueryData(
            columns: 'COUNT(*) AS count',
            conditions: $conditions
        );
        $result = parent::findOne($queryData);
        return $result ? $result['count'] : 0;
    }

    /**
    * Get pharmacovigilance reports by month/year
    *
    * @param string $monthYear Month/Year (mm/yyyy)
    * @return array List of pharmacovigilance reports
    */
    public function getPharmaByMonthYear(string $monthYear = ''): array {
        $columns = 'nombre, correo_electronico, telefono, tipo, date, time';

        $conditions = [];
        if ($monthYear) {
            [$month, $year] = explode('/', $monthYear);
            $conditions['month'] = $month;
            $conditions['year'] = $year;
        } else {
            $conditions['date <='] = DateTimeUtil::now()->format('Y-m-d');
        }        

        $queryData = $this->createQueryData(
            columns: $columns,
            conditions: $conditions,
            orderBy: 'date DESC, time DESC'
        );
        return parent::findAll($queryData);
    }

}