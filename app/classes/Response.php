<?php

/**
 * Standardized response structure for API responses
 */
class Response {

    /**
     * Standard response for persist requests
     *
     * @param int $id ID of the persisted record
     * @param string $responseMessage Response message
     * @return array Response array
     */
    public static function persistResponse(int $id, string $responseMessage, array $extra = []): array {
        return $id ? self::success($responseMessage, $extra) : self::error($responseMessage, $extra);
    }

    /**
     * Standard response for concurrency updates (optimistic lock)
     *
     * @param int $affectedRows Affected rows
     * @param string $successMessage Success message
     * @return array Response array
     */
    public static function concurrencyUpdateResponse(int $affectedRows, string $successMessage): array {
        return $affectedRows > 0 ? self::success($successMessage) : self::concurrencyError();
    }

    /**
     * Standard response for update requests
     *
     * @param int $affectedRows Affected rows
     * @param string $successMessage Success message
     * @param string $errorMessage Error message
     * @return array Response array
     */
    public static function updateResponse(int $affectedRows, string $successMessage, string $errorMessage): array {
        return $affectedRows > 0 ? self::success($successMessage) : self::error($errorMessage);
    }

    /**
     * Standard success response (no additional data)
     * 
     * @param string|null $message Optional message
     * @param array $extra Optional additional data
     * @return array Response array
     */
    public static function success(string $message = null, array $extra = []): array {
        return array_merge([
            'success' => true,
            'message' => $message ?? 'Operación realizada correctamente',
        ], $extra);
    }

    /**
     * Standard general error response
     * 
     * @param string $message Error message
     * @param array $extra Additional data (e.g., code, details)
     * @return array Response array
     */
    public static function error(string $message, array $extra = []): array {
        return array_merge([
            'success' => false,
            'message' => $message,
        ], $extra);
    }

    /**
     * Permission denied error response
     * 
     * @return array Response array
     */
    public static function permissionDenied(): array {
        return self::error('No tiene permisos para realizar esta acción', ['errorCode' => 403]);
    }

    /**
     * Access denied error response
     *
     * @return array Response array
     */
    public static function accessDenied(): array {
        return self::error('Acceso denegado. No tienes permiso para acceder a este recurso', ['errorCode' => 403]);
    }

    /**
     * Authentication required error response
     * 
     * @return array Response array
     */
    public static function authenticationRequired(): array {
        return self::error('Autenticación requerida para realizar esta acción', ['errorCode' => 401]);
    }

    /**
     * Bad request error response
     * 
     * @param string $message Error message
     * @return array Response array
     */
    public static function badRequest(string $message = 'Solicitud inválida'): array {
        return self::error($message, ['errorCode' => 400]);
    }

    /**
     * Successful validation response (no errors)
     * 
     * @return array Response array
     */
    public static function validationSuccess(): array {
        return [
            'success' => true,
            'validationErrors' => false,
            'message' => '',
            'validationFields' => []
        ];
    }

    /**
     * Validation error response (with failed fields)
     * 
     * @param array $errors Error list: [['field' => 'name', 'message' => '...'], ...]
     * @return array Response array
     */
    public static function validationError(array $errors): array {
        return [
            'success' => false,
            'validationErrors' => true,
            'message' => '', // No hay mensaje general, solo por campo
            'validationFields' => $errors
        ];
    }

    /**
     * Error response when a version is missing
     * 
     * @return array Response array
     */
    public static function versionRequiredError(): array {
        return self::error('Versión del registro requerida para actualización');
    }

    /**
     * Concurrency response (optimistic lock)
     *
     * @return array Response array
     */
    public static function concurrencyError(): array {
        return self::error('El registro fue modificado por otro usuario. Por favor, recarga la página y vuelve a intentarlo');
    }

    /**
     * Standardized response for paginated listings
     *
     * @param array $items List of items (leagues, tournaments, etc.)
     * @param int $total Total records in DB
     * @param int $pages Total pages
     * @param int $currentPage Current page
     * @param array $extra Optional additional data
     * @return array Response array
     */
    public static function paginatedSource(array $items, int $total, int $pages, int $currentPage, array $extra = []): array {
        return array_merge([
            'success' => true,
            'source' => $items,
            'total' => $total,
            'pages' => $pages,
            'currentPage' => $currentPage
        ], $extra);
    }

    public static function emptyPaginatedSource(array $extra = []): array {
        return array_merge([
            'success' => true,
            'source' => [],
            'total' => 0,
            'pages' => 0,
            'currentPage' => 1
        ], $extra);
    }

    /**
     * Standardized response for a list source
     * Used for select, combos, short lists, etc.
     *
     * @param array $items List of items
     * @param array $extra Optional additional data
     * @return array Response array
     */
    public static function listSource(array $items, array $extra = []): array {
        return array_merge([
            'success' => true,
            'items' => $items
        ], $extra);
    }

    /**
     * Standardized response for a list source (simple)
     * Used for select, combos, short lists, etc.
     * @param array $items List of items
     * @param array $extra Optional additional data
     * @return array Response array
     */
    public static function listSimpleSource(array $items, array $extra = []): array {
        return array_merge(['source' => $items], $extra);
    }

    /**
     * Standardized response for a single record (or entity)
     *
     * @param mixed $data The found record (array, object, null)
     * @param string|null $message Optional message
     * @param array $extra
     * @return array
     */
    public static function singleData(mixed $data, ?string $message = null, array $extra = []): array {
        return array_merge([
            'success' => $data !== null,
            'item' => $data ?? null,
            'message' => $message ?? ($data !== null ? 'Registro obtenido correctamente' : 'No se encontró el registro solicitado')
        ], $extra);
    }

    /**
     * Standardized response for optional data
     * 
     * @param mixed $data The data (array, object, null)
     * @param array $extra Optional additional data
     * @return array
     */
    public static function optionalData(mixed $data, array $extra = []): array {
        return array_merge([
            'success' => true,
            'item' => $data ?? null
        ], $extra);
    }

    /**
     * Specific error response for "not found"
     *
     * @param string $message Error message
     * @return array
     */
    public static function notFound(string $message = 'No se encontró el registro solicitado'): array {
        return [
            'success' => false,
            'item' => null,
            'message' => $message
        ];
    }
}