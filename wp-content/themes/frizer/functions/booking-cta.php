<?php

/**
 * Booking calls to action: booking page URL, per-service "Zakaži" links, the mobile
 * booking bar and service preselection on /zakazivanje/.
 */

/**
 * Amelia category IDs that customers can book online. The /zakazivanje/ form offers
 * men's services only (category 1). Add 3 (Ženske usluge) here once women's services
 * are opened online.
 */
function frizer_online_booking_categories() {
    return apply_filters('frizer_online_booking_categories', [1]);
}

/**
 * Visible Amelia services in the online-bookable categories, keyed by ID (cached per request).
 */
function frizer_bookable_services() {
    static $services = null;
    if ($services !== null) {
        return $services;
    }

    $services = [];
    foreach (frizer_online_booking_categories() as $cat_id) {
        foreach (get_amelia_services(['category_id' => $cat_id]) as $service) {
            $services[(int) $service->id] = $service;
        }
    }
    return $services;
}

function frizer_is_bookable_service($service_id) {
    return isset(frizer_bookable_services()[(int) $service_id]);
}

/**
 * URL of the booking page, optionally with a preselected service (?usluga=<id>).
 */
function frizer_booking_url($service_id = 0) {
    $page = get_page_by_path('zakazivanje');
    $url  = $page ? get_permalink($page) : home_url('/zakazivanje/');

    if ($service_id && frizer_is_bookable_service($service_id)) {
        $url = add_query_arg('usluga', (int) $service_id, $url);
    }
    return $url;
}

function frizer_is_booking_page() {
    return is_page(['zakazivanje', 'zakazivanje-interno']);
}

/**
 * The salon's main phone link from the top header options: ['url' => 'tel:…', 'title' => '060 / …'].
 */
function frizer_main_phone() {
    $top_header = function_exists('get_field') ? (get_field('top_header', 'options') ?: []) : [];
    $phone      = $top_header['phone_number'] ?? [];
    return (!empty($phone['url']) && !empty($phone['title'])) ? $phone : null;
}

/**
 * Preselect the service on /zakazivanje/?usluga=<id>: the Amelia step-booking form gets
 * service=<id>, so the customer skips the service step. Unknown or non-bookable IDs are
 * ignored and the normal form is shown.
 *
 * Amelia locks a preselected form to that one service (no way back to the service step),
 * so a bar above the form shows the chosen service with a "Promeni uslugu" link to the
 * normal form.
 */
add_filter('pre_do_shortcode_tag', function ($output, $tag, $attr, $m) {
    static $running = false;

    if ($tag !== 'ameliastepbooking' || $running || is_admin() || empty($_GET['usluga'])) {
        return $output;
    }

    $service_id = absint(wp_unslash($_GET['usluga']));
    if (!$service_id || !frizer_is_bookable_service($service_id)) {
        return $output;
    }

    global $shortcode_tags;
    if (empty($shortcode_tags[$tag]) || !is_callable($shortcode_tags[$tag])) {
        return $output;
    }

    $attr = is_array($attr) ? $attr : [];
    unset($attr['category']);
    $attr['service'] = (string) $service_id;

    $running = true;
    $form    = call_user_func($shortcode_tags[$tag], $attr, $m[5] ?? null, $tag);
    $running = false;

    $service = frizer_bookable_services()[$service_id];
    $price   = (float) $service->price;

    ob_start();
    ?>
    <div class="booking-preselected">
        <div class="booking-preselected__bar">
            <div class="booking-preselected__service">
                <span class="booking-preselected__label"><?php esc_html_e('Izabrana usluga', 'frizer'); ?></span>
                <strong class="booking-preselected__name"><?php echo esc_html($service->name); ?></strong>
                <?php if ($price > 0) : ?>
                    <span class="booking-preselected__price"><?php echo esc_html(number_format($price, 0, ',', '.')); ?> <span class="currency">din</span></span>
                <?php endif; ?>
            </div>
            <a href="<?php echo esc_url(frizer_booking_url()); ?>" class="booking-preselected__change"><?php esc_html_e('Promeni uslugu', 'frizer'); ?></a>
        </div>
        <?php echo $form; // Amelia's shortcode output ?>
    </div>
    <?php
    $result = $m[1] . ob_get_clean() . $m[6];

    return $result;
}, 10, 4);

/**
 * Mobile: bar fixed to the bottom of the screen with "Zakaži online" and "Pozovi".
 * It slides in once the visitor scrolls down (src/js/modules/bookingBar.js).
 * Not shown on the booking page itself.
 */
function frizer_show_booking_bar() {
    return !is_admin() && !frizer_is_booking_page();
}

add_filter('body_class', function ($classes) {
    if (frizer_show_booking_bar()) {
        $classes[] = 'has-booking-bar';
    }
    return $classes;
});

add_action('wp_footer', function () {
    if (!frizer_show_booking_bar()) {
        return;
    }
    $phone = frizer_main_phone();
    ?>
    <nav class="booking-bar" id="bookingBar" aria-label="<?php esc_attr_e('Zakazivanje', 'frizer'); ?>">
        <a href="<?php echo esc_url(frizer_booking_url()); ?>" class="booking-bar__btn booking-bar__btn--book"><?php esc_html_e('Zakaži online', 'frizer'); ?></a>
        <?php if ($phone) : ?>
            <a href="<?php echo esc_url($phone['url']); ?>" class="booking-bar__btn booking-bar__btn--call" aria-label="<?php echo esc_attr(sprintf(__('Pozovi %s', 'frizer'), $phone['title'])); ?>"><?php esc_html_e('Pozovi', 'frizer'); ?></a>
        <?php endif; ?>
    </nav>
    <?php
}, 5);
