<?php
	$services = get_amelia_services(array('category_id' => 3));
?>

<section class="pricing-table section-padding">
	<div class="container pricing-table__inner">

		<?php if (!empty($services)) : ?>
			<div class="pricing-table__list">
				<?php foreach ($services as $service) : ?>
					<div class="pricing-table__item">
						<div class="pricing-table__item__content">
							<div class="layout-help">
								<h4 class="pricing-table__item__title"><?php echo esc_html($service->name) ?></h4>
								<span class="pricing-table__item__price"><?php echo esc_html($service->price); ?><span class="currency">din</span></span>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

		<?php else : ?>
			<h4 class="text-center">Cenovnik trenutno nije dostupan. Kontaktirajte nas na <a href="tel:0600320705">060 / 0320705</a></h4>
		<?php endif; ?>
	</div>
</section>