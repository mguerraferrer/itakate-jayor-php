<?php
require_once __DIR__ . '/../../../autoload.php';

class ProductWebService extends BaseDAO {

    use QueryTrait;
    private ProductDetailWebService $productDetailWebService;

    public function __construct() {
        parent::__construct();
        $this->productDetailWebService = new ProductDetailWebService();
        $this->table = 'product';
    }

    const TABLE_ALIAS = 'p';
    const COMMON_COLUMNS = 'l.name AS line_name, p.product_group, p.sku, p.img';
    const COMMON_COLUMNS2 = 'p.product_group, p.sku, p.img, p.top_ten, p.top_ten_order, p.outlet';
    const COMMON_JOIN = ['INNER JOIN line l ON p.line_id = l.id'];

    /**
     * Get outlet products
     *
     * @return array|null
     */
    public function getTopTenProducts(): ?array {
        $columns = self::COMMON_COLUMNS . ', p.top_ten, p.top_ten_order';
        $conditions = [
            'p.top_ten' => 1,
            'p.active' => 1
        ];

        $queryData = $this->createQueryData(
            tableAlias: self::TABLE_ALIAS,
            columns: $columns,
            joins: self::COMMON_JOIN,
            conditions: $conditions,
            orderBy: 'p.top_ten'
        );
        return parent::findAll($queryData);
    }

    /**
     * Get outlet products
     *
     * @return array|null
     */
    public function getOutletProducts(): ?array {
        $conditions = ['p.outlet' => 1, 'p.active' => 1];
        $queryData = $this->createQueryData(
            tableAlias: self::TABLE_ALIAS,
            columns: self::COMMON_COLUMNS,
            joins: self::COMMON_JOIN,
            conditions: $conditions
        );
        return parent::findAll($queryData);
    }

    public function getProductsByBrand($brandCode): ?array {
        $columns = self::COMMON_COLUMNS2 . ', b.code AS brand_code';
        $joins = ['INNER JOIN brand b ON b.id = p.brand_id'];
        $conditions = [
            'b.code' => strtolower($brandCode),
            'p.active' => 1,
            'b.active' => 1
        ];
        $queryData = $this->createQueryData(
            tableAlias: self::TABLE_ALIAS,
            columns: $columns,
            joins: $joins,
            conditions: $conditions,
            groupBy: 'p.product_group',
            orderBy: 'p.sku'
        );
        return parent::findAll($queryData);
    }

    public function getProductsByLine(string $lineCode): ?array {
        $columns = self::COMMON_COLUMNS2 . ', l.code AS line_code';
        $joins = ['INNER JOIN line l ON l.id = p.line_id'];
        $conditions = [
            'l.code' => strtolower($lineCode),
            'p.active' => 1,
            'l.active' => 1
        ];
        $queryData = $this->createQueryData(
            tableAlias: self::TABLE_ALIAS,
            columns: $columns,
            joins: $joins,
            conditions: $conditions,
            groupBy: 'p.product_group',
            orderBy: 'p.sku'
        );
        return parent::findAll($queryData);
    }

    public function getProductsByGroup(string $group): ?ProductViewDetail {
        $columns = '
                l.id AS line_id,
                l.code AS line_code,
                l.name AS line_name,
                b.id AS brand_id,
                b.code AS brand_code,
                b.name AS brand_name,
                p.id,
                p.product_group,
                p.sku,
                p.code,
                p.cb_key,
                p.sales_factor,
                p.health_register,
                p.img,
                p.color,
                p.presentation,
                p.capacity,
                p.caliber,
                p.measure,
                p.size,
                p.length,
                p.volume,
                p.needle,
                p.bag_dimensions,
                p.neck_dimensions,
                p.guide_diameter,
                p.weight,
                p.top_ten,
                p.top_ten_order,
                p.outlet,
                p.in_stock,
                COUNT(DISTINCT pd.id) > 0 as has_details
            ';
        $joins = [
            'INNER JOIN line l ON l.id = p.line_id',
            'LEFT OUTER JOIN brand b on b.id = p.brand_id',
            'LEFT OUTER JOIN product_detail pd on p.id = pd.product_id',
            'LEFT OUTER JOIN detail ON pd.detail_id = detail.id'
        ];
        $conditions = [
            'p.product_group' => strtolower($group),
            'p.active' => 1
        ];
        $queryData = $this->createQueryData(
            tableAlias: self::TABLE_ALIAS,
            columns: $columns,
            joins: $joins,
            conditions: $conditions,
            groupBy: 'p.id'
        );

        $results = parent::findAll($queryData);
        if (empty($results)) {
            return null;
        }

        // Fetch and add product details for each product
        foreach ($results as &$productData) {
            if (!empty($productData['id'])) {
                $details = $this->productDetailWebService->getDetails((int)$productData['id']);
                // Add the details array to product data
                if (!empty($details)) {
                    $productData['product_details'] = $details;
                }
            }
        }
        unset($productData); // Break reference

        // Map results to ProductInfo objects (similar to Java Stream.map())
        $productInfoList = array_map(function($productData) {
            return ProductInfo::map($productData);
        }, $results);

        // Convert to ProductViewDetail
        return new ProductViewDetail($productInfoList);
    }

    /**
     * Get product by ID
     * 
     * @param int $productId Product ID
     * @return array|null Product information or null if not found
     */
    public function getProductById(int $productId): ?array {
        $columns = '
                b.name AS brand_name,
                p.id,
                p.product_group,
                p.sku,
                p.code,
                p.cb_key,
                p.sales_factor,
                p.health_register,
                p.img,
                p.color,
                p.presentation,
                p.capacity,
                p.caliber,
                p.measure,
                p.size,
                p.length,
                p.volume,
                p.needle,
                p.bag_dimensions,
                p.neck_dimensions,
                p.guide_diameter,
                p.weight
            ';
        $joins = [
            'LEFT OUTER JOIN brand b on b.id = p.brand_id'
        ];
        $conditions = [
            'p.id' => $productId,
            'p.active' => 1
        ];
        $queryData = $this->createQueryData(
            tableAlias: self::TABLE_ALIAS,
            columns: $columns,
            joins: $joins,
            conditions: $conditions
        );

        return parent::findOne($queryData) ?? null;
    }

}
