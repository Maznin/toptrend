<?php 
function frizer_register_all_blocks() {
	// Define block directories
    $blocks = array(
        'main-hero',
        'about',
        'services',
        'working-hours',
        'testimonials',
        'gallery',
        'filtering-gallery',
        'pricing-table',
        'contact'
        // Add more block.json paths here
    );

	foreach ($blocks as $block) {
		register_block_type( __DIR__ .'/'. $block );
	}
}
add_action( 'init', 'frizer_register_all_blocks' );