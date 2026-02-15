export function headerBanner() {
    const banner = document.querySelector('.header__banner');
    if (!banner) return;
    
    // Show banner with slide-down animation
    banner.classList.add('header__banner--visible');

    // Close button functionality
    const closeBtn = banner.querySelector('.header__banner__close');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            hideBanner();
        });
    }

    function hideBanner() {
        setTimeout(() => {
            banner.classList.remove('header__banner--visible');
            banner.classList.add('header__banner--hidden');
            dismissBannerOnServer();
        }, 500);
    }

    function dismissBannerOnServer() {
        const data = new FormData();
        data.append('action', 'dismiss_banner');

        const ajaxUrl = window.ajaxurl || '/wp-admin/admin-ajax.php';
        fetch(ajaxUrl, {
            method: 'POST',
            body: data
        }).catch(() => {
            const separator = window.location.href.includes('?') ? '&' : '?';
            window.location.href = `${window.location.href}${separator}dismiss_banner=1`;
        });
    }
}