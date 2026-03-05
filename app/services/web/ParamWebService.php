<?php
require_once __DIR__ . '/../../../autoload.php';

class ParamWebService extends BaseDAO {

    use QueryTrait;

    public function __construct() {
        parent::__construct();
        $this->table = 'param';
    }

    /**
     * Get params by code
     *
     * @param array $codes Array of codes
     * @return array|null
     */
    public function getParamsByCode(array $codes): ?array {
        $columns = 'code, value';
        $conditions = [
            'code IN' => $codes,
            'active' => 1
        ];
        $queryData = $this->createQueryData(
            columns: $columns,
            conditions: $conditions
        );
        return parent::findAll($queryData);
    }
}