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
 * Adds support for block template parts in the theme.
 *
 * This function registers support for block template parts, allowing the theme to use
 * block-based template parts in its design.
 */
function frizer_add_template_parts_support() {
  add_theme_support( 'block-template-parts' );
}
add_action( 'after_setup_theme', 'frizer_add_template_parts_support' );

