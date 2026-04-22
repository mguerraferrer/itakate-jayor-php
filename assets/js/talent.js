'use strict';
const TALENT_AJAX_URL = '../../app/ajax/web/dashboard_talent.php';

document.addEventListener('DOMContentLoaded', () => {
    const talentLink = document.getElementById('talent-link');
    if (talentLink) {
        talentLink.addEventListener('click', function(e) {            
            talentDashboard();
        });
    }
});

const talentDashboard = () => {
    try {        
        const formData = new FormData();
        formData.append('action', 'register_talent');

        axios.post(TALENT_AJAX_URL, formData)
            .then(response => {
                // Ignore
            })
            .catch(error => {
                console.log('Error:', error);
            });            
    } catch (error) {
        console.log('Error in talentDashboard:', error);
    }
}