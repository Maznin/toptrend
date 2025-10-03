<?php
$data = get_field('contact_info', 'options');

// Contact info
$contacts = [
    'address' => $data['address'] ?? null,
    'phones'   => $data['phones'] ?? null,
    'email'   => $data['email'] ?? null,
];

// Social links
$socials = [
    'facebook'  => [
        'url' => $data['facebook_link']['url'] ?? '',
        'icon' => '<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 32 32"><path d="m21.95 5.005-3.306-.004c-3.206 0-5.277 2.124-5.277 5.415v2.495H10.05v4.515h3.317l-.004 9.575h4.641l.004-9.575h3.806l-.003-4.514h-3.803v-2.117c0-1.018.241-1.533 1.566-1.533l2.366-.001.01-4.256z"/></svg>'
    ],
    'instagram' => [
        'url' => $data['instagram_link']['url'] ?? '',
        'icon' => '<svg class="icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"><g><path fill-rule="evenodd" d="M12 18a6 6 0 1 0 0-12 6 6 0 0 0 0 12Zm0-2a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" clip-rule="evenodd" /><path d="M18 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2Z" /><path fill-rule="evenodd" d="M1.654 4.276C1 5.56 1 7.24 1 10.6v2.8c0 3.36 0 5.04.654 6.324a6 6 0 0 0 2.622 2.622C5.56 23 7.24 23 10.6 23h2.8c3.36 0 5.04 0 6.324-.654a6 6 0 0 0 2.622-2.622C23 18.44 23 16.76 23 13.4v-2.8c0-3.36 0-5.04-.654-6.324a6 6 0 0 0-2.622-2.622C18.44 1 16.76 1 13.4 1h-2.8c-3.36 0-5.04 0-6.324.654a6 6 0 0 0-2.622 2.622ZM13.4 3h-2.8c-1.713 0-2.878.002-3.778.075-.877.072-1.325.202-1.638.361a4 4 0 0 0-1.748 1.748c-.16.313-.29.761-.36 1.638C3.001 7.722 3 8.887 3 10.6v2.8c0 1.713.002 2.878.075 3.778.072.877.202 1.325.361 1.638a4 4 0 0 0 1.748 1.748c.313.16.761.29 1.638.36.9.074 2.065.076 3.778.076h2.8c1.713 0 2.878-.002 3.778-.075.877-.072 1.325-.202 1.638-.361a4 4 0 0 0 1.748-1.748c.16-.313.29-.761.36-1.638.074-.9.076-2.065.076-3.778v-2.8c0-1.713-.002-2.878-.075-3.778-.072-.877-.202-1.325-.361-1.638a4 4 0 0 0-1.748-1.748c-.313-.16-.761-.29-1.638-.36C16.278 3.001 15.113 3 13.4 3Z" clip-rule="evenodd" /></g></svg>'
    ]
];
?>

</main>
<footer id="site-footer" class="footer" role="contentinfo">
    <div class="footer__inner container">
        <div class="footer__cols">
            <div class="footer__col footer__col--logo">
                <div class="footer__logo">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/src/img/top-trend-logo-beo.png'); ?>" width="200" height="58" loading="lazy" alt="<?php esc_attr_e('Top Trend Logo Beo', 'frizer'); ?>">
                </div>
                <div class="footer__description">
                    <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
            </div>
            <?php if (has_nav_menu('footer')) : ?>
                <div class="footer__col footer__col--nav">
                    <h5 class="footer__col__title"><?php esc_html_e('Strane', 'frizer'); ?></h5>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer__nav',
                        'container'      => false,
                    ));
                    ?>
                </div>
            <?php endif; ?>
            <div class="footer__col footer__col--contact">
                <h5 class="footer__col__title"><?php esc_html_e('Kontakt', 'frizer'); ?></h5>
                <div class="footer__col__contact">
                    <?php if (!empty($contacts['phones'])): ?>
                        <?php foreach ($contacts['phones'] as $phone): ?>
                            <?php if (!empty($phone['phone']) && !empty($phone['phone']['url']) && !empty($phone['phone']['title'])): ?>
                                <div class="contact-item contact-item--phone">
                                    <div class="value"><a href="<?php echo esc_url($phone['phone']['url']); ?>"><?php echo esc_html($phone['phone']['title']); ?></a></div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <?php foreach (['address', 'email'] as $type): ?>
                        <?php if (!empty($contacts[$type]) && !empty($contacts[$type]['url']) && !empty($contacts[$type]['title'])): ?>
                            <div class="contact-item contact-item--<?php echo esc_attr($type); ?>">
                                <div class="value"><a href="<?php echo esc_url($contacts[$type]['url']); ?>" <?php echo $type === 'address' ? ' target="_blank"' : ''; ?>><?php echo esc_html($contacts[$type]['title']); ?></a></div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="footer__col footer__col--socials">
                <h5 class="footer__col__title"><?php esc_html_e('Pratite Nas', 'frizer'); ?></h5>
                <div class="footer__col__socials">
                    <?php foreach ($socials as $name => $social): ?>
                        <?php if (!empty($social['url'])): ?>
                            <a href="<?php echo esc_url($social['url']); ?>" class="socials-item" target="_blank">
                                <?php echo $social['icon']; ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>
    <div class="footer__copyright">
        Copyright &copy; <?php echo esc_html(date_i18n(__('Y', 'frizer'))); ?> <?php echo esc_html(get_bloginfo('name')); ?>
    </div>
</footer>
<?php get_template_part('parts/slideout-sidebar'); ?>
<?php wp_footer(); ?>
</body>

</html>