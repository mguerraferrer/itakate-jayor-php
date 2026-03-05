'use strict';

const FORM_ID = 'pharmacoVigilanceForm';
const AJAX_URL = '../../app/ajax/web/pharma.php';

// Datepicker for dueDate field
const dueDate = document.getElementById('dueDate');
const dueDateDatepicker = new Datepicker(dueDate, {
    buttonClass: 'btn',
    language: 'es',
    todayHighlight: true,
    autohide: true,
    clearButton: true
});

// Datepicker for startDate field
const startDate = document.getElementById('startDate');
const startDateDatepicker = new Datepicker(startDate, {
    buttonClass: 'btn',
    language: 'es',
    todayHighlight: true,
    autohide: true,
    clearButton: true,
    maxDate: new Date()
});

// Datepicker for endDate field
const endDate = document.getElementById('endDate');
const endDateDatepicker = new Datepicker(endDate, {
    buttonClass: 'btn',
    language: 'es',
    todayHighlight: true,
    autohide: true,
    clearButton: true,
    maxDate: new Date()
});

// Datepicker for eventStartDate field
const eventStartDate = document.getElementById('eventStartDate');
const eventStartDateDatepicker = new Datepicker(eventStartDate, {
    buttonClass: 'btn',
    language: 'es',
    todayHighlight: true,
    autohide: true,
    clearButton: true,
    maxDate: new Date()
});

// Datepicker for eventEndDate field
const eventEndDate = document.getElementById('eventEndDate');
const eventEndDateDatepicker = new Datepicker(eventEndDate, {
    buttonClass: 'btn',
    language: 'es',
    todayHighlight: true,
    autohide: true,
    clearButton: true,
    maxDate: new Date()
});

// Datepicker for birthDate field
const birthDate = document.getElementById('birthDate');
const birthDateDatepicker = new Datepicker(birthDate, {
    buttonClass: 'btn',
    language: 'es',
    todayHighlight: true,
    autohide: true,
    clearButton: true,
    maxDate: new Date()
});

document.addEventListener('DOMContentLoaded', function () {
    setNavActive('header-nav-pharmaco-vigilance');

    // Special handler for gender field (disable pregnancy options if male)
    const genderSelect = document.getElementById('gender');
    if (genderSelect) {
        genderSelect.addEventListener('change', () => {
            uncheckField('pregnancyYes');
            uncheckField('pregnancyNo');

            const gender = genderSelect.value || '';
            if (gender !== '' && gender === 'female') {
                enableField('pregnancyYes');
                enableField('pregnancyNo');
            } else {
                disableField('pregnancyYes');
                disableField('pregnancyNo');
            }
        });
    }

    // Radio button mutual exclusion handlers
    const radioGroups = [
        ['productUseYes', 'productUseNo'],
        ['eventUseYes', 'eventUseNo'],
        ['pregnancyYes', 'pregnancyNo'],
        ['doctorPrescribeYes', 'doctorPrescribeNo']
    ];
    radioGroups.forEach(group => {
        const [id1, id2] = group;
        const elem1 = document.getElementById(id1);
        const elem2 = document.getElementById(id2);

        if (elem1) {
            elem1.addEventListener('click', () => {
                if (isFieldChecked(id1)) {
                    uncheckField(id2);
                }
            });
        }

        if (elem2) {
            elem2.addEventListener('click', () => {
                if (isFieldChecked(id2)) {
                    uncheckField(id1);
                }
            });
        }
    });

    // Bind Next buttons
    const btnNext1 = document.getElementById('btn-next-1');
    if (btnNext1) btnNext1.addEventListener('click', () => handleNext(1, 2));

    const btnNext2 = document.getElementById('btn-next-2');
    if (btnNext2) btnNext2.addEventListener('click', () => handleNext(2, 3));

    const btnNext3 = document.getElementById('btn-next-3');
    if (btnNext3) btnNext3.addEventListener('click', () => handleNext(3, 4));

    const btnNext4 = document.getElementById('btn-next-4');
    if (btnNext4) btnNext4.addEventListener('click', () => handleNext(4));

    // Bind Prev buttons
    const btnPrev2 = document.getElementById('btn-prev-2');
    if (btnPrev2) btnPrev2.addEventListener('click', () => handlePrev(1, 2));

    const btnPrev3 = document.getElementById('btn-prev-3');
    if (btnPrev3) btnPrev3.addEventListener('click', () => handlePrev(2, 3));

    const btnPrev4 = document.getElementById('btn-prev-4');
    if (btnPrev4) btnPrev4.addEventListener('click', () => handlePrev(3, 4));
});

// Prevent clicking disabled step tabs
document.addEventListener('click', function(e) {
    const stepTab = e.target.closest('.step-tab');
    if (stepTab && stepTab.classList.contains('disabled')) {
        e.preventDefault();
        return false;
    }
});

const enableTab = (step) => {
    const tab = document.querySelector('.step-tab[data-step="' + step + '"]');
    if (tab) {
        tab.classList.remove('disabled');
        tab.setAttribute('aria-disabled', 'false');
        tab.removeAttribute('tabindex');
    }
}

const disableTab = (step) => {
    const tab = document.querySelector('.step-tab[data-step="' + step + '"]');
    if (tab) {
        tab.classList.add('disabled');
        tab.setAttribute('aria-disabled', 'true');
        tab.setAttribute('tabindex', '-1');
    }
}

const showTab = (step) => {
    const tab = document.querySelector('.step-tab[data-step="' + step + '"]');
    if (!tab) return;
    if (typeof bootstrap !== 'undefined') {
        const bsTab = new bootstrap.Tab(tab);
        bsTab.show();
    }
}

// Prev handler (no validation, preserve data)
const handlePrev = (prevStep, currentStep) => {
    enableTab(prevStep);
    disableTab(currentStep);
    showTab(prevStep);
}

// Generic next button handler (validates via axios then enable next)
 const handleNext = (currentStep, nextStep) => {
    try {
        const form = document.getElementById(FORM_ID);
        if (!form) return;

        const fieldIds = getRequiredFieldsByStep(currentStep);
        if (!validateRequiredFields(form, fieldIds)) return;

        if (currentStep === 4) {
            // Get reCAPTCHA token
            const recaptchaToken = getRecaptchaToken();
            if (!recaptchaToken) {
                recaptchaInvalid('recaptcha-container', 'Por favor completa el reCAPTCHA');
                unlockButtons('sendBtn');
                return;
            }
            lockButtons('btn-next-4', 'btn-prev-4');
        }

        const formData = new FormData(form);
        formData.append('action', 'validate_step');
        formData.append('step', currentStep);
        appendBooleanFields(formData);

        setTimeout(() => {
            axios.post(AJAX_URL, formData)
                .then(response => {
                    if (response.data.success) {
                        if (currentStep !== 4) {
                            enableTab(nextStep);
                            disableTab(currentStep);
                            showTab(nextStep);
                        } else if (response.data.mailSent) {
                            showThanksModal();
                            resetFormAndStepper();
                        }
                    } else {
                        evaluateErrors(response.data, FORM_ID);
                    }
                })
                .catch(error => {
                    console.log('[ERROR] Error procesando la información:', error);
                    iziToastError({message: 'Error inesperado validando la información'});
                })
                .finally(() => {
                    if (typeof grecaptcha !== 'undefined') {
                        grecaptcha.reset();
                    }
                    unlockButtons('btn-next-4', 'btn-prev-4');
                });
        }, 300);
    } catch (error) {
        const message = (error.response?.data?.message) ? error.response.data.message : 'Server error validating step';
        console.log(message);
        iziToastError({message: 'No se ha podido enviar el reporte. Por favor, intenta más tarde'});
    }
}

const getRequiredFieldsByStep = (step) => {
    let fieldIds = [];
    if (step === 1) {
        fieldIds = ['name', 'plName', 'mlName', 'phone', 'email', 'personType'];
    } else if (step === 2) {
        fieldIds = ['product', 'lote'];
    } else if (step === 3) {
        fieldIds = ['eventHappened'];
    } else if (step === 4) {
        fieldIds = ['patName', 'patPlName'];
    }
    return fieldIds;
}

const appendBooleanFields = (formData) => {
    const boolIds = [
        'productUseYes', 'productUseNo',
        'eventUseYes', 'eventUseNo',
        'pregnancyYes', 'pregnancyNo',
        'doctorPrescribeYes', 'doctorPrescribeNo'
    ];

    boolIds.forEach((id) => {
        const el = document.getElementById(id);
        formData.set(id, el && el.checked ? '1' : '0');
    });
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
    resetForm(FORM_ID);

    // Clear datepicker
    dueDateDatepicker.setDate({clear: true});
    startDateDatepicker.setDate({clear: true});
    endDateDatepicker.setDate({clear: true});
    eventStartDateDatepicker.setDate({clear: true});
    eventEndDateDatepicker.setDate({clear: true});
    birthDateDatepicker.setDate({clear: true});

    // Reset tabs: activate step 1 and disable 2-4
    enableTab(1);
    disableTab(2);
    disableTab(3);
    disableTab(4);
    showTab(1);
}

/**
 * Get reCAPTCHA v2 response token
 */
const getRecaptchaToken = () => {
    if (typeof grecaptcha === 'undefined') {
        return '';
    }

    try {
        return grecaptcha.getResponse();
    } catch (error) {
        console.error('[ERROR] Error obtaining reCAPTCHA token:', error);
        return '';
    }
};

/**
 * reCAPTCHA v2 callback
 */
window.onRecaptchaSuccess = () => {
    clearRecaptchaError('recaptcha-container');
};