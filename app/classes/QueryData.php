<?php

/**
 * Data structure for query parameters. Used to pass data to DAO find methods
 * 
 * $tableAlias: optional table alias for queries
 * $columns: string of columns to select (default '*')
 * $joins: array of JOIN clauses
 * $conditions: associative array of column/operator => value for WHERE clause
 * $groupBy: string for GROUP BY clause
 * $having: associative array of column/operator => value for HAVING clause
 * $orderBy: string for ORDER BY clause
 * $limit: int for LIMIT clause (-1 = No limit)
 * $offset: int for OFFSET clause
 */
class QueryData {
    public string $tableAlias = '';
    public string $columns = '*';
    public array $joins = [];
    public array $conditions = [];
    public string $groupBy = '';
    public array $having = [];
    public string $orderBy = '';
    public int $limit = -1; // -1 = No limit
    public int $offset = 0;

    public function __construct(
        string $tableAlias = '',
        string $columns = '*',
        array $joins = [],
        array $conditions = [],
        string $groupBy = '',
        array $having = [],
        string $orderBy = '',
        int $limit = -1,
        int $offset = 0
    ) {
        $this->tableAlias = $tableAlias;
        $this->columns = $columns;
        $this->joins = $joins;
        $this->conditions = $conditions;
        $this->groupBy = $groupBy;
        $this->having = $having;
        $this->orderBy = $orderBy;
        $this->limit = $limit;
        $this->offset = $offset;
    }
}