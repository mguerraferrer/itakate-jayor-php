'use strict';

const setNavActive = (elementId) => {
    addClass(elementId, 'fw-bold');
}

/**
 * Lock the primary button (shows spinner and "Processing...") and disables the cancel button
 * @param {string} primaryBtnId - ID of the primary button (e.g., 'saveBtn', 'confirmBtn')
 * @param {string} [cancelBtnId] - ID of the cancel button (optional)
 */
const lockButtons = (primaryBtnId, cancelBtnId = null) => {
    const primaryBtn = document.getElementById(primaryBtnId);
    if (!primaryBtn) {
        console.log(`[ERROR] Primary button not found: #${primaryBtnId}`);
        return;
    }

    // Internal elements of the primary button
    const btnText = primaryBtn.querySelector('.btn-text');
    const spinner = primaryBtn.querySelector('.spinner-border');
    const processingText = primaryBtn.querySelector('.processing-text');

    // Disable and show loading
    primaryBtn.disabled = true;

    if (btnText) btnText.classList.add('d-none');
    if (spinner) spinner.classList.remove('d-none');
    if (processingText) processingText.classList.remove('d-none');

    // Disable cancel button if provided
    if (cancelBtnId) {
        const cancelBtn = document.getElementById(cancelBtnId);
        if (cancelBtn) {
            cancelBtn.disabled = true;
        }
    }
}

/**
 * Unlock the primary button (reverts to normal text) and enables the cancel button
 * 
 * @param {string} primaryBtnId - ID of the primary button
 * @param {string} [cancelBtnId] - ID of the cancel button (optional)
 */
const unlockButtons = (primaryBtnId, cancelBtnId = null) => {
    const primaryBtn = document.getElementById(primaryBtnId);
    if (!primaryBtn) {
        console.warn(`Primary button not found: #${primaryBtnId}`);
        return;
    }

    const btnText = primaryBtn.querySelector('.btn-text');
    const spinner = primaryBtn.querySelector('.spinner-border');
    const processingText = primaryBtn.querySelector('.processing-text');

    // Restore primary button
    primaryBtn.disabled = false;

    if (btnText) btnText.classList.remove('d-none');
    if (spinner) spinner.classList.add('d-none');
    if (processingText) processingText.classList.add('d-none');

    // Enable cancel button if exists
    if (cancelBtnId) {
        const cancelBtn = document.getElementById(cancelBtnId);
        if (cancelBtn) {
            cancelBtn.disabled = false;
        }
    }
}

/**
 * Reset a form by its ID
 * 
 * @param {string} formId - The ID of the form to reset
 */
const resetForm = (formId) => {
    const form = document.getElementById(formId);
    if (form) {
        form.reset();
    }
}

/** 
 * Reset multiple file input fields by their IDs
 * 
 * @param {string[]} fieldIds - Array of file input field IDs to reset
 */
const resetFileInputs = (fieldIds) => {
    if (!fieldIds || fieldIds.length === 0) return;
    fieldIds.forEach(fieldId => {
        resetFileInput(fieldId);
    });
}

/** 
 * Reset a file input field by its ID
 * 
 * @param {string} fieldId - The ID of the file input field to reset
 */
const resetFileInput = (fieldId) => {
    const fileInput = document.getElementById(fieldId);
    if (fileInput) {
        fileInput.value = '';
    }
}

/**
 * Disable a field by its ID
 * 
 * @param {string} fieldId - The ID of the field to disable
 */
const disableField = (fieldId) => {
    const field = document.getElementById(fieldId);
    if (field) {
        field.disabled = true;
    }   
}

/**
 * Enable a field by its ID
 * 
 * @param {string} fieldId - The ID of the field to enable
 */
const enableField = (fieldId) => {
    const field = document.getElementById(fieldId);
    if (field) {
        field.disabled = false;
    }
}

/**
 * Set a field as read-only
 * 
 * @param {string} fieldId - The ID of the field to set as read-only
 */
const readOnlyField = (fieldId) => {
    const field = document.getElementById(fieldId);
    if (field) {
        field.readOnly = true;
    }
}

/**
 * Set a field as editable
 * @param {string} fieldId - The ID of the field to set as editable
 */
const editableField = (fieldId) => {
    const field = document.getElementById(fieldId);
    if (field) {
        field.readOnly = false;
    }
}

/**
 * Check a fiel
 *
 * @param {string} fieldId - The ID of the field to check
 */
const checkField = (fieldId) => {
    const field = document.getElementById(fieldId);
    if (field) field.checked = true;
};

/**
 * Uncheck a field
 *
 * @param {string} fieldId - The ID of the field to uncheck
 */
const uncheckField = (fieldId) => {
    const field = document.getElementById(fieldId);
    if (field) field.checked = false;
};

/**
 * Verify if a field is checked
 *
 * @param {string} fieldId - The ID of the field to verify
 */
const isFieldChecked = (fieldId) => {
    const field = document.getElementById(fieldId);
    return field ? field.checked : false;
};

/**
 * Get value from a field (input, select, etc.)
 * 
 * @param {string} fieldId ID of the field
 * @returns {*} Value of the field
 */
const getValue = (fieldId) => {
    const field = document.getElementById(fieldId);
    if (!field) return null;
    
    if (field.tagName.toLowerCase() === 'select') {
        return field.value;
    }
    
    if (field.type === 'checkbox') {
        return field.checked;
    }

    return field.value;
}

/**
 * Set value in a field (input, select, etc.)
 * @param {string} fieldId ID of the field
 * @param {*} value Value to set
 */
const setValue = (fieldId, value) => {
    const field = document.getElementById(fieldId);
    if (!field) return;

    if (field.tagName.toLowerCase() === 'select') {
        // Para selects: si es 0 o false, convertir a string '0'
        const normalizedValue = value == null ? '' : String(value);
        setSelectValue(fieldId, normalizedValue);
    } else if (field.type === 'checkbox') {
        // Para checkboxes (si lo usas en el futuro)
        field.checked = !!value;
    } else {
        // Inputs normales (text, number, hidden)
        field.value = value == null ? '' : String(value);
    }
};

/**
 * Set values in all fields of the form
 * @param {Object} item Record data
 * @param {string[]} fieldIds List of field IDs
 */
const setValueAll = (item, fieldIds) => {
    if (!item || !fieldIds || fieldIds.length === 0) return;
    fieldIds.forEach(fieldId => {
        const value = item[fieldId];
        if (value === undefined) return;
        setValue(fieldId, value);
    });
};

/** 
 * Set text content in a field
 * 
 * @param {string} fieldId - The ID of the field
 * @param {string} value - The text content to set
 */
const setText = (fieldId, value) => {
    const field = document.getElementById(fieldId);
    if (field) {
        field.textContent = value;
    }
}

/**
 * Set HTML content in a field
 * 
 * @param {string} elementId - The ID of the element
 * @param {string} htmlContent - The HTML content to set
 */
const setHTML = (elementId, htmlContent) => {
    const element = document.getElementById(elementId);
    if (element) {
        element.innerHTML = htmlContent;
    }
}

/**
 * Set HTML content to specific element
 *
 * @param {HTMLElement} element - The element to set HTML content
 * @param {string} htmlContent - The HTML content to set
 */
const setElementHTML = (element, htmlContent) => {
    if (element) {
        element.innerHTML = htmlContent;
    }
}

/**
 * Clear HTML content in a field
 *
 * @param {string} elementId - The ID of the element
 */
const clearHTML = (elementId) => {
    const element = document.getElementById(elementId);
    if (element) {
        element.innerHTML = '';
    }
}

/**
 * Clear HTML content of specific element
 *
 * @param {HTMLElement} element - The element to clear
 */
const clearElementHTML = (element) => {
    if (element) {
        element.innerHTML = '';
    }
}

/**
 * Check if a field has a value
 * 
 * @param {string} fieldId - The ID of the field
 * @returns {boolean} - True if the field has a value, false otherwise
 */
const hasValue = (fieldId) => {
    const field = document.getElementById(fieldId);
    if (!field) return false;
    
    if (field.tagName.toLowerCase() === 'select') {
        return field.value !== '';
    }
    
    if (field.type === 'checkbox') {
        return field.checked;
    }

    return field.value.trim() !== '';
}

/**
 * Verify if two fields have matching values
 * 
 * @param {string} fieldId1 - First field ID
 * @param {string} fieldId2 - Second field ID
 * @returns {boolean} - True if values match, false otherwise
 */
const verifyFieldMatch = (fieldId1, fieldId2) => {
    const field1 = document.getElementById(fieldId1);
    const field2 = document.getElementById(fieldId2);
    if (!field1 || !field2) return false;    
    return field1.value === field2.value;
}

/**
 * Show an element (remove 'd-none' class)
 * 
 * @param {string} fieldId  - The ID of the field
 */
const showElement = (fieldId) => {
    removeClass(fieldId, 'd-none');
}

/**
 * Hide an element (add 'd-none' class)
 * 
 * @param {string} fieldId - The ID of the field
 */
const hideElement = (fieldId) => {
    addClass(fieldId, 'd-none');
}

/** 
 * Add a class to a field
 * 
 * @param {string} fieldId - The ID of the field
 * @param {string} className - The class name to add
 */
const addClass = (fieldId, className) => {
    const field = document.getElementById(fieldId);
    if (field) {
        field.classList.add(className);
    }
}

/** 
 * Add multiple classes to a field
 *
 * @param {string} fieldId - The ID of the field
 * @param {string[]} classes - Array of class names to add
 */
const addClasses = (fieldId, classes) => {
    if (!classes || classes.length === 0) return;
    classes.forEach(className => addClass(fieldId, className));
}

/** 
 * Remove a class from a field
 *
 * @param {string} fieldId - The ID of the field
 * @param {string} className - The class name to remove
 */
const removeClass = (fieldId, className) => {
    const field = document.getElementById(fieldId);
    if (field) {
        field.classList.remove(className);
    }
}

/** 
 * Remove multiple classes from a field
 * 
 * @param {string} fieldId - The ID of the field
 * @param {string[]} classes - Array of class names to remove
 */
const removeClasses = (fieldId, classes) => {
    if (!classes || classes.length === 0) return;
    classes.forEach(className => removeClass(fieldId, className));
}

/**
 * Delete an element by its ID
 * 
 * @param {string} elementId - The ID of the element to delete
 */
const deleteElement = (elementId) => {
    const element = document.getElementById(elementId);
    if (element) {
        element.remove();
    }
}

/**
 * Fill select options dynamically
 * 
 * @param {string} selectId - The ID of the select element
 * @param {Array} options - Array of option objects with 'code'/'id' and 'name' properties
 * @param {string} placeholder - Placeholder text for the default option
 */
const fillSelectOptions = (selectId, options, placeholder = '-- Seleccione --') => {
    const select = document.getElementById(selectId);
    if (select) {
        select.innerHTML = `<option value="">${placeholder}</option>`;
        options.forEach(opt => {
            const option = document.createElement('option');
            if (opt.code) {
                option.value = opt.code;
            } else if (opt.id) {
                option.id = opt.id;
                option.value = opt.id;
            }

            if (opt.name) {
                option.textContent = opt.name;
            } else if (opt.text) {
                option.textContent = opt.text;
            }

            select.appendChild(option);
        });
    }
}

/**
 * Clear select options and set to placeholder only
 * 
 * @param {string} selectId - The ID of the select element
 * @param {string} placeholder - Placeholder text for the default option
 */
const clearSelectOptions = (selectId, placeholder = '-- Seleccione --') => {
    const select = document.getElementById(selectId);
    if (select) {
        select.innerHTML = `<option value="">${placeholder}</option>`;
    }
}

/**
 * Set a single option in a select (clears existing options)
 * 
 * @param {string} selectId - The ID of the select element
 * @param {string} value - The value of the option to set
 * @param {string} text - The display text of the option
 */
const setSelectOption = (selectId, value, text) => {
    const select = document.getElementById(selectId);
    if (select) {
        select.innerHTML = '';
        const option = document.createElement('option');
        option.value = value;
        option.textContent = text;
        select.appendChild(option);
    }
}

/**
 * Set value in a select
 * @param {string} selectId ID of the select
 * @param {string} value Normalized value
 */
const setSelectValue = (selectId, value) => {
    const select = document.getElementById(selectId);
    if (!select) return;

    // If value is '', select the empty or default option
    if (value === '') {
        select.value = '';
        return;
    }

    // Check if the option exists
    const optionExists = Array.from(select.options).some(option => option.value === value);

    if (optionExists) {
        select.value = value;
    } else {
        console.warn(`Value '${value}' does not exist as an option in select #${selectId}`);
        select.value = ''; // Fallback to empty
    }
};

/**
 * Delete an option from a select by its value
 * 
 * @param {string} selectId - The ID of the select element
 * @param {string} value - The value of the option to delete
 */
const deleteSelectOption = (selectId, value) => {
    const select = document.getElementById(selectId);
    if (!select) return;

    const option = select.querySelector(`option[value="${value}"]`);
    if (option) {
        option.remove();
    } else {
        console.warn(`Option with value '${value}' not found in select #${selectId}`);
    }
}

/**
 * Checks if an array is empty
 *
 * @param {Array} arr - The array to check
 * @returns {boolean} - Returns true if the array is empty, false otherwise
 */
const isEmpty = (arr) => arr.length === 0;