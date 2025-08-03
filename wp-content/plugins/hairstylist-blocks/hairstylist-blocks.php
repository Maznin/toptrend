<?php
/**
 * Plugin Name:       Hairstylist Blocks
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       hairstylist-blocks
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Init blocks
function create_block_hairstylist_blocks_block_init() {
	// Generates an array of directory paths based on the build folder
	$block_directories = glob(__DIR__ . "/build/*", GLOB_ONLYDIR);

	foreach ($block_directories as $block) {
		register_block_type( $block );
	}
}
add_action( 'init', 'create_block_hairstylist_blocks_block_init' );

// Add block categories to top on the editor inserter
function custom_block_category( $categories, $post ) {
    return array_merge(
        array(
            array(
                'slug' => 'frizer-custom-blocks',
                'title' => 'Frizer Custom Blocks',
            ),
        ),
        $categories
    );
}
add_filter( 'block_categories_all', 'custom_block_category', 10, 2);
