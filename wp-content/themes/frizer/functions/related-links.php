<?php

/**
 * Internal links between each price list and its gallery (both directions).
 * Keyed by the current page slug: [target slug, link text].
 */
function frizer_related_page_links() {
    return [
        'zenske-usluge'  => ['zenske-frizure', __('Pogledajte galeriju ženskih frizura', 'frizer')],
        'muske-usluge'   => ['muske-frizure', __('Pogledajte galeriju muških frizura', 'frizer')],
        'zenske-frizure' => ['zenske-usluge', __('Pogledajte cenovnik ženskih usluga', 'frizer')],
        'muske-frizure'  => ['muske-usluge', __('Pogledajte cenovnik muških usluga', 'frizer')],
    ];
}

/**
 * Outputs the related-page button for the current page, if it has one.
 * Called at the end of the pricing-table and filtering-gallery blocks.
 */
function frizer_related_page_link() {
    $post_id = get_the_ID();
    if (!$post_id) {
        return;
    }

    $links = frizer_related_page_links();
    $slug  = get_post_field('post_name', $post_id);
    if (!isset($links[$slug])) {
        return;
    }

    [$target_slug, $label] = $links[$slug];
    $target = get_page_by_path($target_slug);
    if (!$target || get_post_status($target) !== 'publish') {
        return;
    }
    ?>
    <div class="related-page-link text-center">
        <a href="<?php echo esc_url(get_permalink($target)); ?>" class="btn btn--secondary"><?php echo esc_html($label); ?></a>
    </div>
    <?php
}
