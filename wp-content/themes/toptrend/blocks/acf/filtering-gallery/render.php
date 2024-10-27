<?php
/**
 * ACF Call to action Block template.
 *
 * @param array $block The block settings and attributes.
 * @param boolean $is_preview True during preview render
 * @param array $context any context variables from parent blocks if applicable
 */

$classes = get_block_wrapper_attributes(array('class' => 'filtering-gallery'));
?>
<div <?php echo $classes; ?> >
  <ul class="filter-controls">
    <!-- For filtering controls add -->
    <li data-filter="all">Sve</li>
    <li data-filter="sisanje">Šišanje</li>
    <li data-filter="feniranje">Feniranje</li>
    <li data-filter="farbanje">Farbanje</li>
    <li data-filter="frizure">Frizure</li>
  </ul>
  
  <?php if (have_rows('gallery')) { ?>
    <div class="filter-container">
      <?php while (have_rows('gallery')) { the_row(); 
      $img = get_sub_field("image");
      $categories = get_sub_field("data_category");
      $filter = implode(",", $categories); ?>

      <div class="filtr-item" data-category="<?php echo $filter; ?>" data-sort="value">
        <a href="<?php echo $img['url']; ?>" <?php echo (is_admin()) ? 'style="pointer-events: none;"' : ""; ?>>
          <img loading="lazy" 
            decoding="async" 
            width="<?php echo $img['width']; ?>"
            height="<?php echo $img['height']; ?>"
            src="<?php echo $img['url']; ?>" 
            alt="<?php echo $img['alt']; ?>" 
            />
        </a>
      </div>

      <?php } ?>
    </div>
  <?php } ?>
</div>
