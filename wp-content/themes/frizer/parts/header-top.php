<?php
$data = get_field('top_header', 'options');
$address = $data['location'] ?? '';
$work_hours = $data['work_hours'] ?? '';
$social_networks = $data['social_networks'] ?? '';
$phone_number = $data['phone_number'] ?? '';
?>

<?php if (!empty($data) && array_filter($data)) : ?>
    <div class="header__top">
        <div class="container container--header header__top__inner">
            <div class="header__top__left">
                <?php if (!empty($address)) : ?>
                    <address class="header__top__address">
                        <a href="<?php echo esc_url($address['url']); ?>" target="_blank" rel="noopener noreferrer">
                            <span><?php esc_html_e('Adresa :', 'frizer'); ?></span>
                            <?php echo esc_html($address['title']); ?>
                        </a>
                    </address>
                <?php endif; ?>
                <?php if (!empty($work_hours)) : ?>
                    <div class="header__top__work-hours">
                        <span><?php echo esc_html($work_hours); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="header__top__right">
                <ul class="header__top__socials">
                    <?php if (!empty($social_networks)) : ?>
                        <?php foreach ($social_networks as $network) : ?>
                            <li>
                                <a
                                    href="<?php echo esc_url($network['link']['url']); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer">
                                    <img
                                        src="<?php echo esc_url($network['icon']['url']); ?>"
                                        width="<?php echo esc_attr($network['icon']['width']); ?>"
                                        height="<?php echo esc_attr($network['icon']['height']); ?>"
                                        <?php if (!empty($network['icon']['alt'])) : ?>
                                        alt="<?php echo esc_attr($network['icon']['alt']); ?>"
                                        <?php endif; ?>>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <?php if (!empty($phone_number)) : ?>
                    <div class="header__top__phone">
                        <a href="<?php echo esc_url($phone_number['url']); ?>">
                            <span><?php esc_html_e('Telefon:', 'frizer'); ?></span>
                            <?php echo esc_html($phone_number['title']); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>