<?php
	$gallery = get_field('gallery');
?>

<section class="gallery section-padding section-dark">
	<div class="container container--full gallery__inner">
		<div class="gallery-content text-center">
			<span class="section-subtitle-backdrop">
				<?php _e('Galerija', 'frizer') ?>
			</span>
			<span class="section-subtitle">
				<?php _e('Top Trend Galerija', 'frizer') ?>
			</span>
			<h2 class="section-title mb-60">Pogledajte naše radove</h2>
		</div>
		<?php if( $gallery ): ?>
			<div class="gallery__items mb-50">
				<?php foreach( $gallery as $image ): 
					?>
					<div class="gallery__item">
						<a href="<?php echo esc_url( $image['image']['url'] ); ?>" data-fancybox="gallery" class="animated-thumb">
							<?php echo wp_get_attachment_image( $image['image']['id'], 'medium', false, array( 'loading' => 'lazy' ) ); ?>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="btn-wrapper text-center">
				<a href="/galerija/" class="btn btn--secondary"><?php _e('Pogledajte galeriju', 'frizer'); ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>