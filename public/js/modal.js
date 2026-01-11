/**
 * MODAL UTILITIES
 * Handle modal open/close interactions
 */

function initModals() {
    // Open modal
    document.querySelectorAll('[data-modal-open]').forEach(button => {
        button.addEventListener('click', () => {
            const modalId = button.getAttribute('data-modal-open');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('open');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    // Close modal
    document.querySelectorAll('[data-modal-close]').forEach(button => {
        button.addEventListener('click', () => {
            const modal = button.closest('.modal');
            if (modal) {
                modal.classList.remove('open');
                document.body.style.overflow = '';
            }
        });
    });

    // Close on overlay click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                const modal = overlay.closest('.modal');
                if (modal) {
                    modal.classList.remove('open');
                    document.body.style.overflow = '';
                }
            }
        });
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal.open').forEach(modal => {
                modal.classList.remove('open');
                document.body.style.overflow = '';
            });
        }
    });
}

/**
 * DRAWER MENU (Mobile Hamburger)
 */
function initDrawer() {
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const drawer = document.getElementById('drawer');
    const drawerOverlay = document.getElementById('drawer-overlay');
    const drawerClose = document.getElementById('drawer-close');

    if (!hamburgerBtn || !drawer || !drawerOverlay) return;

    // Open drawer
    hamburgerBtn.addEventListener('click', () => {
        drawer.classList.add('open');
        drawerOverlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    });

    // Close drawer
    const closeDrawer = () => {
        drawer.classList.remove('open');
        drawerOverlay.classList.remove('open');
        document.body.style.overflow = '';
    };

    if (drawerClose) drawerClose.addEventListener('click', closeDrawer);
    drawerOverlay.addEventListener('click', closeDrawer);
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initModals();
        initDrawer();
    });
} else {
    initModals();
    initDrawer();
}
