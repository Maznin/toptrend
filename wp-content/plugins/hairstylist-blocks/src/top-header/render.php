<?php

/**
 * 	Dynamic Block Template.
 *	@param   array $attributes - A clean associative array of block attributes.
 * 	@param   array $block - All the block settings and attributes.
 * 	@param   string $content - The block inner HTML (usually empty unless using inner blocks).
 */
?>
<p <?php echo get_block_wrapper_attributes(); ?>>
	<?php esc_html_e('Top Header – hello from a dynamic block!', 'top-header'); ?>
</p>