<?php
	$data = get_field('about') ?: [];
	$small_subtitle = $data['small_subtitle'] ?? '';
?>

<section class="about section-padding">
	<div class="container about__inner">

		<?php if (!empty($data['image'])) : ?>
			<div class="about__images">
				<?php echo wp_get_attachment_image( $data['image'], 'full', false, array( 'loading' => 'lazy', 'class' => 'about__img' ) ); ?>
			</div>
		<?php endif; ?>
		<div class="about__content">
			<?php if (!empty($small_subtitle)) : ?>
				<span class="section-subtitle-backdrop">
					<?php echo esc_html($small_subtitle); ?>
				</span>
				<span class="section-subtitle">
					<?php echo esc_html($small_subtitle); ?>
				</span>
			<?php endif; ?>
			<?php if (!empty($data['subtitle'])) : ?>
				<h2 class="section-title about__title">
					<?php echo esc_html($data['subtitle']); ?>
				</h2>
			<?php endif; ?>
			<?php if (!empty($data['text'])) : ?>
				<?php echo wp_kses_post($data['text']); ?>
			<?php endif; ?>
			<?php if (!empty($data['cta_btn']['url'])) : ?>
				<a href="<?php echo esc_url($data['cta_btn']['url']); ?>" class="btn"><?php echo esc_html($data['cta_btn']['title'] ?? ''); ?></a>
			<?php elseif (is_page('o-nama')) : ?>
				<a href="<?php echo esc_url(frizer_booking_url()); ?>" class="btn"><?php esc_html_e('Zakažite termin', 'frizer'); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>
