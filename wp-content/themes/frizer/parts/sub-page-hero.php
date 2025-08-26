<?php
$data = get_field('sub_page_settings');
$header_show = $data['sub_page_header_show'] ?? '';
$image = $data['sub_page_hero_image'] ?? '';
?>

<?php if (!empty($header_show)) : ?>
<div class="subpage-hero <?php echo empty($image) ? 'no-image-bg' : ''; ?>" style="<?php echo !empty($image) ? "background-image: url('" . esc_url($image) . "')" : ''; ?>">
    <div class="container text-center">
        <h1 class="subpage-hero__title"><?php echo esc_html(get_the_title()); ?></h1>
        <?php
            if (function_exists('yoast_breadcrumb')) {
                yoast_breadcrumb('<div id="breadcrumbs" class="subpage-hero__breadcrumbs">', '</div>');
            }
        ?>
    </div>
</div>
<?php endif; ?>

