<?php
require_once __DIR__ . '/../../../autoload.php';

class DashboardContactService extends BaseDAO {

    use QueryTrait;

    public function __construct() {
        parent::__construct();
        $this->table = 'dashboard_contact';
    }

    /**
     * Save a contact message to the database
     * 
     * @param string $name Contact name
     * @param string $email Contact email
     * @return void
     */
    public function saveContact(string $name, string $email): void {
        $now = DateTimeUtil::now();
        $clearData = [
            'name' => trim($name),
            'email' => trim($email),
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
     * @return int Number of contacts received in the current month
     */
    public function getCountContactsByCurrentMonth(): int {
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
    * Get contacts by date range
    *
    * @param string $startDate Start date (Y-m-d)
    * @param string $endDate End date (Y-m-d)
    * @return array List of contacts
    */
    public function getContactsByDateRange(string $startDate = '', string $endDate = ''): array {
        $columns = 'name, email, date, time';

        $conditions = [];
        if ($startDate && $endDate) {
            $startDate = DateTimeUtil::formatDate($startDate, 'Y-m-d');
            $endDate = DateTimeUtil::formatDate($endDate, 'Y-m-d');            
            $conditions['date BETWEEN'] = [$startDate, $endDate];
        } else {
            $conditions['month'] = DateTimeUtil::now()->format('m');
            $conditions['year'] = DateTimeUtil::now()->format('Y');
        }        

        $queryData = $this->createQueryData(
            columns: $columns,
            conditions: $conditions,
            orderBy: 'date DESC, time DESC'
        );
        return parent::findAll($queryData);
    }

}