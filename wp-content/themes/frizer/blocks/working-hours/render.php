<?php
$booking_page = get_page_by_path('zakazivanje');
$booking_url = $booking_page ? get_permalink($booking_page) : home_url('/zakazivanje/');
?>

<section class="working-hours section-padding section-dark">
	<div class="container working-hours__inner">
		<div class="working-hours__content">
			<span class="section-subtitle-backdrop">
				<?php _e('Vreme', 'frizer') ?>
			</span>
			<span class="section-subtitle">
				<?php _e('Radno Vreme', 'frizer') ?>
			</span>
			<h2 class="section-title working-hours__title">
				Radno Vreme Salona
			</h2>
			<p class="working-hours__description">
				Naša usluga je uvek profesionalna i brza. Top Trend je mesto gde se tradicionalno frizerstvo i moderne usluge spajaju i pružaju vam iskustvo kakvo zaslužujete.
			</p>
			<ul class="working-hours__list">
				<li class="working-hours__list__item"><span>Ponedeljak</span> <span>09:30 - 20:00</span></li>
				<li class="working-hours__list__item"><span>Utorak</span> <span>09:30 - 20:00</span></li>
				<li class="working-hours__list__item"><span>Sreda</span> <span>09:30 - 20:00</span></li>
				<li class="working-hours__list__item"><span>Četvrtak</span> <span>09:30 - 20:00</span></li>
				<li class="working-hours__list__item"><span>Petak</span> <span>09:30 - 20:00</span></li>
				<li class="working-hours__list__item"><span>Subota</span> <span>09:00 - 16:00</span></li>
				<li class="working-hours__list__item"><span>Nedelja</span> <span>Zatvoreno</span></li>
			</ul>
			<a href="<?php echo esc_url($booking_url); ?>" class="btn btn--secondary"><?php _e('Zakaži Termin', 'frizer') ?></a>
		</div>
		<div class="working-hours__images">
			<img src="<?php echo get_template_directory_uri(); ?>/src/img/top-trend-zakazivanje.jpg" alt="Kalendar za zakazivanje" class="working-hours__img" />
		</div>
	</div>
</section>