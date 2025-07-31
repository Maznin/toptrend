<?php
// Theme setup

function frizer_setup() {
  load_theme_textdomain( 'frizer', THEME_PATH . '/languages' );
}
add_action( 'after_setup_theme', 'frizer_setup' );

if (!function_exists('frizer_wp_body_open')) {
    function frizer_wp_body_open()
    {
        do_action('wp_body_open');
    }
}

function frizer_skip_link() {
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'frizer') . '</a>';
}
add_action('wp_body_open', 'frizer_skip_link', 5);

