<?php
require_once __DIR__ . '/../../../autoload.php';

class LineWebService extends BaseDAO {

    use QueryTrait;

    public function __construct() {
        parent::__construct();
        $this->table = 'line';
    }

    /**
     * Get active lines
     *
     * @return array|null
     */
    public function getLines(): ?array {
        $columns = 'id, code, name, img, img1, color, description';
        $queryData = $this->createQueryData(
            columns: $columns,
            conditions: ['active' => 1]
        );
        return parent::findAll($queryData);
    }

}