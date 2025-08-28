<?php
	$pricing_table = get_field('pricing_table');
?>

<section class="pricing-table section-padding">
	<div class="container pricing-table__inner">

		<?php if (!empty($pricing_table)) : ?>
			<div class="pricing-table__list">
				<?php foreach ($pricing_table as $item) : ?>
					<div class="pricing-table__item">
						<?php if (!empty($item['image'])) : ?>
							<div class="pricing-table__item__img">
								<?php echo wp_get_attachment_image($item['image'], 'full', false, array('class' => 'w-100 d-block')); ?>
							</div>
						<?php endif; ?>
						<div class="pricing-table__item__content">
							<div class="layout-help">
								<h4 class="pricing-table__item__title"><?php echo esc_html($item['usluga']); ?></h4>
								<span class="pricing-table__item__price"><?php echo esc_html($item['cena']); ?><span class="currency">din</span></span>
							</div>
							<?php if (!empty($item['short_description'])) : ?>
								<p class="pricing-table__item__description mb-0"><?php echo esc_html($item['short_description']); ?></p>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>