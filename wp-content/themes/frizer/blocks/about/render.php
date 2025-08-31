<?php
	$data = get_field('about');
?>

<section class="about section-padding">
	<div class="container about__inner">

		<?php if (!empty($data['image'])) : ?>
			<div class="about__images">
				<?php echo wp_get_attachment_image( $data['image'], 'full', false, array( 'loading' => 'lazy', 'class' => 'about__img' ) ); ?>
			</div>
		<?php endif; ?>
		<div class="about__content">
			<span class="section-subtitle-backdrop">
				<?php _e(esc_html($data['small_subtitle']), 'frizer') ?>
			</span>
			<span class="section-subtitle">
				<?php _e(esc_html($data['small_subtitle']), 'frizer') ?>
			</span>
			<?php if (!empty($data['subtitle'])) : ?>
				<h2 class="section-title about__title">
					<?php _e(esc_html($data['subtitle']), 'frizer') ?>
				</h2>
			<?php endif; ?>
			<?php if (!empty($data['text'])) : ?>
				<?php echo $data['text']; ?>
			<?php endif; ?>
			<?php if (!empty($data['cta_btn'])) : ?>
				<a href="<?php echo esc_url($data['cta_btn']['url']); ?>" class="btn"><?php echo esc_html($data['cta_btn']['title']); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>