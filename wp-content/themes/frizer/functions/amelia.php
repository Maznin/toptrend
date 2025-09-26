<?php

/**
 * Amelia Data Helper Functions
 * Functions to retrieve specific data from Amelia WordPress plugin database tables
 */

// Check if Amelia plugin is active and database tables exist
function is_amelia_available() {
    // Check if plugin is active
    if (!function_exists('is_plugin_active')) {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }
    
    // Check multiple possible plugin paths for Amelia
    $amelia_active = is_plugin_active('ameliabooking/ameliabooking.php') || 
                    is_plugin_active('amelia/amelia.php') || 
                    class_exists('AmeliaBooking\Domain\Services\DateTime\DateTimeService') ||
                    defined('AMELIA_VERSION');
    
    if (!$amelia_active) {
        return false;
    }
    
    // Check if database tables exist
    global $wpdb;
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}amelia_services'");
    
    return !empty($table_exists);
}

// Early return if Amelia is not available
if (!is_amelia_available()) {
    // Log warning if in debug mode
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Amelia plugin is not active or database tables do not exist. Amelia helper functions will not be loaded.');
    }
    return;
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
    
    $orderby = sanitize_sql_orderby($args['orderby'] . ' ' . $args['order']);
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