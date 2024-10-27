<?php 
function toptrend_register_all_blocks() {
	// Define block directories
    $blocks = array(
        'filtering-gallery',
        'tab-gallery'
        // Add more block.json paths here
    );

	foreach ($blocks as $block) {
		register_block_type( __DIR__ .'/'. $block );
	}
}
add_action( 'init', 'toptrend_register_all_blocks' );