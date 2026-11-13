<?php

/**
 * Automatic update emails: only send them when something went wrong.
 *
 * WordPress emails the admin after every successful automatic core, plugin and theme
 * update. These filters keep only the failure emails. The "Your Site is Experiencing a
 * Technical Issue" (fatal error / recovery mode) email is a separate system and is not
 * affected.
 */

/**
 * True if at least one plugin/theme update in the results failed
 * (same check WordPress uses in WP_Automatic_Updater::after_plugin_theme_update()).
 */
function frizer_any_update_failed($update_results) {
    foreach ((array) $update_results as $update) {
        if (!is_object($update) || empty($update->result) || is_wp_error($update->result)) {
            return true;
        }
    }
    return false;
}

// Core: keep 'fail' and 'critical' (failed update, site may be broken); drop 'success' and 'manual'.
add_filter('auto_core_update_send_email', function ($send, $type) {
    return $send && in_array($type, ['fail', 'critical'], true);
}, 10, 2);

// Plugins and themes: only email if one of the updates failed.
add_filter('auto_plugin_update_send_email', function ($send, $update_results) {
    return $send && frizer_any_update_failed($update_results);
}, 10, 2);

add_filter('auto_theme_update_send_email', function ($send, $update_results) {
    return $send && frizer_any_update_failed($update_results);
}, 10, 2);
