export function headerBanner() {
    const banner = document.querySelector('.header__banner');
    if (!banner) return;

    // Cache-compatible dismissal check: on cached pages the PHP session check
    // never runs, so we must check the cookie client-side before showing.
    if (document.cookie.split(';').some(c => c.trim() === 'banner_dismissed=1')) {
        banner.remove();
        return;
    }

    // Show banner with slide-down animation
    banner.classList.add('header__banner--visible');

    const closeBtn = banner.querySelector('.header__banner__close');
    if (closeBtn) {
        closeBtn.addEventListener('click', hideBanner);
    }

    function hideBanner() {
        // Set cookie immediately so the banner stays gone on the next cached page load.
        document.cookie = 'banner_dismissed=1; path=/; SameSite=Lax';

        // Start the CSS exit transition right away, then collapse once it finishes.
        banner.classList.remove('header__banner--visible');
        banner.addEventListener('transitionend', () => {
            banner.classList.add('header__banner--hidden');
        }, { once: true });

        dismissBannerOnServer();
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