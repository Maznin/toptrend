<?php

// Handle header banner dismissal (session-based).

add_action('init', function () {
    if (!session_id()) {
        session_start();
    }
}, 1);

function frizer_banner_handler_enabled() {
    if (!function_exists('get_field')) {
        return true;
    }

    error_log('header_banner_repeat: ' . var_export(get_field('header_banner_repeat', 'options'), true));
    return !get_field('header_banner_repeat', 'options');
}

add_action('wp_ajax_dismiss_banner', 'frizer_dismiss_banner');
add_action('wp_ajax_nopriv_dismiss_banner', 'frizer_dismiss_banner');

function frizer_dismiss_banner() {
    if (frizer_banner_handler_enabled()) {
        if (!session_id()) {
            session_start();
        }

        $_SESSION['banner_dismissed'] = true;
    }

    wp_send_json_success(['message' => 'Banner dismissed']);
}

add_action('init', function () {
    if (isset($_GET['dismiss_banner']) && $_GET['dismiss_banner'] === '1') {
        if (frizer_banner_handler_enabled()) {
            if (!session_id()) {
                session_start();
            }

            $_SESSION['banner_dismissed'] = true;
        }

        $redirect_url = remove_query_arg('dismiss_banner');
        wp_redirect($redirect_url);
        exit;
    }
});
