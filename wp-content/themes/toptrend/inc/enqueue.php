<?php
//Register script
// wp_register_script(
//     'filterizr', get_template_directory_uri() . '/assets/js/filterizr.min.js', array(), '1.0.0', array('strategy'  => 'async')
// );

//Enqueue custom block styles
add_action( 'init', 'toptrend_enqueue_block_styles' );

function toptrend_enqueue_block_styles() {

    // Add the block name (with namespace) for each style.
    $blocks = array(
        'core/group',
        'core/table',
        'core/shortcode',
        'acf/filtering-gallery',
        'acf/tab-gallery',
    );

    // Loop through each block and enqueue its styles.
    foreach ( $blocks as $block ) {

        // Replace slash with hyphen for filename.
        $slug = str_replace( '/', '-', $block );

        wp_enqueue_block_style( $block, array(
            'handle' => "toptrend-block-{$slug}",
            'src'    => get_theme_file_uri( "assets/css/blocks/{$slug}.css" ),
            'path'   => get_theme_file_path( "assets/css/blocks/{$slug}.css" )
        ) );
    }
}

//Register custom block variations
add_action( 'init', 'toptrend_register_block_styles' );

function toptrend_register_block_styles() {
	register_block_style( 'core/table', array(
		'name'         => 'pricing-table',
		'label'        => __( 'Pricing Table', 'toptrend' ),
		'style_handle' => 'toptrend-block-core-table'
    ) );
}