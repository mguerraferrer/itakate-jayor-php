'use strict';

/**
 * Update sort icons in table headers
 *
 * @param {string} tableSelector - CSS Selector of the table (e.g., '#leaguesTable')
 * @param {string} currentSortField - Currently sorted field (e.g., 'name')
 * @param {string} currentSortDir - Current direction ('ASC' or 'DESC')
 */
const updateSortIcons = (tableSelector, currentSortField, currentSortDir) => {
    const headers = document.querySelectorAll(`${tableSelector} thead th.sortable`);

    headers.forEach(header => {
        const field = header.dataset.sortField;
        const icon = header.querySelector('.sort-icon');

        if (!icon) return;

        if (field === currentSortField) {
            // Active column: clear icon with a direction
            icon.innerHTML = currentSortDir === 'ASC'
                ? '<i class="fal fa-sort-amount-up-alt"></i>'
                : '<i class="fal fa-sort-amount-down"></i>';
            icon.style.opacity = '1';
            icon.style.color = 'var(--primary)';
        } else {
            // Sortable columns but not active: disabled icon (opaque)
            icon.innerHTML = '<i class="fal fa-sort-alt"></i>'; // Neutral icon (simple arrows)
            icon.style.opacity = '0.4'; // Reduced opacity
            icon.style.color = 'var(--text-muted)'; // Gray/disabled color
        }

        // Always visible
        icon.classList.remove('d-none');
    });
};

const removeSortIcons = (tableSelector) => {
    const headers = document.querySelectorAll(`${tableSelector} thead th.sortable`);
    headers.forEach(header => {
        const icon = header.querySelector('.sort-icon');
        if (icon) {
            icon.remove();
        }
    });
}

/**
 * Function to validate all required fields of a form
 *
 * @param {HTMLFormElement} form - The form element to validate
 * @returns {boolean} - True if all required fields are valid, false otherwise
 */
const validateFormData = (form) => {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[data-required="true"]');

    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });

    return isValid;
}

/**
 * Validates a specific set of required fields in a form
 *
 * @param {HTMLFormElement} form - The form element to validate
 * @param {string[]} fieldIds - The IDs of the fields that must be validated
 * @returns {boolean} True if all required fields are valid; otherwise, false
 */
const validateRequiredFields = (form, fieldIds) => {
    let isValid = true;
    for (const fieldId of fieldIds) {
        const field = form.querySelector(`#${fieldId}`);
        if (field && field.dataset.required === 'true' && !validateField(field)) {
            isValid = false;
        }
    }
    return isValid;
}

/**
 * Main function to validate a single field
 *
 * @param {HTMLElement} field - The field to validate
 * @returns {boolean} - True if the field is valid, false otherwise
 */
const validateField = (field) => {
    const fieldId = field.id;
    const container = document.getElementById(`div-${fieldId}`);
    const errorSmall = document.getElementById(`small-${fieldId}`);

    // If a container or small doesn't exist, do nothing
    if (!container || !errorSmall) return true;

    // Check if a field or container is hidden
    const isHidden = container.classList.contains('d-none') || field.classList.contains('d-none');
    if (isHidden) {
        // If hidden do not validate, always valid
        clearFieldError(field);
        return true;
    }

    let isValid = true;
    let errorMessage = '';

    // Clear previous error
    clearFieldError(field);

    // Required validation
    const isRequired = field.getAttribute('data-required') === 'true';
    if (isRequired && !field.value.trim()) {
        isValid = false;
        errorMessage = 'Este campo es requerido';
    }

    // Specific validations by field type (you can extend it)
    if (isValid) {
        switch (field.type) {
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(field.value.trim())) {
                    isValid = false;
                    errorMessage = 'Por favor ingresa un correo electrónico válido';
                }
                break;

            case 'text':
                // Example: if it has data-min-length
                const minLength = parseInt(field.getAttribute('data-min-length') || 0);
                if (minLength > 0 && field.value.trim().length < minLength) {
                    isValid = false;
                    errorMessage = `Mínimo ${minLength} caracteres`;
                }
                break;

            case 'password':
                // Example: minimum 8 characters
                if (field.value.length < 8) {
                    isValid = false;
                    errorMessage = 'La contraseña debe tener al menos 8 caracteres';
                }
                break;

            // Add more validations if needed (phone, number, date, etc.)
        }
    }

    // Show error or clear
    if (!isValid) {
        setFieldError(fieldId, errorMessage);
    }

    return isValid;
}

/**
 * Function to validate a field as required with custom error message
 *
 * @param {HTMLElement} field - The field to validate
 * @param {string} [errorMessage=null] - Custom error message (optional)
 * @returns {boolean} - True if the field is valid, false otherwise
 */
const validateFieldAsRequired = (field, errorMessage = null) => {
    const fieldId = field.id;
    const container = document.getElementById(`div-${fieldId}`);
    const errorSmall = document.getElementById(`small-${fieldId}`);

    // If a container or small doesn't exist, do nothing
    if (!container || !errorSmall) return true;

    let isValid = true;

    // Clear previous error
    clearFieldError(field);

    // Required validation
    if (!field.value.trim()) {
        isValid = false;
        errorMessage = errorMessage || 'Este campo es requerido';
    }

    // Show error or clear
    if (!isValid) {
        setFieldError(fieldId, errorMessage);
    }

    return isValid;
}

/**
 * Generic function to validate a field conditionally based on another field's value
 *
 * @param {object} config - Configuration object
 * @param {string} config.triggerFieldId - ID of the field that triggers the validation
 * @param {*} config.triggerValue - Value that triggers the validation (will be compared with ==)
 * @param {array} [config.triggerValues] - Array of values that trigger the validation (compared with includes)
 * @param {string} config.targetFieldId - ID of the field to validate when condition is met
 * @param {string} config.errorMessage - Error message to show when validation fails
 * @param {string} [config.emptyValue=''] - Value to set when condition is not met (default: '')
 * @returns {boolean} - Returns true if validation passes, false if it fails
 */
const validateConditionalRequired = (config) => {
    const {
        triggerFieldId,
        triggerValue,
        triggerValues = [],
        targetFieldId,
        errorMessage,
        emptyValue = ''
    } = config;

    // Get current value of trigger field
    const triggerValueCurrent = getValue(triggerFieldId);

    // Determine if the condition is met
    let conditionMet = false;

    if (triggerValues.length > 0) {
        // Use triggerValues array if provided
        conditionMet = triggerValues.includes(triggerValueCurrent);
    } else if (triggerValue !== undefined) {
        // Fallback to single triggerValue
        conditionMet = triggerValueCurrent === triggerValue;
    }

    if (conditionMet) {
        // Validate the target field as required
        const targetField = document.getElementById(targetFieldId);
        const isTargetValid = validateFieldAsRequired(targetField, errorMessage);
        if (!isTargetValid) return false;
    } else {
        // Set the target field to empty value if the condition is not met
        setSelectValue(targetFieldId, emptyValue);
    }

    return true;
}

/**
 * Function to set an error message for a field
 *
 * @param {string} fieldId - The ID of the field
 * @param {string} message - The error message to display
 */
const setFieldError = (fieldId, message) => {
    const field = document.getElementById(fieldId);
    const errorSmall = document.getElementById(`small-${fieldId}`);
    const container = document.getElementById(`div-${fieldId}`);
    if (field && errorSmall && container) {
        container.classList.add('has-error');
        field.classList.add('is-invalid');
        errorSmall.textContent = message;
        errorSmall.classList.add('invalid-feedback');
    }
}

/**
 * Function to set an error message for a container
 *
 * @param {string} containerId - The ID of the container
 * @param {string} message - The error message to display
 */
const setContainerError = (containerId, message) => {
    const container = document.getElementById(containerId);
    const errorSmall = document.getElementById(`small-${containerId}`);
    if (container && errorSmall) {
        container.classList.add('has-error');
        errorSmall.textContent = message;
        errorSmall.classList.add('invalid-feedback');
    }
}

/**
 * Function to clear an error message for a field
 *
 * @param {HTMLElement} field - The field to clear error
 */
const clearFieldError = (field) => {
    field.classList.remove('is-invalid');

    const container = document.getElementById(`div-${field.id}`);
    if (container) {
        container.classList.remove('has-error');
    }

    const errorSmall = document.getElementById(`small-${field.id}`);
    if (errorSmall) {
        errorSmall.textContent = '';
        errorSmall.classList.remove('invalid-feedback');
    }
}

/**
 * Function to clear an error message for a container
 *
 * @param {string} containerId - The ID of the container to clear error
 */
const clearContainerError = (containerId) => {
    const container = document.getElementById(containerId);
    if (container) {
        container.classList.remove('has-error');
    }

    const errorSmall = document.getElementById(`small-${containerId}`);
    if (errorSmall) {
        errorSmall.textContent = '';
        errorSmall.classList.remove('invalid-feedback');
    }
}

/**
 * Function to clear all errors of a form
 *
 * @param {HTMLFormElement} form - The form element to clear errors from
 */
const clearFormFieldsErrors = (form) => {
    const errorSmalls = form.querySelectorAll('[id^="small-"]');
    errorSmalls.forEach(small => {
        small.textContent = '';
        small.classList.remove('invalid-feedback');
    });

    const containers = form.querySelectorAll('[id^="div-"]');
    containers.forEach(cont => cont.classList.remove('has-error'));

    form.querySelectorAll('input, textarea, select').forEach(field => {
        field.classList.remove('is-invalid');
    });
}

/**
 * Function to evaluate and display validation errors or general errors from server response
 *
 * @param {Object} responseData - The response data object received from Axios
 * @param {string} [defaultMessage='Ha ocurrido un error inesperado ejecutando la acción'] - Default message for general errors
 */
const evaluateErrors = (responseData, defaultMessage = 'Ha ocurrido un error inesperado ejecutando la acción') => {
    if (responseData.validationErrors) {
        // Show field-specific errors
        responseData.validationFields.forEach(err => {
            setFieldError(err.field, err.message);
        });

        // Toast general if there are multiple errors (3 or more)
        const errorCount = responseData.validationFields.length;
        const errorMessage = `Se encontraron ${errorCount} error${errorCount === 1 ? '' : 'es'}. Revisa los campos marcados.`
        if (errorCount >= 3) {
            iziToastError({message: errorMessage});
        }
    } else {
        // General error (non-validation)
        const errorMessage = responseData.message || defaultMessage;
        iziToastError({message: errorMessage});
    }
}

/**
 * Format a Date object to 'yyyy-mm-dd' string for backend
 *
 * @param {Object} date - Date object
 * @returns {string|null} - Formatted date string or null if date is invalid
 */
const formatDate = (date) => {
    if (!date) return '';
    // Backend format: yyyy-mm-dd
    const yyyy = date.getFullYear();
    const mm = String(date.getMonth() + 1).padStart(2, '0');
    const dd = String(date.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
}

/**
 * Automatically bind validation to all forms on the page
 */
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form').forEach(form => {
        // Real-time validation
        form.querySelectorAll('input, textarea, select').forEach(field => {
            // When leaving the field
            /*field.addEventListener('blur', () => {
                if (field.getAttribute('data-required') === 'true') {
                    validateField(field);
                }
            });*/

            // Clear error while typing
            field.addEventListener('input', () => {
                clearFieldError(field);
            });
        });

        // Intercept submit
        form.addEventListener('submit', function (e) {
            // If form already has special handler (e.g., Axios), don't block
            if (form.hasAttribute('data-ajax-submit')) {
                // Only validate, but let another script handle submitting
                if (!validateFormData(form)) {
                    e.preventDefault();
                    return false;
                }
            } else {
                // Default behavior: block if validation fails
                if (!validateFormData(form)) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    });
});

/* Global function to be able to use from other scripts if necessary */
/**
 * Global function to validate a form by its ID
 * @param {string} formId - The ID of the form to validate
 * @returns {boolean} - True if the form is valid, false otherwise
 */
window.validateForm = function (formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    return validateFormData(form);
};

/**
 * Global function to clear all errors of a form by its ID
 * @param {string} formId - The ID of the form to clear errors from
 */
window.clearFormErrors = function (formId) {
    const form = document.getElementById(formId);
    if (form) clearFormFieldsErrors(form);
};

const recaptchaInvalid = (recaptchaContainerId, message) => {
    const container = document.getElementById(recaptchaContainerId);
    const errorSmall = document.getElementById(`small-${recaptchaContainerId}`);
    if (container && errorSmall) {
        errorSmall.textContent = message;
        errorSmall.classList.add('invalid-recaptcha');
    }
}

const clearRecaptchaError = (recaptchaContainerId) => {
    const errorSmall = document.getElementById(`small-${recaptchaContainerId}`);
    if (errorSmall) {
        errorSmall.textContent = '';
        errorSmall.classList.remove('invalid-recaptcha');
    }
}