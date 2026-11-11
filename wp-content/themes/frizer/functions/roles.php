<?php

/**
 * Grants content-editing capabilities to Amelia's manager role.
 *
 * Capabilities are stored in the database, so this only needs to run once.
 * Bump FRIZER_ROLES_VERSION to re-apply after changing the list.
 */
const FRIZER_ROLES_VERSION = 1;

function frizer_add_amelia_manager_caps() {
    if ((int) get_option('frizer_roles_version') === FRIZER_ROLES_VERSION) {
        return;
    }

    $role = get_role('wpamelia-manager');
    if (!$role) {
        return; // Amelia not active yet; try again on a later request.
    }

    $caps = [
        'edit_posts',
        'edit_pages',
        'edit_others_posts',
        'edit_others_pages',
        'edit_published_posts',
        'edit_published_pages',
        'upload_files',
        'edit_media',
    ];
    foreach ($caps as $cap) {
        $role->add_cap($cap);
    }

    update_option('frizer_roles_version', FRIZER_ROLES_VERSION);
}
add_action('init', 'frizer_add_amelia_manager_caps');
