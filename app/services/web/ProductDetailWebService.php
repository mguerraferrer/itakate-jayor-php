<?php
require_once __DIR__ . '/../../../autoload.php';

class ProductDetailWebService extends BaseDAO {

    use QueryTrait;

    public function __construct() {
        parent::__construct();
        $this->table = 'product_detail';
    }

    const TABLE_ALIAS = 'pd';

    /**
     * Get product details
     *
     * @param int $productId Product ID
     * @return array|null
     */
    public function getDetails(int $productId): ?array {
        $columns = 'd.code';
        $joins = [
            'INNER JOIN detail d ON pd.detail_id = d.id'
        ];
        $conditions = [
            'pd.product_id' => $productId,
            'd.active' => 1
        ];
        $queryData = $this->createQueryData(
            tableAlias: self::TABLE_ALIAS,
            columns: $columns,
            joins: $joins,
            conditions: $conditions,
            orderBy: 'pd.id'
        );
        return parent::findAll($queryData);
    }

}