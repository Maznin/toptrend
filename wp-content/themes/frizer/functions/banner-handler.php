<?php

// Handle header banner dismissal (cookie-based, page-cache friendly).

function frizer_banner_handler_enabled() {
    if (!function_exists('get_field')) {
        return true;
    }

    return !get_field('header_banner_repeat', 'options');
}

function frizer_set_banner_dismissed_cookie() {
    if (headers_sent()) {
        return;
    }

    setcookie('banner_dismissed', '1', [
        'expires'  => 0,
        'path'     => COOKIEPATH ?: '/',
        'secure'   => is_ssl(),
        'httponly' => false, // Read client-side by headerBanner.js on cached pages.
        'samesite' => 'Lax',
    ]);
}

function frizer_is_banner_dismissed() {
    return isset($_COOKIE['banner_dismissed']) && $_COOKIE['banner_dismissed'] === '1';
}

add_action('wp_ajax_dismiss_banner', 'frizer_dismiss_banner');
add_action('wp_ajax_nopriv_dismiss_banner', 'frizer_dismiss_banner');

function frizer_dismiss_banner() {
    if (frizer_banner_handler_enabled()) {
        frizer_set_banner_dismissed_cookie();
    }

    wp_send_json_success(['message' => 'Banner dismissed']);
}

// No-JS / failed-AJAX fallback: ?dismiss_banner=1
add_action('init', function () {
    if (!isset($_GET['dismiss_banner']) || $_GET['dismiss_banner'] !== '1') {
        return;
    }

    if (frizer_banner_handler_enabled()) {
        frizer_set_banner_dismissed_cookie();
    }

    // wp_safe_redirect only allows same-host targets (prevents open redirect via //evil.com/).
    wp_safe_redirect(remove_query_arg('dismiss_banner'), 302);
    exit;
});
