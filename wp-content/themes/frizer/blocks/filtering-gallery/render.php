<?php
if (!have_rows('gallery')) {
	return;
}

$data = get_field('gallery_filters', 'options');

// echo '<pre style="color:white;">';
// print_r($data);
// echo '</pre>';


$filters = ['all' => 'Sve'];

if (is_array($data)) {
	foreach ($data as $item) {
		if (isset($item['category_name_clean'], $item['category_name'])) {
			$filters[$item['category_name_clean']] = $item['category_name'];
		}
	}
}

?>

<section class="filtering-gallery section-padding">
	<div class="container">
		<div class="gallery-content text-center">
			<span class="section-subtitle-backdrop">
				<?php _e('Galerija', 'frizer'); ?>
			</span>
			<span class="section-subtitle">
				<?php _e('Top Trend Galerija', 'frizer'); ?>
			</span>
			<h2 class="section-title mb-60">Pogledajte naše radove</h2>
			<div class="filter-controls-wrap">
				<ul class="filter-controls">
					<?php foreach ($filters as $filter_key => $filter_label): ?>
						<li class="filter-button <?php echo $filter_key === 'all' ? 'active' : ''; ?>" data-filter="<?php echo esc_attr($filter_key); ?>">
							<?php echo esc_html($filter_label); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="filter-container">
				<?php while (have_rows('gallery')): the_row();
					$img = get_sub_field("image");
					$categories = get_sub_field("data_category");
					$filter = is_array($categories) ? implode(",", array_map('esc_attr', $categories)) : '';
				?>
					<div class="filtr-item" data-category="<?php echo esc_attr($filter); ?>" data-sort="value">
						<a href="<?php echo esc_url($img['url']); ?>" class="animated-thumb" data-fancybox="filtering-gallery" <?php echo is_admin() ? 'style="pointer-events: none;"' : ""; ?>>
							<img loading="lazy"
								decoding="async"
								width="<?php echo esc_attr($img['width']); ?>"
								height="<?php echo esc_attr($img['height']); ?>"
								src="<?php echo esc_url($img['url']); ?>"
								alt="<?php echo esc_attr($img['alt']); ?>" />
						</a>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</section>