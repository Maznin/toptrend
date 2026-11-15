<?php

/**
 * Amelia Data Helper Functions
 * Functions to retrieve specific data from Amelia WordPress plugin database tables
 */

// Check if Amelia plugin is active and database tables exist (cached per request).
function is_amelia_available() {
    static $available = null;
    if ($available !== null) {
        return $available;
    }

    if (!function_exists('is_plugin_active')) {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    // Check multiple possible plugin paths for Amelia
    $amelia_active = is_plugin_active('ameliabooking/ameliabooking.php') ||
                    is_plugin_active('amelia/amelia.php') ||
                    class_exists('AmeliaBooking\Domain\Services\DateTime\DateTimeService') ||
                    defined('AMELIA_VERSION');

    if (!$amelia_active) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('Amelia plugin is not active; Amelia helper functions will return empty results.');
        }
        return $available = false;
    }

    global $wpdb;
    $table = $wpdb->prefix . 'amelia_services';
    $available = $wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $table)) === $table;

    return $available;
}

/**
 * Get all Amelia services
 * @param array $args - Optional arguments for filtering
 * @return array - Array of services
 */
function get_amelia_services($args = array()) {
    if (!is_amelia_available()) {
        return array();
    }
    
    global $wpdb;
    
    $defaults = array(
        'status' => 'visible',
        'category_id' => null,
        'orderby' => 'position',
        'order' => 'ASC',
        'limit' => null
    );
    
    $args = wp_parse_args($args, $defaults);
    
    $where = "WHERE 1=1";
    
    if ($args['status']) {
        $where .= $wpdb->prepare(" AND status = %s", $args['status']);
    }
    
    if ($args['category_id']) {
        $where .= $wpdb->prepare(" AND categoryId = %d", $args['category_id']);
    }
    
    $orderby = sanitize_sql_orderby($args['orderby'] . ' ' . $args['order']) ?: 'position ASC';
    $limit = $args['limit'] ? $wpdb->prepare("LIMIT %d", $args['limit']) : '';
    
    $query = "SELECT * FROM {$wpdb->prefix}amelia_services {$where} ORDER BY {$orderby} {$limit}";
    
    $results = $wpdb->get_results($query);
    
    if ($wpdb->last_error) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('Amelia Services Query Error: ' . $wpdb->last_error);
        }
        return array();
    }
    
    return $results ? $results : array();
}
/**
 * Serbian Latin translation for Amelia.
 *
 * Amelia ships its sr_RS translation in Cyrillic inside the plugin folder, so every plugin
 * update would switch the booking form to Cyrillic while the rest of the site is Latin.
 * The theme keeps a Latin copy in languages/amelia/ and loads it instead. Amelia loads
 * its own file on plugins_loaded (before the theme), so it is swapped here.
 *
 * After an Amelia update, regenerate the file from the plugin's new .po (transliterate the
 * Cyrillic, keep the existing Latin wording) so new strings are covered.
 */
add_action('after_setup_theme', function () {
    $domain = 'wpamelia';
    $locale = determine_locale();
    if ($locale !== 'sr_RS') {
        return;
    }

    $mofile = THEME_PATH . '/languages/amelia/' . $domain . '-' . $locale . '.mo';
    if (!is_readable($mofile)) {
        return;
    }

    unload_textdomain($domain, true);
    load_textdomain($domain, $mofile, $locale);
});

/**
 * Latin month and day names in Amelia calendars.
 *
 * Amelia formats dates with the browser's Intl API using the WordPress locale (sr_RS),
 * and browsers default Serbian to Cyrillic ("новембар", "пон"). This runs before Amelia's
 * scripts and maps plain Serbian locales to sr-Latn-RS. It is printed early in <head> and
 * excluded from LiteSpeed's JS optimization so it always runs first.
 */
function frizer_serbian_latin_dates_script() {
    if (determine_locale() !== 'sr_RS') {
        return;
    }

    $js = <<<'JS'
(function () {
    if (!window.Intl || !Intl.DateTimeFormat || Intl.DateTimeFormat.__frizerLatn) return;
    var fix = function (l) {
        if (Array.isArray(l)) return l.map(fix);
        return typeof l === 'string' && /^sr([-_]rs)?$/i.test(l) ? 'sr-Latn-RS' : l;
    };
    var DTF = Intl.DateTimeFormat;
    var Wrapped = function (l, o) { return new DTF(fix(l), o); };
    Wrapped.prototype = DTF.prototype;
    Wrapped.supportedLocalesOf = function (l, o) { return DTF.supportedLocalesOf(fix(l), o); };
    Wrapped.__frizerLatn = true;
    Intl.DateTimeFormat = Wrapped;
    ['toLocaleString', 'toLocaleDateString', 'toLocaleTimeString'].forEach(function (m) {
        var orig = Date.prototype[m];
        Date.prototype[m] = function (l, o) { return orig.call(this, fix(l), o); };
    });
})();
JS;

    wp_print_inline_script_tag($js, [
        'id'               => 'frizer-sr-latn-dates',
        'data-no-optimize' => '1',
        'data-no-defer'    => '1',
    ]);
}
add_action('wp_head', 'frizer_serbian_latin_dates_script', 1);
add_action('admin_head', 'frizer_serbian_latin_dates_script', 1);
