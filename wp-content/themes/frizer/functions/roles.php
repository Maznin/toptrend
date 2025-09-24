
<?php
$user_id = 3;

function add_custom_caps_to_editor() {
    $role = get_role('wpamelia-manager');
    if ($role) {
        $role->add_cap('edit_posts');
        $role->add_cap('edit_pages');
        $role->add_cap('edit_others_posts');
        $role->add_cap('edit_others_pages');
        $role->add_cap('edit_published_posts');
        $role->add_cap('edit_published_pages');
        $role->add_cap('upload_files');
        $role->add_cap('edit_media');
    }
}
add_action('init', 'add_custom_caps_to_editor');

// function frizer_remove_cf7_menu_pages() {

//     if ( current_user_can( 'wpamelia-manager' ) && !current_user_can( 'administrator' ) ) {
//         remove_menu_page('wpcf7'); // Contact Form 7 Menu
//     }
// }
// add_action( 'admin_init', 'frizer_remove_cf7_menu_pages' );