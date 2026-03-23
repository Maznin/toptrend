<?php
$data = get_field('contact_info', 'options');
$text = $data['text'] ?? '';
$image = $data['image'] ?? '';
$address = $data['address'] ?? '';
$phones = $data['phones'] ?? [];
$email = $data['email'] ?? '';
$facebook = $data['facebook_link'] ?? '';
$instagram = $data['instagram_link'] ?? '';
?>

<div class="slideout">
    <div class="slideout__header">
        <div class="slideout__header__logo">
            <span><?php bloginfo('name'); ?></span>
        </div>
        <button class="slideout__header__close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16 16-4-4m0 0L8 8m4 4 4-4m-4 4-4 4" />
            </svg>
        </button>
    </div>
    <div class="slideout__content">
        <?php if (!empty($text)): ?>
            <p class="description">
                <?php echo esc_html(wp_strip_all_tags($text)); ?>
            </p>
        <?php endif; ?>
        <?php if (!empty($image)): ?>
            <div class="image-container">
                <?php echo wp_get_attachment_image($image, 'medium'); ?>
            </div>
        <?php endif; ?>
        <div class="contact-info">
            <h2><?php _e('Kontakt', 'frizer'); ?></h2>
            <?php if (!empty($phones)): ?>
                <div class="label phone-label"><?php _e('Pozovite nas', 'frizer'); ?></div>
                <?php foreach ($phones as $phone): ?>
                    <div class="contact-item contact-item--phone">
                        <div>
                            <div class="value"><a href="<?php echo esc_html($phone['phone']['url']); ?>"><?php echo esc_html($phone['phone']['title']); ?></a></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php
            if (!empty($email)):
            ?>
                <div class="contact-item contact-item--email">
                    <div>
                        <div class="label"><?php _e('Email', 'frizer'); ?></div>
                        <div class="value"><a href="<?php echo esc_html($email['url']); ?>"><?php echo esc_html($email['title']); ?></a></div>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            if (!empty($address)):
            ?>
                <div class="contact-item contact-item--address">
                    <div>
                        <div class="label"><?php _e('Adresa', 'frizer'); ?></div>
                        <div class="value"><a href="<?php echo esc_html($address['url']); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($address['title']); ?></a></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="socials">
            <?php if (!empty($facebook)): ?>
                <a href="<?php echo esc_url($facebook['url']); ?>" target="_blank" rel="noopener noreferrer">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 32 32">
                        <path d="m21.95 5.005-3.306-.004c-3.206 0-5.277 2.124-5.277 5.415v2.495H10.05v4.515h3.317l-.004 9.575h4.641l.004-9.575h3.806l-.003-4.514h-3.803v-2.117c0-1.018.241-1.533 1.566-1.533l2.366-.001.01-4.256z" />
                    </svg>
                </a>
            <?php endif; ?>
            <?php if (!empty($instagram)): ?>
                <a href="<?php echo esc_url($instagram['url']); ?>" target="_blank" rel="noopener noreferrer">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24">
                        <g fill="#fff">
                            <path fill-rule="evenodd" d="M12 18a6 6 0 1 0 0-12 6 6 0 0 0 0 12Zm0-2a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" clip-rule="evenodd" />
                            <path d="M18 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2Z" />
                            <path fill-rule="evenodd" d="M1.654 4.276C1 5.56 1 7.24 1 10.6v2.8c0 3.36 0 5.04.654 6.324a6 6 0 0 0 2.622 2.622C5.56 23 7.24 23 10.6 23h2.8c3.36 0 5.04 0 6.324-.654a6 6 0 0 0 2.622-2.622C23 18.44 23 16.76 23 13.4v-2.8c0-3.36 0-5.04-.654-6.324a6 6 0 0 0-2.622-2.622C18.44 1 16.76 1 13.4 1h-2.8c-3.36 0-5.04 0-6.324.654a6 6 0 0 0-2.622 2.622ZM13.4 3h-2.8c-1.713 0-2.878.002-3.778.075-.877.072-1.325.202-1.638.361a4 4 0 0 0-1.748 1.748c-.16.313-.29.761-.36 1.638C3.001 7.722 3 8.887 3 10.6v2.8c0 1.713.002 2.878.075 3.778.072.877.202 1.325.361 1.638a4 4 0 0 0 1.748 1.748c.313.16.761.29 1.638.36.9.074 2.065.076 3.778.076h2.8c1.713 0 2.878-.002 3.778-.075.877-.072 1.325-.202 1.638-.361a4 4 0 0 0 1.748-1.748c.16-.313.29-.761.36-1.638.074-.9.076-2.065.076-3.778v-2.8c0-1.713-.002-2.878-.075-3.778-.072-.877-.202-1.325-.361-1.638a4 4 0 0 0-1.748-1.748c-.313-.16-.761-.29-1.638-.36C16.278 3.001 15.113 3 13.4 3Z" clip-rule="evenodd" />
                        </g>
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>