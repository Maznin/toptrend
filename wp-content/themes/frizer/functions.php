<?php
add_action('after_setup_theme', 'frizer_setup');
function frizer_setup()
{
    load_theme_textdomain('frizer', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'navigation-widgets'));
    add_theme_support('appearance-tools');
    add_theme_support('woocommerce');
}
add_action('wp_enqueue_scripts', 'frizer_enqueue');
function frizer_enqueue()
{
    $js_theme_asset = include get_theme_file_path('build/js/theme.asset.php');
    $css_theme_asset = include get_theme_file_path('build/css/theme.asset.php');

    wp_enqueue_script('frizer-scripts', get_template_directory_uri() . '/build/js/theme.js', $js_theme_asset['dependencies'], $js_theme_asset['version'], true);
    wp_enqueue_style('frizer-style', get_template_directory_uri() . '/build/css/theme.css', $css_theme_asset['dependencies'], $css_theme_asset['version']);
}
if (!function_exists('frizer_wp_body_open')) {
    function frizer_wp_body_open()
    {
        do_action('wp_body_open');
    }
}
add_action('wp_body_open', 'frizer_skip_link', 5);
function frizer_skip_link()
{
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'frizer') . '</a>';
}
