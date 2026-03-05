'use strict';

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPharmacoVigilance);
} else {
    initPharmacoVigilance();
}

function initPharmacoVigilance() {
    const validateStepRequest = LAYOUT_SERVER_CONTEXT + "pharmaco-vigilance/validate-step";

    // Field IDs to attach keyup/change handlers for validation reset
    const fieldIds = [
        'name', 'plName', 'mlName', 'phone', 'email', 'personType',
        'product', 'duedate', 'lote', 'genericName', 'dose', 'admWay', 
        'brand', 'healthRegister', 'sdate', 'edate', 'reasonUse', 'otherDrug',
        'eventHappened', 'eventStartDate', 'eventEndDate', 'eventType',
        'patName', 'patPlName', 'patMlName', 'gender', 'birthDate', 'height', 'weight'
    ];

    // Attach keyup and change handlers to reset validation state
    fieldIds.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('keyup', function() {
                elementFieldClassReset(this.id);
            });
            element.addEventListener('change', function() {
                elementFieldClassReset(this.id);
            });
        }
    });

    // Special handler for phone field (numeric only, max 10 digits)
    const phoneField = document.getElementById('phone');
    if (phoneField) {
        phoneField.addEventListener('keypress', function(e) {
            elementFieldClassReset(this.id);
            let l = getElementLength(this.id);
            if (l < 10) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    e.preventDefault();
                    return false;
                }
                return true;
            }
            e.preventDefault();
            return false;
        });
    }

    // Special handler for gender field (disable pregnancy options if male)
    const genderField = document.getElementById('gender');
    if (genderField) {
        genderField.addEventListener('change', function() {
            let gender = val(this.id);
            const pregnancyYes = document.getElementById('pregnancyYes');
            const pregnancyNo = document.getElementById('pregnancyNo');
            
            if (gender === 'male') {
                if (pregnancyYes) pregnancyYes.disabled = true;
                if (pregnancyNo) pregnancyNo.disabled = true;
            } else {
                if (pregnancyYes) pregnancyYes.disabled = false;
                if (pregnancyNo) pregnancyNo.disabled = false;
            }
        });
    }

    // Initialize datepickers (still uses jQuery plugin)
    const datepickerConfig = {
        language: 'es-MX',
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    };

    const datepickerConfigPast = {
        ...datepickerConfig,
        endDate: new Date()
    };

    // Initialize each datepicker
    if (typeof jQuery !== 'undefined' && jQuery.fn.datepicker) {
        ['duedate', 'sdate', 'edate'].forEach(id => {
            const elem = document.getElementById(id);
            if (elem) {
                jQuery(elem).datepicker('destroy').datepicker(datepickerConfig);
            }
        });

        ['eventStartDate', 'eventEndDate', 'birthDate'].forEach(id => {
            const elem = document.getElementById(id);
            if (elem) {
                jQuery(elem).datepicker('destroy').datepicker(datepickerConfigPast);
            }
        });
    }

    // Radio button mutual exclusion handlers
    const radioGroups = [
        ['productuseyes', 'productuseno'],
        ['eventUseYes', 'eventUseNo'],
        ['pregnancyYes', 'pregnancyNo'],
        ['doctorprescribeyes', 'doctorprescribeno']
    ];

    radioGroups.forEach(group => {
        const [id1, id2] = group;
        const elem1 = document.getElementById(id1);
        const elem2 = document.getElementById(id2);

        if (elem1) {
            elem1.addEventListener('click', function() {
                if (isElementChecked(this.id)) {
                    elementUnchecked(id2);
                }
            });
        }

        if (elem2) {
            elem2.addEventListener('click', function() {
                if (isElementChecked(this.id)) {
                    elementUnchecked(id1);
                }
            });
        }
    });

    // Prevent clicking disabled step tabs
    document.addEventListener('click', function(e) {
        const stepTab = e.target.closest('.step-tab');
        if (stepTab && stepTab.classList.contains('disabled')) {
            e.preventDefault();
            return false;
        }
    });

    // Helper functions
    function enableTab(step) {
        const tab = document.querySelector('.step-tab[data-step="' + step + '"]');
        if (tab) {
            tab.classList.remove('disabled');
            tab.setAttribute('aria-disabled', 'false');
            tab.removeAttribute('tabindex');
        }
    }

    function disableTab(step) {
        const tab = document.querySelector('.step-tab[data-step="' + step + '"]');
        if (tab) {
            tab.classList.add('disabled');
            tab.setAttribute('aria-disabled', 'true');
            tab.setAttribute('tabindex', '-1');
        }
    }

    function showTab(step) {
        const tab = document.querySelector('.step-tab[data-step="' + step + '"]');
        if (!tab) return;
        if (typeof bootstrap !== 'undefined') {
            const bsTab = new bootstrap.Tab(tab);
            bsTab.show();
        }
    }

    // Prev handler (no validation, preserve data)
    function handlePrev(prevStep, currentStep) {
        enableTab(prevStep);
        disableTab(currentStep);
        showTab(prevStep);
    }

    // Bind Next buttons
    const btnNext1 = document.getElementById('btn-next-1');
    const btnNext2 = document.getElementById('btn-next-2');
    const btnNext3 = document.getElementById('btn-next-3');
    const btnNext4 = document.getElementById('btn-next-4');

    if (btnNext1) btnNext1.addEventListener('click', () => handleNext(1, 2));
    if (btnNext2) btnNext2.addEventListener('click', () => handleNext(2, 3));
    if (btnNext3) btnNext3.addEventListener('click', () => handleNext(3, 4));
    if (btnNext4) btnNext4.addEventListener('click', () => handleFinalSubmit(4));

    // Bind Prev buttons
    const btnPrev2 = document.getElementById('btn-prev-2');
    const btnPrev3 = document.getElementById('btn-prev-3');
    const btnPrev4 = document.getElementById('btn-prev-4');

    if (btnPrev2) btnPrev2.addEventListener('click', () => handlePrev(1, 2));
    if (btnPrev3) btnPrev3.addEventListener('click', () => handlePrev(2, 3));
    if (btnPrev4) btnPrev4.addEventListener('click', () => handlePrev(3, 4));

    // Generic next button handler (validates via axios then enable next)
    async function handleNext(currentStep, nextStep) {
        try {
            const form = document.getElementById('pharmaco-vigilance-form');
            const formData = new FormData(form);
            formData.append('step', currentStep);

            const resp = await axios.post(validateStepRequest, formData);
            if (resp?.data?.valid) {
                enableTab(nextStep);
                disableTab(currentStep);
                showTab(nextStep);
            } else if (resp.data?.errors) {
                renderValidationErrors(resp.data.errors);
            } else {
                const message = (resp.data?.message) ? resp.data.message : 'Validation failed for current step';
                console.log(message);
                showToastrError();
            }
        } catch (error) {
            const message = (error.response?.data?.message) ? error.response.data.message : 'Server error validating step';
            console.log(message);
            showToastrError();
        }
    }

    async function handleFinalSubmit(currentStep) {
        try {
            // Validate reCAPTCHA on client
            if (typeof grecaptcha !== 'undefined') {
                let respCaptcha = grecaptcha.getResponse();
                if (!respCaptcha || respCaptcha.length === 0) {
                    setText('small-hrecaptcha', 'Por favor verifica que no eres un robot');
                    return;
                } else {
                    textClear('small-hrecaptcha');
                }
            }

            lockButtons('btn-next-4', 'btn-prev-4');

            const form = document.getElementById('pharmaco-vigilance-form');
            const formData = new FormData(form);
            formData.append('step', currentStep);

            const resp = await axios.post(validateStepRequest, formData);
            if (!resp?.data) {
                showToastrError();
                unlockButtons('btn-next-4', 'btn-prev-4');
                return;
            }

            const data = resp.data;
            if (data.valid !== true) {
                renderValidationErrors(data.errors || null);
                unlockButtons('btn-next-4', 'btn-prev-4');
                return;
            }

            // Valid step. Check mail sent.
            if (data.mailSent === true) {
                showThanksModal();
                resetFormAndStepper();
            } else {
                showToastrError();
            }

            unlockButtons('btn-next-4', 'btn-prev-4');
        } catch (e) {
            console.error('Error:', e);
            showToastrError();
            unlockButtons('btn-next-4', 'btn-prev-4');
        }
    }

    // Display validation errors
    function renderValidationErrors(errors) {
        if (errors && typeof errors === 'object') {
            Object.keys(errors).forEach(function(field) {
                const msg = errors[field];
                const small = document.getElementById('small-' + field);
                if (small) {
                    small.textContent = msg;
                    small.style.display = 'block';
                    small.classList.add('invalid-feedback');
                }
                
                const divField = document.getElementById('div-' + field);
                if (divField) {
                    const inputs = divField.querySelectorAll('input, textarea, select');
                    inputs.forEach(input => input.classList.add('is-invalid'));
                }
            });
        }
    }

    // Show thank you modal
    function showThanksModal() {
        const modalEl = document.getElementById('pharmaco-vigilance-modal');
        if (!modalEl) return;
        if (typeof bootstrap !== 'undefined') {
            const pharmaModal = new bootstrap.Modal(modalEl);
            pharmaModal.show();
        }
    }

    // Reset all form fields, validation states, reCAPTCHA and stepper to step 1
    function resetFormAndStepper() {
        const form = document.getElementById('pharmaco-vigilance-form');
        if (form) {
            form.reset();
        }

        // Clear invalid classes and messages
        const invalidElements = document.querySelectorAll('#pharmaco-vigilance-form .is-invalid');
        invalidElements.forEach(el => el.classList.remove('is-invalid'));

        const smallElements = document.querySelectorAll('#pharmaco-vigilance-form small[id^="small-"]');
        smallElements.forEach(el => {
            el.textContent = '';
            el.style.display = 'none';
        });

        // Clear date inputs
        ['duedate', 'sdate', 'edate', 'eventStartDate', 'eventEndDate', 'birthDate', 'bdate'].forEach(id => {
            const elem = document.getElementById(id);
            if (elem) elem.value = '';
        });

        // Reset reCAPTCHA
        if (typeof grecaptcha !== 'undefined') {
            grecaptcha.reset();
        }
        textClear('small-hrecaptcha');

        // Reset tabs: activate step 1 and disable 2-4
        enableTab(1);
        disableTab(2);
        disableTab(3);
        disableTab(4);
        showTab(1);
    }

    // Toastr helper
    function showToastrError() {
        const errorMessage = 'No se ha podido enviar el reporte. Por favor, intenta más tarde';
        const toast = document.createElement('div');
        toast.className = 'alert alert-danger alert-dismissible fade show toastr-container fs-80';
        toast.setAttribute('role', 'alert');
        toast.innerHTML = errorMessage + 
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        document.body.appendChild(toast);
        setTimeout(function() {
            toast.remove();
        }, 3000);
    }

    // reCAPTCHA callbacks (must be global)
    window.onReCaptchaSuccess = function(response) {
        textClear('small-hrecaptcha');
    };

    window.onReCaptchaExpired = function(response) {
        if (typeof validationError === 'function' && typeof reCaptchaExpired !== 'undefined') {
            validationError('hrecaptcha', reCaptchaExpired);
        }
        if (typeof grecaptcha !== 'undefined') {
            grecaptcha.reset();
        }
    };
}
