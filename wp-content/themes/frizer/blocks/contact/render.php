<?php
$data = get_field('slideout_modal', 'options');
$address = $data['address'] ?? '';
$phone = $data['phone'] ?? '';
$email = $data['email'] ?? '';
?>

<section class="contact section-padding">
	<div class="container contact__inner">
		<div class="contact__info">
			<span class="section-subtitle">
				<?php _e('Kontakt', 'frizer') ?>
			</span>
			<h2 class="section-title working-hours__title">
				Kontaktirajte nas ili rezervišite
			</h2>
			<div class="contact__info__items">
				<?php if (!empty($phone)): ?>
					<div class="contact__info__item contact__info__item--phone">
						<div>
							<div class="label"><?php _e('Pozovite nas', 'frizer'); ?></div>
							<div class="value"><a href="<?php echo esc_html($phone['url']); ?>"><?php echo esc_html($phone['title']); ?></a></div>
						</div>
					</div>
				<?php endif; ?>

				<?php
				if (!empty($email)):
				?>
					<div class="contact__info__item contact__info__item--email">
						<div>
							<div class="label"><?php _e('Email', 'frizer'); ?></div>
							<div class="value"><a href="<?php echo esc_html($email['url']); ?>"><?php echo esc_html($email['title']); ?></a></div>
						</div>
					</div>
				<?php endif; ?>

				<?php
				if (!empty($address)):
				?>
					<div class="contact__info__item contact__info__item--address">
						<div>
							<div class="label"><?php _e('Adresa', 'frizer'); ?></div>
							<div class="value"><a href="<?php echo esc_html($address['url']); ?>" target="_blank"><?php echo esc_html($address['title']); ?></a></div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="contact__form">
			<?php echo do_shortcode('[contact-form-7 id="5700adc" title="Kontakt Forma"]'); ?>
		</div>
	</div>
</section>