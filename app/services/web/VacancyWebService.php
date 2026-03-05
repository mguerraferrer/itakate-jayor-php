<?php
require_once __DIR__ . '/../../../autoload.php';

class VacancyWebService extends BaseDAO {

    use QueryTrait;

    public function __construct() {
        parent::__construct();
        $this->table = 'vacancy';
    }

    const COMMON_COLUMNS = 'code, title, content';

    /**
     * Get active vacancies
     *
     * @return array|null
     */
    public function getActiveVacancies(): ?array {
        $queryData = $this->createQueryData(
            columns: self::COMMON_COLUMNS,
            conditions: ['active' => 1]
        );
        return parent::findAll($queryData);
    }

    /**
     * Get a specific vacancy by code
     *
     * @param string $code
     * @return array|null
     */
    public function getVacancy(string $code): ?array {
        $conditions = ['code' => $code, 'active' => 1];
        $queryData = $this->createQueryData(
            columns: self::COMMON_COLUMNS,
            conditions: $conditions
        );
        return parent::findOne($queryData);
    }

}