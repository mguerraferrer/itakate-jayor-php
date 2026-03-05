<?php

require_once __DIR__ . '/../config/database.php'; // Include DB config

/**
 * Base Data Access Object (DAO) class
 * Provides common database operations using PDO
 */
class BaseDAO {
    protected ?PDO $pdo;
    protected string $table; // Table name, set in child classes

    public function __construct() {
        $this->pdo = getPDO();
    }

    /**
     * Find all records matching the query data
     *
     * @param QueryData $data Object with all query parameters
     * @return array Array of results
     */
    public function findAll(QueryData $data): array {
        $sql = "SELECT {$data->columns} FROM {$this->table} {$data->tableAlias}";
        $params = [];
        $where = [];

        // Joins
        foreach ($data->joins as $join) {
            $sql .= " $join";
        }

        // WHERE conditions
        foreach ($data->conditions as $key => $value) {
            // Case 1: simple equality (no spaces, no parentheses, no :placeholder)
            if (!str_contains($key, ' ') && !str_contains($key, '(') && !str_contains($key, ':')) {
                $cleanKey = preg_replace('/[^a-zA-Z0-9_]/', '_', $key);
                $paramKey = ":eq_" . $cleanKey;
                $where[] = "$key = $paramKey";
                $params[$paramKey] = $value;
                continue;
            }

            // Case 2: simple operator (e.g. 'code !=', 'name LIKE') - regex for field + operator
            if (preg_match('/^([a-zA-Z0-9_.]+)\s+([<>=!]+|LIKE|NOT LIKE)$/i', $key, $matches)) {
                $field = trim($matches[1]);
                $operator = strtoupper(trim($matches[2]));

                $allowed = ['=', '!=', '<>', '<', '>', '<=', '>=', 'LIKE', 'NOT LIKE'];
                if (!in_array($operator, $allowed)) {
                    throw new InvalidArgumentException("Unsupported operator: $operator in $key");
                }

                $opClean = str_replace(['!', '<', '>', '=', ' '], '', $operator);
                $cleanField = preg_replace('/[^a-zA-Z0-9_]/', '_', $field);
                $paramKey = ":prm_{$opClean}_{$cleanField}";

                $where[] = "$field $operator $paramKey"; // Use field and operator separately
                $params[$paramKey] = $value;
                continue;
            }

            // Case 3: IN / NOT IN
            if (preg_match('/^([a-zA-Z0-9_.]+)\s+(IN|NOT IN)$/i', $key, $matches)) {
                $field = trim($matches[1]);
                $operator = strtoupper(trim($matches[2]));

                if (!is_array($value) || empty($value)) {
                    throw new InvalidArgumentException("The value for $operator must be a non-empty array for $key");
                }

                $placeholders = [];
                foreach ($value as $i => $val) {
                    $placeholders[] = ":in_{$i}";
                    $params[":in_{$i}"] = $val;
                }

                $where[] = "$field $operator (" . implode(', ', $placeholders) . ")";
                continue;
            }

            // Case 4: BETWEEN
            if (preg_match('/^([a-zA-Z0-9_.]+)\s+BETWEEN$/i', $key, $matches)) {
                $field = trim($matches[1]);

                if (!is_array($value) || count($value) !== 2) {
                    throw new InvalidArgumentException("BETWEEN requires an array with two values for $key");
                }

                $paramKey1 = ":btw_min_$field";
                $paramKey2 = ":btw_max_$field";

                $where[] = "$field BETWEEN $paramKey1 AND $paramKey2";
                $params[$paramKey1] = $value[0];
                $params[$paramKey2] = $value[1];
                continue;
            }

            // Case 5: IS NULL / IS NOT NULL
            if (preg_match('/^([a-zA-Z0-9_.]+)\s+(IS NULL|IS NOT NULL)$/i', $key, $matches)) {
                $field = trim($matches[1]);
                $operator = strtoupper(trim($matches[2]));

                if ($value !== null) {
                    throw new InvalidArgumentException("IS NULL / IS NOT NULL no debe tener valor asociado para $key");
                }

                $where[] = "$field $operator";
                continue;
            }

            // Case 6: complete SQL expression (e.g. "(t.name LIKE :search OR l.name LIKE :search)", with placeholder)
            // Check if the key contains :placeholder
            if (str_contains($key, ':')) {
                $paramKey = ':search';
                $where[] = $key;  // Use key as an SQL condition
                $params[$paramKey] = $value;
                continue;
            }

            // Case 7: static condition without a placeholder (value = null, e.g. "(u.league_id IS NULL OR l.is_active = 1)")
            if ($value === null) {
                $where[] = $key;  // Use key as an SQL condition, no param
                continue;
            }

            // Fallback: treat as equality
            $cleanKey = preg_replace('/[^a-zA-Z0-9_]/', '_', $key);
            $paramKey = ":eq_" . $cleanKey;
            $where[] = "$key = $paramKey";
            $params[$paramKey] = $value;
        }

        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        // GROUP BY
        if (!empty($data->groupBy)) {
            $sql .= " GROUP BY {$data->groupBy}";
        }

        // ORDER BY
        if (!empty($data->orderBy)) {
            $sql .= " ORDER BY {$data->orderBy}";
        }

        // LIMIT and OFFSET if specified (limit > 0)
        if ($data->limit > 0) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        try {
            $stmt = $this->pdo->prepare($sql);

            foreach ($params as $param => $val) {
                $stmt->bindValue($param, $val);
            }

            if ($data->limit > 0) {
                $stmt->bindValue(':limit', $data->limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $data->offset, PDO::PARAM_INT);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in select: " . $e->getMessage() . " | SQL: $sql | Params: " . json_encode($params));
            return [];
        }
    }

    /**
     * Find one record
     *
     * @param QueryData $data Query parameters
     * @return array|null Result or null if not found
     */
    public function findOne(QueryData $data): ?array {
        $results = $this->findAll($data);
        return $results[0] ?? null;
    }

    /**
     * INSERT: Inserts a new record
     *
     * @param array $data Ex: ['name' => 'John', 'email' => 'john@example.com']
     * @return int ID of the new record
     */
    public function insert(array $data): int {
        $keys = array_keys($data);
        $fields = implode(', ', $keys);
        $placeholders = ':' . implode(', :', $keys);

        $sql = "INSERT INTO $this->table ($fields) VALUES ($placeholders)";

        $stmt = $this->pdo->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    /**
     * UPDATE: Updates records with conditions
     *
     * @param QueryUpdateData $updateData Data and conditions for update
     * @return int Affected rows
     */
    public function update(QueryUpdateData $updateData): int {
        $fields = [];
        $params = [];
        $where = [];

        // Prepare SET
        foreach ($updateData->data as $key => $value) {
            $fields[] = "$key = :set_$key";
            $params[":set_$key"] = $value;
        }

        // Prepare WHERE
        foreach ($updateData->conditions as $key => $value) {
            $where[] = "$key = :where_$key";
            $params[":where_$key"] = $value;
        }

        // Optimistic lock: Add a version to WHERE if provided
        if ($updateData->expectedVersion !== null) {
            $where[] = "version = :expected_version";
            $params[':expected_version'] = $updateData->expectedVersion;

            // Increment version in SET
            $fields[] = "version = version + 1";
        }

        $sql = "UPDATE $this->table SET " . implode(', ', $fields) . " WHERE " . implode(' AND ', $where);

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            error_log("Error in update: " . $e->getMessage() . " | SQL: $sql | Params: " . json_encode($params));
            return 0;
        }
    }

    /**
     * DELETE: Deletes records with conditions
     *
     * @param array $conditions Ex: ['id' => 1]
     * @return int Affected rows
     */
    public function delete(array $conditions): int {
        $where = [];
        $params = [];

        foreach ($conditions as $key => $value) {
            $where[] = "$key = :$key";
            $params[":$key"] = $value;
        }

        $sql = "DELETE FROM $this->table WHERE " . implode(' AND ', $where);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->rowCount();
    }

    /**
     * Generate a unique alphanumeric code
     *
     * @param int $length Code length
     * @return string Generated unique code
     */
    protected function generateUniqueCode(int $length = 12): string {
        do {
            $code = strtolower(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, $length));
            $queryData = new QueryData(
                columns: 'id',
                conditions: ['code' => $code]
            );
            $exists = $this->findOne($queryData);
        } while (!empty($exists));

        return $code;
    }

    /**
     * Toggle a boolean field (e.g., is_active) for a record
     *
     * @param string $code Record code
     * @param string $field Field to toggle
     * @return int Affected rows
     */
    public function toggleActive(string $code, string $field = 'is_active'): int {
        $findOneData = new QueryData(
            columns: $field,
            conditions: ['code' => $code]
        );

        $record = $this->findOne($findOneData);
        if (!$record) {
            return 0;
        }

        $newValue = $record[$field] ? 0 : 1;
        $updateData = new QueryUpdateData(
            data: [$field => $newValue],
            conditions: ['code' => $code]
        );

        return $this->update($updateData);
    }
}