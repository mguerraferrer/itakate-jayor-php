'use strict';
let CATALOG_AJAX_URL = null;

document.addEventListener('DOMContentLoaded', () => {
    CATALOG_AJAX_URL = (window.rootPath || '../../') + 'app/ajax/web/dashboard_catalog_download.php';
    
    // Add event listeners to all catalog download link elements
    const catalogLinks = document.querySelectorAll('a[data-rel^="catalog-download"]');
    
    catalogLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {            
            catalogDashboard();
        });
    });
});

const catalogDashboard = () => {
    try {        
        const formData = new FormData();
        formData.append('action', 'register_catalog');

        axios.post(CATALOG_AJAX_URL, formData)
            .then(response => {
                // Ignore
            })
            .catch(error => {
                console.log('Error:', error);
            });            
    } catch (error) {
        console.log('Error in catalogDashboard:', error);
    }
}