'use strict';
const AJAX_URL = '../../app/ajax/admin/dashboard_catalog_download.php';
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

const loadCatalogDownloadList = () => {
    const monthYearValue = document.getElementById('monthYear')?.value?.trim() || '';

    axios.get(AJAX_URL, {
        params: {
            action: 'load_catalog_downloads',
            initialLoad: initialLoad,
            monthYear: monthYearValue
        }
    })
    .then(response => {
        if (response.data.success) {            
            if (initialLoad === 1) {
                renderCurrentData(response.data);
            }
            renderData(response.data.items);
        } else {
            const errorMessage = response.data.message || 'Error inesperado cargando la lista de reportes';
            iziToastError({message: errorMessage});
        }
    })
    .catch(error => {
        console.log('[ERROR] Error en loadCatalogDownloadList:', error);
        iziToastError({message: 'Error de conexión. Por favor intenta de nuevo más tarde'});
    });
}

const renderCurrentData = (data) => {
    setText('catalog-download-count', data.catalog || '0');
}

const renderData = (items) => {
    if (items.length === 0) {
        setText('catalog-download', '0');
        return;
    }
    
    let catalogCount = 0;
    items.forEach(item => {
        catalogCount = item.count || 0;
    });
    setText('catalog-download', catalogCount || '0');
}

document.addEventListener('DOMContentLoaded', () => {    
    loadCatalogDownloadList();
    
    // Add click event for search button
    const searchButton = document.querySelector('.btn-search.search');
    if (searchButton) {
        searchButton.addEventListener('click', (e) => {
            e.preventDefault();
            initialLoad = 0; // Set initialLoad to 0 for subsequent searches
            loadCatalogDownloadList();
        });
    }
});