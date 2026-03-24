<?php
$booking_page = get_page_by_path('zakazivanje');
$booking_url = $booking_page ? get_permalink($booking_page) : home_url('/zakazivanje/');
?>

<section class="hero">
	<div class="container hero__inner">
		<div class="hero__content">
			<span class="hero__subtitle section-subtitle">Dobrodošli u naš salon</span>
			<h1 class="hero__title">
				Za nas ste uvek na prvom mestu
			</h1>
			<p class="hero__desc">
				Mi Vam predlažemo da ne rizikujete kod kuće i da dođete u naš salon Top Trend 018
			</p>
			<a href="<?php echo esc_url($booking_url); ?>" class="hero__btn btn" data-booking-cta data-booking-source="hero">
				Zakažite termin<span class="btn__icon"></span>
			</a>
		</div>
		<div class="hero__images">
			<img src="<?php echo get_template_directory_uri(); ?>/src/img/top-trend-018-frizerski-salon-1.jpg" width="645" height="484" alt="Slika Salona" class="hero__img" />
		</div>
	</div>
</section>