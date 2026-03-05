<?php

require_once __DIR__ . '/../../autoload.php';

/**
 * Validator class for input validation
 */
class Validator {

    /**
     * Validates required fields and returns structured errors
     *
     * @param array $data Received data
     * @param array $rules Rules: ['field_name' => ['required' => true, 'type' => 'number', 'message' => 'Optional message']]
     * @return array Validation response
     */
    public static function validateFields(array $data, array $rules): array {
        $errors = [];
        $defaultMessage = 'Este campo es requerido';

        // First, check for required fields
        foreach ($rules as $field => $rule) {
            $required = $rule['required'] ?? false; // By default, fields are not required
            $fieldType = $rule['type'] ?? 'text'; // text by default
            $frontEndField = $rule['frontEndField'] ?? $field;
            $customMessage = $rule['message'] ?? null;

            // Conditional required
            $conditional = $rule['conditional'] ?? false;
            $dependentOn = $rule['dependentOn'] ?? null;
            $dependentValue = $rule['dependentValue'] ?? null;
            $dependentEnumValue = $rule['dependentEnumValue'] ?? null;

            $isRequired = $required;

            if ($conditional && $dependentOn) {
                $dependentExists = array_key_exists($dependentOn, $data);
                $dependentDataValue = $data[$dependentOn] ?? null;
                if ($dependentValue !== null) {
                    $isRequired = $dependentExists && $dependentDataValue == $dependentValue;
                } else if ($dependentEnumValue !== null) {                    
                    $isRequired = $dependentExists && in_array($dependentDataValue, $dependentEnumValue);
                }
            }

            // Verify if the key exists in the received data
            $exists = array_key_exists($field, $data);
            $value = $data[$field] ?? null;

            $isValid = true;
            
            if ($isRequired) {
                if ($fieldType === 'boolean') {
                    // For booleans: fail if it doesn't exist or if it exists but is empty ('')
                    // Accepts only 0, 1, false and true                    
                    if (!$exists || $value === '') {                     
                        $isValid = false;
                    } else {
                        $normalized = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                        if ($normalized === null) {
                            $isValid = false;
                            $customMessage = 'Valor inválido para campo booleano';
                        }
                    }                
                } elseif ($fieldType === 'number') {
                    if (!$exists || !is_numeric($value) || trim($value) === '') {
                        $customMessage = 'Valor inválido para campo numérico';
                        $isValid = false;
                    }
                } elseif ($fieldType === 'file') {
                    // File validation (access $_FILES)
                    $file = $_FILES[$field] ?? null;
                    if (!$file) {
                        $customMessage = $rule['fileUploadMessage'] ?? 'El archivo es requerido';
                        $isValid = false;
                    }
                } else {
                    // text by default: fail if it doesn't exist or is empty after trim
                    if (!$exists || empty(trim($value))) {
                        $isValid = false;
                    }
                }
    
                if (!$isValid) {
                    $message = $customMessage ?? $defaultMessage;
                    $errors[] = ['field' => $frontEndField, 'message' => $message];
                }                
            }
        }
        
        // Then, validate fields with specific rules (min, max, etc.) only if no required field errors
        if (empty($errors)) {
            $errors = static::validateFieldsRules($data, $rules);
        }

        return !empty($errors) 
            ? Response::validationError($errors) 
            : Response::validationSuccess();
    }

    /**
     * Validates fields according to given rules
     * @param array $data Received data
     * @param array $rules Rules: ['field_name' => ['min' => x, 'max' => y, 'message' => 'Optional message']]
     * @return array List of errors
     */
    public static function validateFieldsRules(array $data, array $rules): array{
        $errors = [];

        foreach ($rules as $field => $rule) {
            $min = $rule['min'] ?? null;
            $max = $rule['max'] ?? null;
            $length = $rule['length'] ?? null;            
            $fieldType = $rule['type'] ?? null;
            $frontEndField = $rule['frontEndField'] ?? $field;

            // Verify if the key exists in the received data
            $exists = array_key_exists($field, $data);
            $value = $data[$field] ?? null;

            $customMessage = '';
            $isValid = true;

            if ($exists && $value !== '' && $value !== null) {
                // Field exists and has a value, validate further                
                if (isset($rule['enum'])) {// ENUM
                    $allowedValues = $rule['enum']['values'] ?? [];
                    $enumFrontEndField = $rule['enum']['frontEndField'] ?? $frontEndField;                    
                    if (!in_array($value, $allowedValues, true)) {
                        $customMessage = "Valor inválido para $enumFrontEndField";
                        $isValid = false;
                    }
                }

                // Time validation
                if ($fieldType === 'time') {                    
                    $validationResponse = self::validateTime($value);
                    $isValid = $validationResponse->isValid;
                    if (!$isValid) {
                        $customMessage = $validationResponse->message;
                    }                        
                } elseif ($fieldType === 'number') {
                    if (!is_numeric($value) || trim($value) === '') {
                        $customMessage = 'Valor inválido para campo numérico';
                        $isValid = false;
                    }
                } elseif (is_numeric($value)) {
                    // Min value validation
                    if ($min !== null && $value < $min) {
                        $customMessage = "El valor mínimo es $min";
                        $isValid = false;
                    }

                    // Max value validation
                    if ($max !== null && $value > $max) {
                        $customMessage = "El valor máximo es $max";
                        $isValid = false;
                    }

                    // Exact length validation
                    if ($length !== null && strlen((string)$value) != $length) {
                        $customMessage = "La longitud debe ser de $length dígitos";
                        $isValid = false;
                    }
                } elseif (is_string($value)) {
                    // Min length validation
                    if ($min !== null && strlen(trim($value)) < $min) {
                        $customMessage = "La longitud mínima es $min caracteres";
                        $isValid = false;
                    }

                    // Max length validation
                    if ($max !== null && strlen(trim($value)) > $max) {
                        $customMessage = "La longitud máxima es $max caracteres";
                        $isValid = false;
                    }

                    // Exact length validation
                    if ($length !== null && strlen(trim($value)) != $length) {
                        $customMessage = "La longitud debe ser de $length caracteres";
                        $isValid = false;
                    }

                    // Email validation
                    if ($fieldType === 'email') {
                        $validationResponse = self::validateEmail($value);
                        $isValid = $validationResponse->isValid;
                        if (!$isValid) {
                            $customMessage = $validationResponse->message;
                        }
                    }

                    // Date validation
                    if ($fieldType === 'date') {
                        $validationResponse = self::validateDate($data, $rule, $value);
                        $isValid = $validationResponse->isValid;
                        if (!$isValid) {
                            $customMessage = $validationResponse->message;
                        }                        
                    }

                    // DateTime validation
                    if ($fieldType === 'datetime') {
                        if (!DateTimeUtil::isValidDateTime($value)) {
                            $customMessage = 'La fecha y hora especificadas son inválidas';
                            $isValid = false;
                        }
                    }

                    // Email validation
                    if ($fieldType === 'rfc') {
                        $validationResponse = self::validateRfc($value);
                        $isValid = $validationResponse->isValid;
                        if (!$isValid) {
                            $customMessage = $validationResponse->message;
                        }
                    }
                } elseif ($fieldType === 'file') {
                    $allowedTypes = $rule['allowedTypes'] ?? FileUtil::ALLOWED_DOC_TYPES;
                    $maxSize = $rule['maxFileSize'] ?? FileUtil::MAX_FILE_SIZE_DEFAULT; // 1 MB

                    // File validation (access $_FILES)
                    $file = $_FILES[$field] ?? null;
                    if ($file && $file['error'] === UPLOAD_ERR_OK) {
                        if (!in_array($file['type'], $allowedTypes)) {
                            $customMessage = $rule['fileTypeMessage'] ?? 'La extensión del archivo no es válida';
                            $isValid = false;
                        } elseif ($file['size'] > $maxSize) {
                            $customMessage = $rule['fileSizeMessage'] ?? "El tamaño del archivo excede el permitido: $maxSize mb";
                            $isValid = false;
                        }
                    } else {
                        // Handle file upload errors
                        if ($file && $file['error'] !== UPLOAD_ERR_NO_FILE) {
                            $customMessage = $rule['fileUploadMessage'] ?? 'Error al subir el archivo';
                            $isValid = false;
                        }
                    }
                }
            }

            if (!$isValid) {
                $errors[] = ['field' => $frontEndField, 'message' => $customMessage];
            }
        }
        
        return $errors;
    }

    /**
     * Validates password according to defined rules:
     * - Must match confirm_password
     * - Minimum 8 characters
     * - At least one number
     * - At least one uppercase letter
     * - At least one special character
     * - No whitespaces
     *
     * @param string $password Password to validate
     * @param string $repassword Confirmation password to validate
     * @param string $field Field name for error reporting
     * @return array Validation response
     */
    public static function validatePassword(string $password, string $repassword, string $field = 'password'): array {
        $errorMessage = '';
        $errors = [];

        $isValid = true;

        if ($password === '' || $repassword === '') {
            $errorMessage = 'La contraseña y su confirmación son obligatorias';
            $isValid = false;            
        }

        if ($isValid && $password !== $repassword) {
            $errorMessage = 'Las contraseñas no coinciden';
            $isValid = false;            
        }

        if ($isValid && strlen($password) < 8) {
            $errorMessage = 'La contraseña debe tener al menos 8 caracteres';
            $isValid = false;            
        }
        if ($isValid && !preg_match('/[0-9]/', $password)) {
            $errorMessage = 'La contraseña debe contener al menos un número';
            $isValid = false;
        }

        if ($isValid && !preg_match('/[A-Z]/', $password)) {
            $errorMessage = 'La contraseña debe contener al menos una letra mayúscula';
            $isValid = false;
        }
        
        if ($isValid && !preg_match('/[\W_]/', $password)) {
            $errorMessage = 'La contraseña debe contener al menos un carácter especial';
            $isValid = false;
        }

        if ($isValid && preg_match('/\s/', $password)) {
            $errorMessage = 'La contraseña no puede contener espacios en blanco';
            $isValid = false;
        }

        if (!$isValid) {
            $errors[] = ['field' => $field, 'message' => $errorMessage];
        }

        return !empty($errors)
            ? Response::validationError($errors) 
            : Response::validationSuccess();
    }
    
    /**
     * Validates a date field, with optional comparison to another date field
     * 
     * @param array $data Received data
     * @param array $rule Validation rule for the date field
     * @param string $value Value of the date field
     * @return ValidationResponse Validation response
     */
    private static function validateDate(array $data, array $rule, string $value) : ValidationResponse {
        $isValid = true;
        $customMessage = '';                                        
        $compareAsDate = $rule['compareAsDate'] ?? null;

        if (!DateTimeUtil::isValidDate($value)) {
            $customMessage = 'La fecha especificada es inválida';
            $isValid = false;
        } else if ($compareAsDate) {
            $dateToCompareField = $compareAsDate['dateToCompare'] ?? null;
            $operator = $compareAsDate['operator'] ?? null;
            $compareMessage = $compareAsDate['message'] ?? 'Alguna de las fechas no es válida';

            if ($dateToCompareField) {
                $dateToCompareValue = $data[$dateToCompareField] ?? null;
                if ($dateToCompareValue !== null) {
                    $dateComparison = DateTimeUtil::compareDates($value, $dateToCompareValue);
                    if ($dateComparison === null) {
                        // One of the dates is invalid
                        $customMessage = "La fecha especificada es inválida";
                        $isValid = false;
                    } else {
                        switch ($operator) {
                            case 'BEFORE':
                                if (!($dateComparison === -1)) {
                                    $customMessage = $compareMessage;
                                    $isValid = false;
                                }
                                break;
                            case 'EQUAL':
                                if (!($dateComparison === 0)) {
                                    $customMessage = $compareMessage;
                                    $isValid = false;
                                }
                                break;
                            case 'AFTER':
                                if (!($dateComparison === 1)) {
                                    $customMessage = $compareMessage;
                                    $isValid = false;
                                }
                                break;
                        }
                    }
                }
            }
        }

        return new ValidationResponse($isValid, $customMessage);
    }

    /**
     * Validates a time field, with format HH:MM AM/PM, e.g., 02:30 PM
     *
     * @param string $value Value of the time field
     * @return ValidationResponse Validation response
     */
    private static function validateTime(string $value) : ValidationResponse {
        $isValid = true;
        $customMessage = '';                                        

        // Validate time format HH:MM AM/PM
        if (!preg_match('/^(0[1-9]|1[0-2]):([0-5][0-9])\s?(AM|PM)$/i', $value)) {
            $customMessage = 'La hora especificada es inválida. Formato esperado: HH:MM AM/PM';
            $isValid = false;
        }

        return new ValidationResponse($isValid, $customMessage);
    }

    /**
     * Validates an email field
     *
     * @param string $value Value of the email field
     * @return ValidationResponse Validation response
     */
    private static function validateEmail(string $value) : ValidationResponse {
        $isValid = true;
        $customMessage = '';

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $customMessage = 'El correo electrónico especificado es inválido';
            $isValid = false;
        }

        return new ValidationResponse($isValid, $customMessage);
    }

    /**
     * Validates an RFC field
     *
     * @param string $value Value of the RFC field
     * @return ValidationResponse Validation response
     */
    private static function validateRfc(string $value) : ValidationResponse {
        $isValid = true;
        $customMessage = '';

        if (!preg_match('/^[A-ZÑ&]{3,4}\d{6}[A-Z0-9]{3}$/', $value)) {
            $customMessage = 'El formato del RFC no es válido';
            $isValid = false;
        }

        return new ValidationResponse($isValid, $customMessage);
    }
}
