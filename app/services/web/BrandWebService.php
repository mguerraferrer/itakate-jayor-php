<?php
require_once __DIR__ . '/../../../autoload.php';

class BrandWebService extends BaseDAO {

    use QueryTrait;

    public function __construct() {
        parent::__construct();
        $this->table = 'brand';
    }

    /**
     * Get active brands
     *
     * @return array|null
     */
    public function getBrands(): ?array {
        $columns = 'id, code, name, image';
        $queryData = $this->createQueryData(
            columns: $columns,
            conditions: ['active' => 1, 'visible' => 1]
        );
        return parent::findAll($queryData);
    }

}