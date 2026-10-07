'use strict';

const PROMO_POPUP_ID = 'promoPopup';
const PROMO_POPUP_CLOSE_ID = 'promoPopupClose';

const setupPromoPopup = () => {
    const popup = document.getElementById(PROMO_POPUP_ID);
    if (!popup) return;

    const closeButton = document.getElementById(PROMO_POPUP_CLOSE_ID);

    const closePopup = () => {
        popup.setAttribute('hidden', 'hidden');
    };

    const openPopup = () => {
        popup.removeAttribute('hidden');
    };

    popup.addEventListener('click', (event) => {
        if (event.target.dataset.popupClose === 'true') {
            closePopup();
        }
    });

    if (closeButton) {
        closeButton.addEventListener('click', closePopup);
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !popup.hasAttribute('hidden')) {
            closePopup();
        }
    });

    openPopup();
}

/**
 * Initialization when the page loads
 */
document.addEventListener('DOMContentLoaded', function () {
    setupPromoPopup();
});