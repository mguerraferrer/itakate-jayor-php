'use strict';
const AJAX_URL = '../../app/ajax/admin/dashboard_product.php';
const TABLE_GENERAL_ID = 'productsTopTenGeneralTable';
const TABLE_GENERAL_SELECTOR = `#${TABLE_GENERAL_ID}`;
const TABLE_MONTHLY_ID = 'productsTopTenMonthlyTable';
const TABLE_MONTHLY_SELECTOR = `#${TABLE_MONTHLY_ID}`;
const TABLE_VIEW_ID = 'productsTopTenViewTable';
const TABLE_VIEW_SELECTOR = `#${TABLE_VIEW_ID}`;
let topTenGeneralData = [];
let topTenMonthlyData = [];
let topTenViewData = [];
let initialLoad = 1;

// Datepicker for month/year field
const monthYear = document.getElementById('monthYear');
const monthYearDatepicker = new Datepicker(monthYear, {
    buttonClass: 'btn',
    language: 'es',
    todayHighlight: true,
    autohide: true,
    clearButton: true,
    maxDate: new Date(),
    pickLevel: 1, // Only allow month/year selection
    format: 'mm/yyyy'
});

const loadProducts = () => {
    const monthYearValue = document.getElementById('monthYear')?.value?.trim() || '';

    axios.get(AJAX_URL, {
        params: {
            action: 'load_products',
            initialLoad: initialLoad,
            monthYear: monthYearValue
        }
    })
    .then(response => {
        if (response.data.success) {            
            if (initialLoad === 1) {
                renderToptenGeneralTable(response.data.items.general || []);
                renderToptenViewTable(response.data.items.view || []);
            }
            renderToptenMonthlyTable(response.data.items.monthly || []);
        } else {
            const errorMessage = response.data.message || 'Error inesperado cargando el listado de productos';
            iziToastError({message: errorMessage});
        }
    })
    .catch(error => {
        console.log('[ERROR] Error en loadProducts:', error);
        iziToastError({message: 'Error de conexión. Por favor intenta de nuevo más tarde'});
    });
}

const renderToptenGeneralTable = (products) => {
    const tbody = document.querySelector(`${TABLE_GENERAL_SELECTOR} tbody`);
    if (!tbody) return;    

    tbody.innerHTML = '';
    topTenGeneralData = products; // Store general data for later use
    products.forEach(product => {
        const tr = document.createElement('tr');
        tr.innerHTML = commonTrInnerHTML(product, 'general');
        tbody.appendChild(tr);
    });

    if (products.length > 0) {
        showElement('download-general-report');                
    } else {
        hideElement('download-general-report');
    }
}

const renderToptenMonthlyTable = (products) => {
    const tbody = document.querySelector(`${TABLE_MONTHLY_SELECTOR} tbody`);
    if (!tbody) return;    

    tbody.innerHTML = '';
    topTenMonthlyData = products; // Store monthly data for later use
    products.forEach(product => {
        const tr = document.createElement('tr');
        tr.innerHTML = commonTrInnerHTML(product, 'monthly');
        tbody.appendChild(tr);
    });

    if (products.length > 0) {
        showElement('download-monthly-report');                
    } else {
        hideElement('download-monthly-report');
    }
}

const renderToptenViewTable = (products) => {
    const tbody = document.querySelector(`${TABLE_VIEW_SELECTOR} tbody`);
    if (!tbody) return;    

    tbody.innerHTML = '';
    topTenViewData = products; // Store view data for later use
    products.forEach(product => {
        const tr = document.createElement('tr');
        tr.innerHTML = commonTrInnerHTML(product, 'view');
        tbody.appendChild(tr);
    });

    if (products.length > 0) {
        showElement('download-view-report');                
    } else {
        hideElement('download-view-report');
    }
}

const commonTrInnerHTML = (product, type) => {
    const quantityField = type === 'view' ? product.total : product.quantity_total;
    return `
        <td><span>${product.sku}</span></td>
        <td class="text-center"><span>${product.code}</span></td>
        <td class="text-center"><span>${product.line_name}</span></td>
        <td class="text-center"><span>${product.brand_name}</span></td>
        <td class="text-center"><span>${quantityField}</span></td>
    `;
};

const downloadReport = (type) => {
    const monthYearValue = document.getElementById('monthYear')?.value?.trim() || '';
    
    if (type === 'general' && topTenGeneralData.length === 0) {
        iziToastError({message: 'No hay datos disponibles para descargar el reporte general'});
        return;
    } else if (type === 'monthly' && topTenMonthlyData.length === 0) {
        iziToastError({message: 'No hay datos disponibles para descargar el reporte mensual'});
        return;
    } else if (type === 'view' && topTenViewData.length === 0) {
        iziToastError({message: 'No hay datos disponibles para descargar el reporte de vistas'});
        return;
    }

    const url = `${AJAX_URL}?action=export_excel&month_year=${encodeURIComponent(monthYearValue)}&report_type=${type}`;
    window.location.href = url;
}

document.addEventListener('DOMContentLoaded', () => {    
    loadProducts();
    
    // Add click event for search button
    const searchButton = document.querySelector('.btn-search.search');
    if (searchButton) {
        searchButton.addEventListener('click', (e) => {
            e.preventDefault();
            initialLoad = 0; // Set initialLoad to 0 for subsequent searches
            loadProducts();
        });
    }

    const downloadButton = document.getElementById('download-general-report');
    if (downloadButton) {
        downloadButton.addEventListener('click', (e) => {
            e.preventDefault();
            downloadReport('general');
        });
    }

    const downloadMonthlyButton = document.getElementById('download-monthly-report');
    if (downloadMonthlyButton) {
        downloadMonthlyButton.addEventListener('click', (e) => {
            e.preventDefault();
            downloadReport('monthly');
        });
    }

    const downloadViewButton = document.getElementById('download-view-report');
    if (downloadViewButton) {
        downloadViewButton.addEventListener('click', (e) => {
            e.preventDefault();
            downloadReport('view');
        });
    }
});