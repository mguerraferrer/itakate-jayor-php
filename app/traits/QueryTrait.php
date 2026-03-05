<?php

// Include required classes
require_once __DIR__ . '/../classes/QueryData.php';
require_once __DIR__ . '/../classes/QueryUpdateData.php';
require_once __DIR__ . '/../classes/Response.php';

/**
 * Trait for common query data operations in controllers
 */
trait QueryTrait {

    /**
     * Sanitize sort string to prevent SQL injection and clean unwanted characters
     *
     * @param string $sort Sort string to sanitize
     * @return string Sanitized sort string
     */
    protected function sanitizeSort(string $sort): string {
        return preg_replace('/[^a-zA-Z0-9_ ,.]/', '', $sort);
    }

    /**
     * Create a QueryData object with common parameters
     *
     * @param string $tableAlias Table alias
     * @param string $columns Columns to select
     * @param array $joins Join clauses
     * @param array $conditions WHERE conditions
     * @param string $groupBy
     * @param string $orderBy ORDER BY clause
     * @param int $limit LIMIT clause
     * @param int $offset OFFSET clause
     * @return QueryData
     */
    protected function createQueryData(
        string $tableAlias = '',
        string $columns = '*',
        array  $joins = [],
        array  $conditions = [],
        string $groupBy = '',
        string $orderBy = '',
        int    $limit = -1,
        int    $offset = 0
    ): QueryData {
        return new QueryData(
            tableAlias: $tableAlias,
            columns: $columns,
            joins: $joins,
            conditions: $conditions,
            groupBy: $groupBy,
            orderBy: $this->sanitizeSort($orderBy),
            limit: $limit,
            offset: $offset
        );
    }

    /**
     * Create QueryUpdateData object
     *
     * @param array $data Data to update
     * @param array $conditions WHERE conditions
     * @param int|null $expectedVersion Expected version for optimistic locking
     * @return QueryUpdateData
     */
    protected function createQueryUpdateData(
        array $data = [],
        array $conditions = [],
        ?int  $expectedVersion = null
    ): QueryUpdateData {
        return new QueryUpdateData(
            data: $data,
            conditions: $conditions,
            expectedVersion: $expectedVersion
        );
    }

    /**
     * Create a paginated list response
     *
     * @param array $items List of items
     * @param array $totalResult Total result from DB
     * @param int $page Based page number
     * @param int $limit Items per page
     * @param array $extraInfo Extra info to include in response
     * @return array Paginated response
     */
    protected function paginatedResults(
        array $items,
        array $totalResult,
        int   $page,
        int   $limit,
        array $extraInfo = []
    ): array {
        $total = (int)($totalResult['total'] ?? 0);
        $pages = (int)ceil($total / $limit);
        return Response::paginatedSource($items, $total, $pages, $page, $extraInfo);
    }
}
