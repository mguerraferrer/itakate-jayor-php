'use strict';

const FORM_ID = 'checkoutForm';
const CHECKOUT_AJAX_URL = `${rootPath}app/ajax/web/quotation-checkout.php`;

const checkout = () => {
    try {
        const form = document.getElementById(FORM_ID);
        if (!form) return;

        const products = getProducts(form);
        if (isEmpty(products)) return;
        if (!validateForm(FORM_ID)) return;

        lockButtons('checkoutBtn');

        const formData = new FormData(form);
        formData.append('action', 'checkout');
        // Add products as JSON string to FormData
        formData.append('products', JSON.stringify(products));

        setTimeout(() => {
            axios.post(CHECKOUT_AJAX_URL, formData)
                .then(response => {
                    if (response.data.success) {
                        const folio = response.data.folio;
                        // Redirect to success page
                        window.location.href = `${viewsPath}quotation-resume?f=${folio}`;
                    } else {
                        evaluateErrors(response.data, FORM_ID);
                    }
                })
                .catch(error => {
                    console.log('[ERROR] Error al enviar el formulario de cotización:', error);
                    iziToastError({message: 'Error de conexión al enviar la cotización'});
                })
                .finally(() => {
                    unlockButtons('checkoutBtn');
                });
        }, 300);
    } catch (error) {
        console.error('[ERROR] Error en checkout:', error);
        iziToastError({message: 'Error procesando el formulario'});
        unlockButtons('checkoutBtn');
    }
}

const getProducts = (form) => {
    // Collect all products from the form
    // Products are in format: items[index][id] and items[index][quantity]
    const productInputs = form.querySelectorAll('input[name^="items["][name$="][id]"]');
    const products = [];

    productInputs.forEach((input) => {
        const productId = input.value;
        const index = input.name.match(/\[(\d+)\]/)[1];
        const quantityInput = form.querySelector(`input[name="items[${index}][quantity]"]`);
        const quantity = quantityInput ? parseInt(quantityInput.value) || 0 : 0;

        if (productId && quantity > 0) {
            products.push({
                id: productId,
                quantity: quantity
            });
        } else {
            iziToastError({message: 'Debe indicar una cantidad válida para todos los productos en el cotizador'});
            return [];
        }
    });

    return products;
}

document.addEventListener('DOMContentLoaded', function () {
    // Save button in modal
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', checkout);
    }
});