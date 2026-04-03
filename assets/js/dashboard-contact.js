'use strict';
const AJAX_URL = '../../app/ajax/admin/dashboard_contact.php';
const TABLE_ID = 'contactsTable';
const TABLE_SELECTOR = `#${TABLE_ID}`;
let contactsData = [];
let initialLoad = 1;

// Initialize date range picker
const rangePickerContainer = document.getElementById('date-range-container');
const rangePicker = new DateRangePicker(rangePickerContainer, {    
    format: 'dd/mm/yyyy',
    maxDate: new Date(),
    orientation: 'bottom',
    autohide: true,
    todayHighlight: true,
    clearButton: true,
    language: 'es'
});

const loadContacts = () => {
    const startDate = document.getElementById('range-start-date')?.value?.trim() || '';
    const endDate = document.getElementById('range-end-date')?.value?.trim() || '';

    axios.get(AJAX_URL, {
        params: {
            action: 'load_contacts',
            initialLoad: initialLoad,
            start_date: startDate,
            end_date: endDate
        }
    })
    .then(response => {
        if (response.data.success) {            
            if (initialLoad === 1) {
                setText('dashboard-month', response.data.month || '');
                setText('dashboard-perc', response.data.totalMonth || '0');
            }
            contactsData = response.data.items || [];
            renderTable(contactsData);
        } else {
            const errorMessage = response.data.message || 'Error inesperado cargando el listado de contactos';
            iziToastError({message: errorMessage});
        }
    })
    .catch(error => {
        console.log('[ERROR] Error en loadContacts:', error);
        iziToastError({message: 'Error de conexión. Por favor intenta de nuevo más tarde'});
    });
}

function renderTable(contacts) {
    const tbody = document.querySelector(`${TABLE_SELECTOR} tbody`);
    if (!tbody) return;    

    tbody.innerHTML = '';
    contacts.forEach(contact => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${contact.date}</td>
            <td>${contact.name}</td>
            <td>${contact.email}</td>            
        `;
        tbody.appendChild(tr);
    });

    if (contacts.length > 0) {
        showElement('download-report');                
    } else {
        hideElement('download-report');
    }
}

const downloadReport = () => {
    if (contactsData.length === 0) {
        iziToastError({message: 'No hay datos para exportar'});
        return;
    }

    const startDate = document.getElementById('range-start-date')?.value?.trim() || '';
    const endDate = document.getElementById('range-end-date')?.value?.trim() || '';
    const url = `${AJAX_URL}?action=export_excel&start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`;
    window.location.href = url;
}

document.addEventListener('DOMContentLoaded', () => {    
    loadContacts();
    
    // Add click event for search button
    const searchButton = document.querySelector('.btn-search.search');
    if (searchButton) {
        searchButton.addEventListener('click', (e) => {
            e.preventDefault();
            initialLoad = 0; // Set initialLoad to 0 for subsequent searches
            loadContacts();
        });
    }

    const downloadButton = document.getElementById('download-report');
    if (downloadButton) {
        downloadButton.addEventListener('click', (e) => {
            e.preventDefault();
            downloadReport();
        });
    }
});