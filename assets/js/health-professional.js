'use strict';

(() => {
    const STORAGE_KEY = 'jayor_health_professional';
    const TTL_MS = 24 * 60 * 60 * 1000;
    const RESTRICTED_PAGE = /\/views\/(lines|outlet)(\.php)?\/?$/i;

    const isVerified = () => {
        try {
            const expiresAt = parseInt(localStorage.getItem(STORAGE_KEY), 10);
            if (expiresAt && expiresAt > Date.now()) {
                return true;
            }
            localStorage.removeItem(STORAGE_KEY);
        } catch (e) {
            // localStorage unavailable
        }
        return false;
    };

    const saveVerified = () => {
        try {
            localStorage.setItem(STORAGE_KEY, String(Date.now() + TTL_MS));
        } catch (e) {
            // localStorage unavailable
        }
    };

    const ensureModal = () => {
        let element = document.getElementById('health-professional-modal');
        if (element) {
            return element;
        }

        element = document.createElement('div');
        element.className = 'modal fade';
        element.id = 'health-professional-modal';
        element.tabIndex = -1;
        element.setAttribute('aria-hidden', 'true');
        element.innerHTML = `
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center">
                    <div class="modal-body p-5">
                        <h4 class="mb-4">¿Eres profesional de la salud?</h4>
                        <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                            <button type="button" class="btn btn-jy-ocean" id="health-professional-yes">Soy profesional de la salud</button>
                            <button type="button" class="btn btn-outline-secondary" id="health-professional-no">No</button>
                        </div>
                    </div>
                </div>
            </div>`;
        document.body.appendChild(element);
        return element;
    };

    let pendingAction = null;

    const showModal = (onAccept) => {
        pendingAction = onAccept || null;
        const element = ensureModal();
        const modal = bootstrap.Modal.getOrCreateInstance(element, { backdrop: 'static', keyboard: false });

        element.querySelector('#health-professional-yes').onclick = () => {
            saveVerified();
            modal.hide();
            const action = pendingAction;
            pendingAction = null;
            if (action) {
                action();
            }
        };
        element.querySelector('#health-professional-no').onclick = () => {
            window.location.href = (window.rootPath || '../../') + 'index.php';
        };

        modal.show();
    };

    document.addEventListener('click', (e) => {
        const link = e.target.closest('a[data-rel^="catalog-download"]');
        if (!link || isVerified()) {
            return;
        }

        e.preventDefault();
        e.stopImmediatePropagation();
        showModal(() => {
            if (typeof catalogDashboard === 'function') {
                catalogDashboard();
            }
            window.open(link.href, link.target || '_self');
        });
    }, true);

    document.addEventListener('DOMContentLoaded', () => {
        if (RESTRICTED_PAGE.test(window.location.pathname) && !isVerified()) {
            showModal();
        }
    });
})();
