'use strict';
const AJAX_URL = '../../app/ajax/admin/dashboard_quotation.php';
const USER_TABLE_ID = 'userTable';
const USER_TABLE_SELECTOR = `#${USER_TABLE_ID}`;
const PRODUCT_TABLE_ID = 'productTable';
const PRODUCT_TABLE_SELECTOR = `#${PRODUCT_TABLE_ID}`;
let userData = [];
let productData = [];

// Initialize user quotation date range picker
const userRangePickerContainer = document.getElementById('user-date-range-container');
const userRangePicker = new DateRangePicker(userRangePickerContainer, {    
    format: 'dd/mm/yyyy',
    maxDate: new Date(),
    orientation: 'bottom',
    autohide: true,
    todayHighlight: true,
    clearButton: true,
    language: 'es'
});

// Initialize product quotation date range picker
const productRangePickerContainer = document.getElementById('product-date-range-container');
const productRangePicker = new DateRangePicker(productRangePickerContainer, {    
    format: 'dd/mm/yyyy',
    maxDate: new Date(),
    orientation: 'bottom',
    autohide: true,
    todayHighlight: true,
    clearButton: true,
    language: 'es'
});

/**
 * Load initial quotations data for both users and products, and render the tables 
 */
const loadQuotations = () => {
    axios.get(AJAX_URL, {
        params: {
            action: 'load_quotations'
        }
    })
    .then(response => {
        if (response.data.success) {            
            initializeQuotations(response.data);
        } else {
            const errorMessage = response.data.message || 'Error inesperado cargando las cotizaciones';
            iziToastError({message: errorMessage});
        }
    })
    .catch(error => {
        console.log('[ERROR] Error en loadQuotations:', error);
        iziToastError({message: 'Error de conexión. Por favor intenta de nuevo más tarde'});
    });
}

/**
 * Initialize quotations data for both users and products
 * 
 * @param {Object} data Response data containing quotations and related info 
 */
const initializeQuotations = (data) => {
    userData = data.items.users || [];
    productData = data.items.products || [];

    const currentMonth = data.currentMonth || '';
    setText('user-dashboard-month', currentMonth);
    setText('user-dashboard-perc', userData.length || '0');
    setText('product-dashboard-month', currentMonth);
    setText('product-dashboard-perc', productData.length || '0');

    renderUserTable();
    renderProductTable();
}

/**
 * Load user quotations based on selected date range and render the user table
 */
const loadUserQuotations = () => {
    const startDate = document.getElementById('user-range-start-date')?.value?.trim() || '';
    const endDate = document.getElementById('user-range-end-date')?.value?.trim() || '';

    axios.get(AJAX_URL, {
        params: {
            action: 'load_user_quotations',
            start_date: startDate,
            end_date: endDate
        }
    })
    .then(response => {
        if (response.data.success) {
            userData = response.data.items || [];
            renderUserTable();
        } else {
            const errorMessage = response.data.message || 'Error inesperado cargando el listado de cotizaciones de usuarios';
            iziToastError({message: errorMessage});
        }
    })
    .catch(error => {
        console.log('[ERROR] Error en loadUserQuotations:', error);
        iziToastError({message: 'Error de conexión. Por favor intenta de nuevo más tarde'});
    });
}

/**
 * Load product quotations based on selected date range and render the product table
 */
const loadProductQuotations = () => {
    const startDate = document.getElementById('product-range-start-date')?.value?.trim() || '';
    const endDate = document.getElementById('product-range-end-date')?.value?.trim() || '';

    axios.get(AJAX_URL, {
        params: {
            action: 'load_product_quotations',
            start_date: startDate,
            end_date: endDate
        }
    })
    .then(response => {
        if (response.data.success) {
            productData = response.data.items || [];
            renderProductTable();
        } else {
            const errorMessage = response.data.message || 'Error inesperado cargando el listado de cotizaciones de productos';
            iziToastError({message: errorMessage});
        }
    })
    .catch(error => {
        console.log('[ERROR] Error en loadProductQuotations:', error);
        iziToastError({message: 'Error de conexión. Por favor intenta de nuevo más tarde'});
    });
}

/**
 * Render the user quotations table based on the current userData array
 */
const renderUserTable = () => {
    const tbody = document.querySelector(`${USER_TABLE_SELECTOR} tbody`);
    if (!tbody) return;    

    tbody.innerHTML = '';
    userData.forEach(user => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${user.date}</td>
            <td>${user.name}</td>
            <td>${user.business_name}</td>
            <td>${user.email}</td>            
            <td>${user.folio}</td>            
            <td>${user.product_use}</td>            
        `;
        tbody.appendChild(tr);
    });

    if (userData.length > 0) {
        showElement('download-user-report');                
    } else {
        hideElement('download-user-report');
    }
}

/** 
 * Render the product quotations table based on the current productData array
 */
const renderProductTable = () => {
    const tbody = document.querySelector(`${PRODUCT_TABLE_SELECTOR} tbody`);
    if (!tbody) return;    

    tbody.innerHTML = '';
    productData.forEach(product => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${product.date}</td>
            <td>${product.sku}</td>
            <td>${product.code}</td>
            <td>${product.folio}</td>
            <td>${product.quantity}</td>
        `;
        tbody.appendChild(tr);
    });

    if (productData.length > 0) {
        showElement('download-product-report');                
    } else {
        hideElement('download-product-report');
    }
}

/**
 * Download the report for either user or product quotations based on the provided type and current date range filters
 * 
 * @param {string} type - The type of report to download ('user' or 'product')
 */
const downloadReport = (type) => {
    if (type === 'user' && userData.length === 0) {
        iziToastError({message: 'No hay datos disponibles para descargar el reporte de cotizaciones de usuarios'});
        return;
    }else if (type === 'product' && productData.length === 0) {
        iziToastError({message: 'No hay datos disponibles para descargar el reporte de cotizaciones de productos'});
        return;
    } 

    let startDate;
    let endDate;
    if (type === 'user') {
        startDate = document.getElementById('user-range-start-date')?.value?.trim() || '';
        endDate = document.getElementById('user-range-end-date')?.value?.trim() || '';
    } else if (type === 'product') {
        startDate = document.getElementById('product-range-start-date')?.value?.trim() || '';
        endDate = document.getElementById('product-range-end-date')?.value?.trim() || '';
    }

    const url = `${AJAX_URL}?action=export_excel&start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}&report_type=${type}`;
    window.location.href = url;
}

document.addEventListener('DOMContentLoaded', () => {    
    loadQuotations();
    
    // Add click event for user search button
    const searchUserButton = document.getElementById('search-user-quotations');
    if (searchUserButton) {
        searchUserButton.addEventListener('click', (e) => {
            e.preventDefault();
            loadUserQuotations();
        });
    }

    // Add click event for product search button
    const searchProductButton = document.getElementById('search-product-quotations');
    if (searchProductButton) {
        searchProductButton.addEventListener('click', (e) => {
            e.preventDefault();
            loadProductQuotations();
        });
    }

    // Add click event for user report download button
    const downloadUserButton = document.getElementById('download-user-report');
    if (downloadUserButton) {
        downloadUserButton.addEventListener('click', (e) => {
            e.preventDefault();
            downloadReport('user');
        });
    }

    // Add click event for product report download button
    const downloadProductButton = document.getElementById('download-product-report');
    if (downloadProductButton) {
        downloadProductButton.addEventListener('click', (e) => {
            e.preventDefault();
            downloadReport('product');
        });
    }
});