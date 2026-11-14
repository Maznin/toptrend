<?php
	$cat_id = get_field('cat_id');
	$services = get_amelia_services(array('category_id' => $cat_id));
?>

<section class="pricing-table section-padding">
	<div class="container pricing-table__inner">

		<?php if (!empty($services)) : ?>
			<div class="pricing-table__list">
				<?php foreach ($services as $service) : ?>
					<div class="pricing-table__item<?php echo frizer_is_bookable_service($service->id) ? ' pricing-table__item--bookable' : ''; ?>">
						<div class="pricing-table__item__content">
							<div class="layout-help">
								<h2 class="h4 pricing-table__item__title"><?php echo esc_html($service->name) ?></h2>
								<span class="pricing-table__item__price"><?php echo esc_html($service->price); ?><span class="currency">din</span></span>
								<?php if (frizer_is_bookable_service($service->id)) : ?>
									<a href="<?php echo esc_url(frizer_booking_url($service->id)); ?>" class="pricing-table__item__book" aria-label="<?php echo esc_attr(sprintf(__('Zakaži: %s', 'frizer'), $service->name)); ?>"><span class="pricing-table__item__book__text"><?php esc_html_e('Zakaži', 'frizer'); ?></span></a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

		<?php else : ?>
			<h2 class="h4 text-center">Cenovnik trenutno nije dostupan. Kontaktirajte nas na <a href="tel:0600320705">060 / 0320705</a></h2>
		<?php endif; ?>

		<?php frizer_related_page_link(); ?>
	</div>
</section>