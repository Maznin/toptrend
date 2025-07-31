<?php
// Theme assets

function frizer_enqueue() {
    $js_theme_asset = include THEME_PATH . '/build/js/theme.asset.php';
    $css_theme_asset = include THEME_PATH . '/build/css/theme.asset.php';

    wp_enqueue_script('frizer-scripts', THEME_URL . '/build/js/theme.js', $js_theme_asset['dependencies'], $js_theme_asset['version'], true);
    wp_enqueue_style('frizer-style', THEME_URL . '/build/css/theme.css', $css_theme_asset['dependencies'], $css_theme_asset['version']);
}

add_action('wp_enqueue_scripts', 'frizer_enqueue');




