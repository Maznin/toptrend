<?php
/**
 * ACF Call to action Block template.
 *
 * @param array $block The block settings and attributes.
 * @param boolean $is_preview True during preview render
 * @param array $context any context variables from parent blocks if applicable
 */

$classes = get_block_wrapper_attributes(array('class' => 'filtering-gallery'));
$gallery = get_field('woman_hairstyle_gallery');
$size = 'full';
?>

<div class="tab-gallery-container">
  <?php if ($gallery) { ?>
    <div class="woman_hairstyle_gallery tab-gallery">
      <?php foreach ($gallery as $key=>$img) {

        if ($key == 0 ) { ?>
          <div class="grid-sizer"></div>
        <?php } ?>
        
        <div class="filtr-item grid-item">
          <a href="<?php echo $img['url']; ?>" <?php echo (is_admin()) ? 'style="pointer-events: none;"' : ""; ?>>
            <?php echo wp_get_attachment_image( $img['id'], $size ); ?>
          </a>
        </div>

      <?php } ?>
    </div>
  <?php } ?>
  <!-- <div class="man_hairstyle_gallery"></div> -->
</div>
