'use strict';

const FORM_ID = 'contactForm';
const AJAX_URL = '../../app/ajax/web/contact.php';

/**
 * Send a contact message
 */
const sendMessage = () => {
	const form = document.getElementById(FORM_ID);
	if (!form) return;

	if (!validateForm(FORM_ID)) return;

	lockButtons('sendBtn');

	try {
		// Get reCAPTCHA token
		const recaptchaToken = getRecaptchaToken();
		if (!recaptchaToken) {
			recaptchaInvalid('recaptcha-container', 'Por favor completa el reCAPTCHA');
			unlockButtons('sendBtn');
			return;
		}

		const formData = new FormData(form);
		formData.append('action', 'send_message');
		formData.append('recaptcha_token', recaptchaToken);

		setTimeout(() => {
			axios.post(AJAX_URL, formData)
				.then(response => {
					if (response.data.success) {
						iziToastSuccess({message: response.data.message});
						resetForm(FORM_ID);
					} else {
						evaluateErrors(response.data, FORM_ID);
					}
				})
				.catch(error => {
					console.log('[ERROR] Error al enviar el formulario de contacto:', error);
					iziToastError({message: 'Error de conexión al enviar el formulario de contacto'});
				})
				.finally(() => {
					if (typeof grecaptcha !== 'undefined') {
						grecaptcha.reset();
					}
					unlockButtons('sendBtn');
				});
		}, 300);
	} catch (error) {
		console.error('[ERROR] Error en sendMessage:', error);
		iziToastError({message: 'Error procesando el formulario'});
		unlockButtons('sendBtn');
	}
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

document.addEventListener('DOMContentLoaded', function () {
	setNavActive('header-nav-contact-us');

	// Save button in modal
	const sendBtn = document.getElementById('sendBtn');
	if (sendBtn) {
		sendBtn.addEventListener('click', sendMessage);
	}
});