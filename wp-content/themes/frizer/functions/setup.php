<?php
// Theme setup


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Loads the theme's translated strings from the /languages directory.
 *
 */
function frizer_setup() {
  load_theme_textdomain( 'frizer', THEME_PATH . '/languages' );
}
add_action( 'after_setup_theme', 'frizer_setup' );


/**
 * Defines the frizer_wp_body_open function if it doesn't already exist.
 *
 * This function triggers the 'wp_body_open' action, which allows developers
 * to hook into the opening of the <body> tag in WordPress themes.
 * Useful for injecting code (such as analytics or tracking scripts) immediately after the body tag opens.
 */
if (!function_exists('frizer_wp_body_open')) {
    function frizer_wp_body_open()
    {
        do_action('wp_body_open');
    }
}

/**
 * Outputs a skip link for screen readers to allow users to jump directly to the main content.
 *
 * This function echoes an accessible "Skip to the content" link, which is especially useful for keyboard and screen reader users.
 * It is hooked to the 'wp_body_open' action with a priority of 5, ensuring it appears early in the body.
 */
function frizer_skip_link() {
  echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'frizer') . '</a>';
}
add_action('wp_body_open', 'frizer_skip_link', 5);

/**
 * Adds theme functionalities.
 */
function frizer_add_template_parts_support() {
  add_theme_support( 'custom-logo' );
  add_theme_support( 'menus' );
  add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'frizer_add_template_parts_support' );

function frizer_register_footer_menu() {
  register_nav_menu('footer', __('Footer Menu', 'frizer'));
}
add_action('after_setup_theme', 'frizer_register_footer_menu');

/**
 * Remove automatic paragraph formatting for Contact Form 7
 */
add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * Preloads the main hero background image for faster display.
 */
function frizer_preload_main_hero_bg() {
    $img_url = get_template_directory_uri() . '/src/img/top-trend-018-uvodna-sekcija.jpg';
    echo '<link rel="preload" as="image" href="' . esc_url($img_url) . '">';
}
add_action('wp_head', 'frizer_preload_main_hero_bg');

add_action('wp_head', function () {
  if (is_admin()) return;

  // Try to use your site’s logo from the Customizer
  $logo_id  = get_theme_mod('custom_logo');
  $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';

  $data = [
    "@context" => "https://schema.org",
    "@type" => "HairSalon",
    "name" => get_bloginfo('name'),
    "url" => home_url('/'),
    "image" => array_values(array_filter([$logo_url])),
    "logo" => $logo_url,
    "telephone" => "+381-60-032-0705",
    "address" => [
      "@type" => "PostalAddress",
      "streetAddress" => "Jugovićeva 1 (Lokal 7)",
      "addressLocality" => "Niš",                  
      "addressRegion" => "RS",
      "postalCode" => "18000",
      "addressCountry" => "RS"
    ],
    "geo" => [
      "@type" => "GeoCoordinates",
      "latitude" => 43.31622080401302,
      "longitude" => 21.89004935855904
    ],
    "openingHoursSpecification" => [
      [
        "@type" => "OpeningHoursSpecification",
        "dayOfWeek" => ["Monday","Tuesday","Wednesday","Thursday","Friday"],
        "opens" => "09:30",
        "closes" => "20:00"
      ],
      [
        "@type" => "OpeningHoursSpecification",
        "dayOfWeek" => "Saturday",
        "opens" => "09:00",
        "closes" => "16:00"
      ]
      // Sunday closed → omit or leave out that day
    ],
    "sameAs" => [
      "https://www.facebook.com/profile.php?id=100063556884780#",
      "https://www.instagram.com/top_trend_018/"
    ],
    "hasMap" => "https://maps.google.com/?q=43.31622080401302,21.89004935855904"
  ];

  echo '<script type="application/ld+json">'.wp_json_encode($data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).'</script>';
});