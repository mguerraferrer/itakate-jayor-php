'use strict';

let SOCIAL_AJAX_URL = null;
let social = null;

document.addEventListener('DOMContentLoaded', () => {
    SOCIAL_AJAX_URL = (window.rootPath || '../../') + 'app/ajax/web/dashboard_social.php';
    
    // Add event listeners to all social link elements
    const socialLinks = document.querySelectorAll('a[data-rel^="social-"]');
    
    socialLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {            
            const rel = this.getAttribute('data-rel');
            if (rel === 'social-f') {
                social = 'F';
            } else if (rel === 'social-l') {
                social = 'L';
            } else if (rel === 'social-w') {
                social = 'W';
            } else if (rel === 'social-y') {
                social = 'Y';
            } else {
                social = null;
            }

            if (social !== null) {
                socialDashboard();
            }
        });
    });
});

const socialDashboard = () => {
    try {        
        const formData = new FormData();
        formData.append('action', 'register_social');
        formData.append('social', social);

        axios.post(SOCIAL_AJAX_URL, formData)
            .then(response => {
                // Ignore
            })
            .catch(error => {
                console.log('Error:', error);
            });            
    } catch (error) {
        console.log('Error in socialDashboard:', error);
    }
}