<?php

/** 
 * Data structure for update queries. Used to pass data to DAO update methods
 * 
 * $data: associative array of column => value to update
 * $conditions: associative array of column/operator => value for WHERE clause
 * $expectedVersion: optional int for concurrency control (version checking)
 */
class QueryUpdateData {
    public array $data = [];
    public array $conditions = [];
    public ?int $expectedVersion = null;

    public function __construct(
        array $data = [],
        array $conditions = [],
        ?int $expectedVersion = null
    ) {
        $this->data = $data;
        $this->conditions = $conditions;
        $this->expectedVersion = $expectedVersion;
    }
}