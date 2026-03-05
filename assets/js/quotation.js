'use strict';

const rootPath = window.rootPath || '';
const viewsPath = window.viewsPath || '';
const QUOTATION_AJAX_URL = `${rootPath}app/ajax/web/quotation.php`;
const productRemoved = "Producto eliminado de la cotización";
const productAdded = "Producto agregado a la cotización";

document.addEventListener('DOMContentLoaded', () => {
    loadQuotation();
});

const loadQuotation = () => {
    axios.get(QUOTATION_AJAX_URL, {
        params: {action: 'get'}
    })
    .then(response => {
        if (response.data.success) {
            const items = response.data.items;
            updateQuotationBadge(items.length);
            updateModalMiniCart(items, items.length);
        }
    })
    .catch(error => {
        console.log('[ERROR] Error en loadQuotation:', error);
        iziToastError({message: 'Error de conexión. Por favor intenta de nuevo más tarde'});
    });
}

document.addEventListener('click', (e) => {
    let productId = null;
    if (e.target.closest('.add-to-quotation')) {
        e.preventDefault();
        const button = e.target.closest('.add-to-quotation');
        productId = button.getAttribute('data-product-id');
        addToQuotation(productId);
    } else if (e.target.closest('.remove-from-quotation')) {
        e.preventDefault();
        const button = e.target.closest('.remove-from-quotation');
        productId = button.getAttribute('data-product-id');
        removeFromQuotation(productId);
    } else if (e.target.closest('.remove-from-modal')) {
        e.preventDefault();
        const button = e.target.closest('.remove-from-modal');
        productId = button.getAttribute('data-product-id');
        removeFromQuotation(productId);
    } else if (e.target.closest('.remove-from-checkout')) {
        e.preventDefault();
        const button = e.target.closest('.remove-from-checkout');
        productId = button.getAttribute('data-product-id');
        const containerId = button.getAttribute('data-container');
        removeFromCheckout(productId, containerId);
    }
});

const addToQuotation = (productId) => {
    const formData = new FormData();
    formData.append('action', 'add');
    formData.append('productId', productId);

    axios.post(QUOTATION_AJAX_URL, formData)
        .then(response => {
            if (response.data.success) {
                const items = response.data.items;
                updateAfterAddOrRemove(items, productId, true, productAdded);
            } else {
                iziToastError({message: 'Producto no encontrado'});
            }
        })
        .catch(error => {
            console.error('Error adding product:', error);
            iziToastError({message: 'Error de conexión al agregar el producto del cotizador'});
        });
}

const removeFromQuotation = (productId) => {
    const formData = new FormData();
    formData.append('action', 'remove');
    formData.append('productId', productId);

    axios.post(QUOTATION_AJAX_URL, formData)
        .then(response => {
            if (response.data.success) {
                const items = response.data.items;
                updateAfterAddOrRemove(items, productId, false, productRemoved);
            } else {
                iziToastError({message: 'Error al eliminar el producto del cotizador'});
            }
        })
        .catch(error => {
            console.error('Error removing product:', error);
            iziToastError({message: 'Error de conexión al eliminar el producto'});
        });
}

const removeFromCheckout = (productId, containerId) => {
    const formData = new FormData();
    formData.append('action', 'remove');
    formData.append('productId', productId);

    axios.post(QUOTATION_AJAX_URL, formData)
        .then(response => {
            if (response.data.success) {
                const items = response.data.items;
                updateAfterAddOrRemove(items, productId, false, productRemoved);

                if (containerId) {
                    const container = document.getElementById(containerId);
                    if (container) {
                        container.remove();
                    }
                }

                if (items.length <= 0) {
                    const quotationSidebarBtn = document.querySelector('.quotation-sidebar .btn-jy-outline-primary');
                    if (quotationSidebarBtn) {
                        quotationSidebarBtn.classList.add('disabled');
                        quotationSidebarBtn.removeAttribute('href');
                    }

                    const cartItems = document.querySelector('.cart-items');
                    if (cartItems) {
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-light';
                        alert.setAttribute('role', 'alert');
                        alert.textContent = 'Debe seleccionar al menos un producto para poder continuar con la cotización';
                        cartItems.appendChild(alert);
                    }
                }
            } else {
                iziToastError({message: 'Error al eliminar el producto'});
            }
        })
        .catch(error => {
            console.error('Error removing product:', error);
            iziToastError({message: 'Error de conexión al eliminar el producto'});
        });
}

const updateAfterAddOrRemove = (items, productId, isInQuotation, message) => {
    updateQuotationBadge(items.length);
    updateProductButtons(productId, isInQuotation);
    updateModalMiniCart(items, items.length);
    iziToastSuccess({message: message});
}

/**
 * Actualizar el badge de cotización con el contador
 */
const updateQuotationBadge = (count) => {
    const badges = document.querySelectorAll('.quotation-badge');
    badges.forEach(badge => {
        badge.setAttribute('data-cart-items', count);
    });

    // Actualizar el contador visual
    const cartCounter = document.getElementById('cart-counter');
    if (cartCounter) {
        const counterSpan = cartCounter.querySelector('span');
        if (counterSpan) {
            counterSpan.textContent = count;
        }

        // Mostrar/ocultar el badge según la cantidad
        if (count > 0) {
            cartCounter.style.display = 'block';
        } else {
            cartCounter.style.display = 'none';
        }
    }
}

/**
 * Actualizar el mini carrito modal con los items
 */
const updateModalMiniCart = (items, count) => {
    const listElement = document.getElementById('quotation-items-list');
    if (!listElement) return;

    if (count > 0) {
        listElement.innerHTML = '';
        items.forEach(item => {
            const itemData = item.item || item.product || item;
            const imgSrc = `${rootPath}${itemData.img}`;

            const li = document.createElement('li');
            li.className = 'py-2 quotation-item';
            li.setAttribute('data-product-id', itemData.id);
            li.innerHTML = `
                    <div class="row align-items-center">
                        <div class="col-4">
                            <a href="#">
                                <img src="${imgSrc}" class="img-fluid border" alt="${itemData.sku}" />
                            </a>
                        </div>
                        <div class="col-8">
                            <p class="mb-1">
                                <a class="text-mode fw-500" href="#">
                                    ${itemData.sku}
                                </a>
                                <span class="m-0 text-muted w-100 d-block fs-80">
                                    ${itemData.details || ''}
                                </span>
                            </p>
                            <div class="d-flex align-items-center">
                                <a class="small text-danger fw-700 p-1 remove-from-modal" href="javascript:void(0)" data-product-id="${itemData.id}">
                                    Eliminar
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            listElement.appendChild(li);
        });

        const quotationButtons = document.querySelectorAll('.offcanvas-footer .btn-jy-outline-primary');
        quotationButtons.forEach(btn => {
            btn.classList.remove('disabled');
            btn.setAttribute('href', `${viewsPath}quotation`);
        });
    } else {
        listElement.innerHTML = `
            <li class="text-center py-4">
                <p class="text-muted">Todavía no has seleccionado ningún producto</p>
            </li>
        `;

        const quotationButtons = document.querySelectorAll('.offcanvas-footer .btn-jy-outline-primary');
        quotationButtons.forEach(btn => {
            btn.classList.add('disabled');
            btn.removeAttribute('href');
        });
    }
}

/**
 * Actualizar botones de producto (agregar/eliminar del cotizador)
 */
const updateProductButtons = (productId, isInQuotation) => {
    const button = document.querySelector(`.btn-quotation[data-product-id="${productId}"]`);
    if (!button) return;

    const newButton = document.createElement('a');
    newButton.href = 'javascript:void(0)';
    newButton.className = 'btn btn-sm w-100 btn-quotation';
    newButton.setAttribute('data-product-id', productId);

    if (isInQuotation) {
        console.log("updateProductButtons - isInQuotation true");
        newButton.classList.add('btn-primary', 'remove-from-quotation');
        newButton.textContent = 'Eliminar del cotizador';
    } else {
        console.log("updateProductButtons - isInQuotation false");
        newButton.classList.add('btn-jy-primary', 'add-to-quotation');
        newButton.textContent = 'Agregar al cotizador';
    }

    button.replaceWith(newButton);
}