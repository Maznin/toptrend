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

/**
 * Get Amelia service by ID
 * @param int $service_id
 * @return object|null
 */
function get_amelia_service($service_id) {
    global $wpdb;
    
    return $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}amelia_services WHERE id = %d",
        $service_id
    ));
}

/**
 * Get all Amelia employees/providers
 * @param array $args - Optional arguments for filtering
 * @return array - Array of providers
 */
function get_amelia_providers($args = array()) {
    global $wpdb;
    
    $defaults = array(
        'status' => 'visible',
        'orderby' => 'firstName',
        'order' => 'ASC'
    );
    
    $args = wp_parse_args($args, $defaults);
    
    $where = "WHERE type = 'provider'";
    
    if ($args['status']) {
        $where .= $wpdb->prepare(" AND status = %s", $args['status']);
    }
    
    $orderby = sanitize_sql_orderby($args['orderby'] . ' ' . $args['order']);
    
    $query = "SELECT * FROM {$wpdb->prefix}amelia_users {$where} ORDER BY {$orderby}";
    
    return $wpdb->get_results($query);
}

/**
 * Get Amelia provider by ID
 * @param int $provider_id
 * @return object|null
 */
function get_amelia_provider($provider_id) {
    global $wpdb;
    
    return $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}amelia_users WHERE id = %d AND type = 'provider'",
        $provider_id
    ));
}

/**
 * Get services assigned to a specific provider
 * @param int $provider_id
 * @return array
 */
function get_provider_services($provider_id) {
    global $wpdb;
    
    return $wpdb->get_results($wpdb->prepare(
        "SELECT s.*, pts.price as provider_price 
         FROM {$wpdb->prefix}amelia_services s
         INNER JOIN {$wpdb->prefix}amelia_providers_to_services pts ON s.id = pts.serviceId
         WHERE pts.userId = %d AND s.status = 'visible'
         ORDER BY s.position",
        $provider_id
    ));
}

/**
 * Get all Amelia locations
 * @return array
 */
function get_amelia_locations() {
    global $wpdb;
    
    return $wpdb->get_results(
        "SELECT * FROM {$wpdb->prefix}amelia_locations WHERE status = 'visible' ORDER BY name"
    );
}

/**
 * Get Amelia appointments
 * @param array $args - Optional arguments for filtering
 * @return array
 */
function get_amelia_appointments($args = array()) {
    global $wpdb;
    
    $defaults = array(
        'status' => 'approved',
        'provider_id' => null,
        'service_id' => null,
        'date_from' => null,
        'date_to' => null,
        'orderby' => 'bookingStart',
        'order' => 'ASC',
        'limit' => null
    );
    
    $args = wp_parse_args($args, $defaults);
    
    $where = "WHERE 1=1";
    
    if ($args['status']) {
        $where .= $wpdb->prepare(" AND a.status = %s", $args['status']);
    }
    
    if ($args['provider_id']) {
        $where .= $wpdb->prepare(" AND a.providerId = %d", $args['provider_id']);
    }
    
    if ($args['service_id']) {
        $where .= $wpdb->prepare(" AND a.serviceId = %d", $args['service_id']);
    }
    
    if ($args['date_from']) {
        $where .= $wpdb->prepare(" AND a.bookingStart >= %s", $args['date_from']);
    }
    
    if ($args['date_to']) {
        $where .= $wpdb->prepare(" AND a.bookingEnd <= %s", $args['date_to']);
    }
    
    $orderby = sanitize_sql_orderby($args['orderby'] . ' ' . $args['order']);
    $limit = $args['limit'] ? $wpdb->prepare("LIMIT %d", $args['limit']) : '';
    
    $query = "
        SELECT a.*, 
               s.name as service_name, 
               s.price as service_price,
               s.duration as service_duration,
               u.firstName as provider_firstName, 
               u.lastName as provider_lastName
        FROM {$wpdb->prefix}amelia_appointments a
        LEFT JOIN {$wpdb->prefix}amelia_services s ON a.serviceId = s.id
        LEFT JOIN {$wpdb->prefix}amelia_users u ON a.providerId = u.id
        {$where} 
        ORDER BY {$orderby} 
        {$limit}
    ";
    
    return $wpdb->get_results($query);
}

/**
 * Get customer bookings for a specific appointment
 * @param int $appointment_id
 * @return array
 */
function get_appointment_bookings($appointment_id) {
    global $wpdb;
    
    return $wpdb->get_results($wpdb->prepare(
        "SELECT cb.*, 
                u.firstName as customer_firstName, 
                u.lastName as customer_lastName,
                u.email as customer_email,
                u.phone as customer_phone
         FROM {$wpdb->prefix}amelia_customer_bookings cb
         LEFT JOIN {$wpdb->prefix}amelia_users u ON cb.customerId = u.id
         WHERE cb.appointmentId = %d",
        $appointment_id
    ));
}

/**
 * Get Amelia categories
 * @return array
 */
function get_amelia_categories() {
    global $wpdb;
    
    return $wpdb->get_results(
        "SELECT * FROM {$wpdb->prefix}amelia_categories WHERE status = 'visible' ORDER BY position"
    );
}

/**
 * Get services by category
 * @param int $category_id
 * @return array
 */
function get_services_by_category($category_id) {
    global $wpdb;
    
    return $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}amelia_services 
         WHERE categoryId = %d AND status = 'visible' 
         ORDER BY position",
        $category_id
    ));
}

/**
 * Get provider working hours
 * @param int $provider_id
 * @return array
 */
function get_provider_working_hours($provider_id) {
    global $wpdb;
    
    return $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}amelia_providers_to_weekdays 
         WHERE userId = %d 
         ORDER BY dayIndex",
        $provider_id
    ));
}

/**
 * Example usage functions - remove these after testing
 */

// Hook to test the functions (remove after testing)
function test_amelia_data() {
    if (isset($_GET['test_amelia'])) {
        echo '<pre>';
        
        // Test getting all services
        echo "=== ALL SERVICES ===\n";
        $services = get_amelia_services();
        print_r($services);
        
        echo "\n=== ALL PROVIDERS ===\n";
        $providers = get_amelia_providers();
        print_r($providers);
        
        echo "\n=== RECENT APPOINTMENTS ===\n";
        $appointments = get_amelia_appointments(array('limit' => 5));
        print_r($appointments);
        
        echo '</pre>';
        exit;
    }
}
add_action('init', 'test_amelia_data');

// Example shortcode to display services
function amelia_services_shortcode($atts) {
    if (!is_amelia_available()) {
        return '<p>Amelia booking plugin is not active or properly configured.</p>';
    }
    
    $atts = shortcode_atts(array(
        'category_id' => null,
        'limit' => null,
        'show_price' => true
    ), $atts);
    
    $services = get_amelia_services(array(
        'category_id' => $atts['category_id'],
        'limit' => $atts['limit']
    ));
    
    if (empty($services)) {
        return '<p>No services found.</p>';
    }
    
    $output = '<div class="amelia-services-list">';
    foreach ($services as $service) {
        $output .= '<div class="amelia-service">';
        $output .= '<h3>' . esc_html($service->name) . '</h3>';
        if ($service->description) {
            $output .= '<p>' . esc_html($service->description) . '</p>';
        }
        if ($atts['show_price'] && $service->price) {
            $output .= '<div class="service-price">' . number_format($service->price, 0, ',', '.') . ' RSD</div>';
        }
        $output .= '<div class="service-duration">Duration: ' . ($service->duration / 60) . ' min</div>';
        $output .= '</div>';
    }
    $output .= '</div>';
    
    return $output;
}
add_shortcode('amelia_services', 'amelia_services_shortcode');