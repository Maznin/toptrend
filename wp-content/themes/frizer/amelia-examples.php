<?php
/**
 * Amelia Data Usage Examples
 * 
 * This file contains examples of how to use the Amelia helper functions
 * Include this in a page template or create a shortcode to display the data
 */

// Example 1: Display all services in a formatted list
function display_amelia_services() {
    $services = get_amelia_services();
    
    if (empty($services)) {
        return '<p>No services available.</p>';
    }
    
    $output = '<div class="services-grid">';
    foreach ($services as $service) {
        $output .= '<div class="service-card">';
        $output .= '<h3>' . esc_html($service->name) . '</h3>';
        
        if ($service->description) {
            $output .= '<p class="service-description">' . esc_html($service->description) . '</p>';
        }
        
        $output .= '<div class="service-details">';
        $output .= '<span class="price">' . number_format($service->price, 0, ',', '.') . ' RSD</span>';
        $output .= '<span class="duration">' . ($service->duration / 60) . ' min</span>';
        $output .= '</div>';
        $output .= '</div>';
    }
    $output .= '</div>';
    
    return $output;
}

// Example 2: Display providers with their services
function display_providers_with_services() {
    $providers = get_amelia_providers();
    
    $output = '<div class="providers-list">';
    foreach ($providers as $provider) {
        $output .= '<div class="provider-card">';
        $output .= '<h3>' . esc_html($provider->firstName . ' ' . $provider->lastName) . '</h3>';
        
        if ($provider->description) {
            $output .= '<p>' . esc_html($provider->description) . '</p>';
        }
        
        // Get services for this provider
        $services = get_provider_services($provider->id);
        if (!empty($services)) {
            $output .= '<h4>Services:</h4>';
            $output .= '<ul class="provider-services">';
            foreach ($services as $service) {
                $price = $service->provider_price ?: $service->price;
                $output .= '<li>' . esc_html($service->name) . ' - ' . number_format($price, 0, ',', '.') . ' RSD</li>';
            }
            $output .= '</ul>';
        }
        
        $output .= '</div>';
    }
    $output .= '</div>';
    
    return $output;
}

// Example 3: Display upcoming appointments
function display_upcoming_appointments($limit = 10) {
    $appointments = get_amelia_appointments(array(
        'date_from' => date('Y-m-d H:i:s'),
        'limit' => $limit
    ));
    
    if (empty($appointments)) {
        return '<p>No upcoming appointments.</p>';
    }
    
    $output = '<div class="appointments-list">';
    $output .= '<h3>Upcoming Appointments</h3>';
    
    foreach ($appointments as $appointment) {
        $output .= '<div class="appointment-item">';
        $output .= '<div class="appointment-date">' . date('d.m.Y H:i', strtotime($appointment->bookingStart)) . '</div>';
        $output .= '<div class="appointment-service">' . esc_html($appointment->service_name) . '</div>';
        $output .= '<div class="appointment-provider">' . esc_html($appointment->provider_firstName . ' ' . $appointment->provider_lastName) . '</div>';
        $output .= '<div class="appointment-status status-' . $appointment->status . '">' . ucfirst($appointment->status) . '</div>';
        $output .= '</div>';
    }
    
    $output .= '</div>';
    
    return $output;
}

// Example 4: Display services by category
function display_services_by_category() {
    $categories = get_amelia_categories();
    
    $output = '<div class="services-by-category">';
    
    foreach ($categories as $category) {
        $services = get_services_by_category($category->id);
        
        if (!empty($services)) {
            $output .= '<div class="category-section">';
            $output .= '<h3 class="category-title">' . esc_html($category->name) . '</h3>';
            
            $output .= '<div class="category-services">';
            foreach ($services as $service) {
                $output .= '<div class="service-item">';
                $output .= '<span class="service-name">' . esc_html($service->name) . '</span>';
                $output .= '<span class="service-price">' . number_format($service->price, 0, ',', '.') . ' RSD</span>';
                $output .= '</div>';
            }
            $output .= '</div>';
            
            $output .= '</div>';
        }
    }
    
    $output .= '</div>';
    
    return $output;
}

// Example 5: Get specific data for AJAX requests
function get_amelia_data_ajax() {
    if (!isset($_POST['action']) || $_POST['action'] !== 'get_amelia_data') {
        return;
    }
    
    $data_type = sanitize_text_field($_POST['data_type']);
    $response = array();
    
    switch ($data_type) {
        case 'services':
            $response = get_amelia_services();
            break;
        case 'providers':
            $response = get_amelia_providers();
            break;
        case 'appointments':
            $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 10;
            $response = get_amelia_appointments(array('limit' => $limit));
            break;
        case 'categories':
            $response = get_amelia_categories();
            break;
        default:
            $response = array('error' => 'Invalid data type');
    }
    
    wp_send_json($response);
}
add_action('wp_ajax_get_amelia_data', 'get_amelia_data_ajax');
add_action('wp_ajax_nopriv_get_amelia_data', 'get_amelia_data_ajax');

// Shortcodes for easy usage in content
add_shortcode('amelia_providers', 'display_providers_with_services');
add_shortcode('amelia_upcoming_appointments', function($atts) {
    $atts = shortcode_atts(array('limit' => 10), $atts);
    return display_upcoming_appointments($atts['limit']);
});
add_shortcode('amelia_services_by_category', 'display_services_by_category');

// Example of using the data in a WordPress query
function get_service_for_post($post_id) {
    $service_id = get_post_meta($post_id, 'amelia_service_id', true);
    if ($service_id) {
        return get_amelia_service($service_id);
    }
    return null;
}

// Example function to get availability data
function get_provider_availability($provider_id, $date = null) {
    if (!$date) {
        $date = date('Y-m-d');
    }
    
    // Get working hours
    $working_hours = get_provider_working_hours($provider_id);
    
    // Get appointments for the day
    $appointments = get_amelia_appointments(array(
        'provider_id' => $provider_id,
        'date_from' => $date . ' 00:00:00',
        'date_to' => $date . ' 23:59:59'
    ));
    
    return array(
        'working_hours' => $working_hours,
        'appointments' => $appointments
    );
}