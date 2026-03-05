<?php

/**
 * Class representing the result of a validation
 * 
 * @property bool $isValid Indicates if the validation passed
 * @property string $message Message associated with the validation result 
 */
class ValidationResponse {
    public bool $isValid = true;
    public string $message;

    public function __construct(bool $isValid = true, string $message = '') {
        $this->isValid = $isValid;
        $this->message = $message;
    }
}