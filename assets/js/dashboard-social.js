'use strict';
const AJAX_URL = '../../app/ajax/admin/dashboard_social.php';
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

const loadSocialList = () => {
    const monthYearValue = document.getElementById('monthYear')?.value?.trim() || '';

    axios.get(AJAX_URL, {
        params: {
            action: 'load_social',
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
        console.log('[ERROR] Error en loadSocialList:', error);
        iziToastError({message: 'Error de conexión. Por favor intenta de nuevo más tarde'});
    });
}

const renderCurrentData = (data) => {
    setText('facebook-count', data.facebook || '0');
    setText('whatsapp-count', data.whatsapp || '0');
    setText('linkedin-count', data.linkedin || '0');
    setText('youtube-count', data.youtube || '0');
}

const renderData = (items) => {
    if (items.length === 0) {
        setText('social-f', '0');
        setText('social-w', '0');
        setText('social-l', '0');
        setText('social-y', '0');
        return;
    }
    
    let facebookCount = 0;
    let whatsappCount = 0;
    let linkedinCount = 0;
    let youtubeCount = 0;

    items.forEach(item => {
        if (item.social_network === 'FACEBOOK') {
            facebookCount = item.count || 0;
        } else if (item.social_network === 'WHATSAPP') {
            whatsappCount = item.count || 0;
        } else if (item.social_network === 'LINKEDIN') {
            linkedinCount = item.count || 0;
        } else if (item.social_network === 'YOUTUBE') {
            youtubeCount = item.count || 0;
        }
    });

    setText('social-f', facebookCount || '0');
    setText('social-w', whatsappCount || '0');
    setText('social-l', linkedinCount || '0');
    setText('social-y', youtubeCount || '0');
}

document.addEventListener('DOMContentLoaded', () => {    
    loadSocialList();
    
    // Add click event for search button
    const searchButton = document.querySelector('.btn-search.search');
    if (searchButton) {
        searchButton.addEventListener('click', (e) => {
            e.preventDefault();
            initialLoad = 0; // Set initialLoad to 0 for subsequent searches
            loadSocialList();
        });
    }
});