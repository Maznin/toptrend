<?php

// Handle header banner dismissal (session-based).

function frizer_start_session_if_needed() {
    if (session_id()) {
        return;
    }

    if (headers_sent()) {
        return;
    }

    session_start();
}

add_action('plugins_loaded', function () {
    frizer_start_session_if_needed();
}, 0);

function frizer_banner_handler_enabled() {
    if (!function_exists('get_field')) {
        return true;
    }

    return !get_field('header_banner_repeat', 'options');
}

add_action('wp_ajax_dismiss_banner', 'frizer_dismiss_banner');
add_action('wp_ajax_nopriv_dismiss_banner', 'frizer_dismiss_banner');

function frizer_dismiss_banner() {
    if (frizer_banner_handler_enabled()) {
        frizer_start_session_if_needed();

        if (session_id()) {
            $_SESSION['banner_dismissed'] = true;
        }

        if (!headers_sent()) {
            setcookie('banner_dismissed', '1', 0, '/');
        }
    }

    wp_send_json_success(['message' => 'Banner dismissed']);
}

add_action('init', function () {
    if (isset($_GET['dismiss_banner']) && $_GET['dismiss_banner'] === '1') {
        if (frizer_banner_handler_enabled()) {
            frizer_start_session_if_needed();

            if (session_id()) {
                $_SESSION['banner_dismissed'] = true;
            }

            if (!headers_sent()) {
                setcookie('banner_dismissed', '1', 0, '/');
            }
        }

        $redirect_url = remove_query_arg('dismiss_banner');
        wp_redirect($redirect_url);
        exit;
    }
});
