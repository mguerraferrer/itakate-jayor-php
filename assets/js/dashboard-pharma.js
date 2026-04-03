'use strict';
const AJAX_URL = '../../app/ajax/admin/dashboard_pharma.php';
const TABLE_ID = 'pharmaTable';
const TABLE_SELECTOR = `#${TABLE_ID}`;
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

const loadPharmaList = () => {
    const monthYearValue = document.getElementById('monthYear')?.value?.trim() || '';

    axios.get(AJAX_URL, {
        params: {
            action: 'load_pharma',
            initialLoad: initialLoad,
            monthYear: monthYearValue
        }
    })
    .then(response => {
        if (response.data.success) {            
            if (initialLoad === 1) {
                setText('dashboard-month', response.data.month || '');
                setText('dashboard-perc', response.data.totalMonth || '0');
            }
            renderTable(response.data.items);            
        } else {
            const errorMessage = response.data.message || 'Error inesperado cargando la lista de reportes';
            iziToastError({message: errorMessage});
        }
    })
    .catch(error => {
        console.log('[ERROR] Error en loadPharmaList:', error);
        iziToastError({message: 'Error de conexión. Por favor intenta de nuevo más tarde'});
    });
}

function renderTable(pharmaList) {
    const tbody = document.querySelector(`${TABLE_SELECTOR} tbody`);
    if (!tbody) return;    

    tbody.innerHTML = '';
    pharmaList.forEach(contact => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${contact.nombre}</td>
            <td>${contact.correo_electronico}</td>
            <td>${contact.telefono}</td>
            <td>${contact.tipo}</td>
            <td>${contact.date}</td>
        `;
        tbody.appendChild(tr);
    });
}

document.addEventListener('DOMContentLoaded', () => {    
    loadPharmaList();
    
    // Add click event for search button
    const searchButton = document.querySelector('.btn-search.search');
    if (searchButton) {
        searchButton.addEventListener('click', (e) => {
            e.preventDefault();
            initialLoad = 0; // Set initialLoad to 0 for subsequent searches
            loadPharmaList();
        });
    }
});