<?php
$banner_content = get_field('header_banner_content', 'options');
$banner_type = get_field('header_banner_type', 'options') ?: 'promo';
$banner_cta_link = get_field('header_banner_link', 'options');

$banner_repeat = function_exists('get_field') ? (bool) get_field('header_banner_repeat', 'options') : false;
$banner_dismissed = false;
if (!$banner_repeat && !empty($_SESSION['banner_dismissed'])) {
    $banner_dismissed = true;
}

$hide_banner_on_current_page = false;
if ($banner_cta_link && !empty($banner_cta_link['url'])) {
    global $wp;
    $current_url = is_singular() ? get_permalink() : home_url(add_query_arg([], $wp->request));

    $banner_parts = wp_parse_url($banner_cta_link['url']);
    $current_parts = wp_parse_url($current_url);

    if ($banner_parts && $current_parts) {
        $banner_base = (isset($banner_parts['scheme']) ? $banner_parts['scheme'] . '://' : '') . ($banner_parts['host'] ?? '') . ($banner_parts['path'] ?? '');
        $current_base = (isset($current_parts['scheme']) ? $current_parts['scheme'] . '://' : '') . ($current_parts['host'] ?? '') . ($current_parts['path'] ?? '');

        if (untrailingslashit(strtolower($banner_base)) === untrailingslashit(strtolower($current_base))) {
            $hide_banner_on_current_page = true;
        }
    }
}

if ($banner_content && !$hide_banner_on_current_page && !$banner_dismissed): ?>
<div class="header__banner header__banner--<?php echo esc_attr($banner_type); ?>">
    <div class="">
        <div class="header__banner__content">
            <div class="header__banner__text">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="20" fill-rule="evenodd" clip-rule="evenodd" image-rendering="optimizeQuality" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" viewBox="0 0 347 511.82"><path fill-rule="nonzero" d="M129.03 270.69 8.31 259.3c-5.04-.47-8.74-4.95-8.27-9.99.11-1.12.41-2.18.88-3.14L110.71 5.39c1.53-3.37 4.86-5.35 8.34-5.36L269.88 0c5.08 0 9.2 4.12 9.2 9.2 0 2.06-.67 3.95-1.81 5.49l-77.26 125.3 138.81 15.28c5.04.55 8.68 5.09 8.12 10.13a9.097 9.097 0 0 1-2.46 5.31L62.93 508.52c-3.23 3.89-9.01 4.42-12.9 1.18-3.04-2.52-4.03-6.6-2.77-10.12l81.77-228.89z"/></svg>
                <?php echo wp_kses_post($banner_content); ?>
            </div>

            <?php if ($banner_cta_link): ?>
            <a href="<?php echo esc_url($banner_cta_link['url']); ?>" class="header__banner__cta">
                <?php echo esc_html($banner_cta_link['title']); ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                    <path d="M13.233 16.457a.75.75 0 1 0 1.034 1.086l-1.034-1.086Zm6.284-3.914a.75.75 0 1 0-1.034-1.086l1.034 1.086Zm-1.034 0a.75.75 0 1 0 1.034-1.086l-1.034 1.086Zm-4.216-6.086a.75.75 0 1 0-1.034 1.086l1.034-1.086ZM19 12.75a.75.75 0 0 0 0-1.5v1.5Zm-14-1.5a.75.75 0 0 0 0 1.5v-1.5Zm9.267 6.293 5.25-5-1.034-1.086-5.25 5 1.034 1.086Zm5.25-6.086-5.25-5-1.034 1.086 5.25 5 1.034-1.086ZM19 11.25H5v1.5h14v-1.5Z"/>
                </svg>
            </a>
            <?php endif; ?>

            <button class="header__banner__close" aria-label="Close banner">&times;</button>
        </div>
    </div>
</div>
<?php endif; ?>