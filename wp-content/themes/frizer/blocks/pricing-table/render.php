<?php
	$cat_id = get_field('cat_id');
	$services = get_amelia_services(array('category_id' => $cat_id));
?>

<section class="pricing-table section-padding">
	<div class="container pricing-table__inner">

		<?php if (!empty($services)) : ?>
			<div class="pricing-table__list">
				<?php foreach ($services as $service) : ?>
					<div class="pricing-table__item">
						<div class="pricing-table__item__content">
							<div class="layout-help">
								<h2 class="h4 pricing-table__item__title"><?php echo esc_html($service->name) ?></h2>
								<span class="pricing-table__item__price"><?php echo esc_html($service->price); ?><span class="currency">din</span></span>
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