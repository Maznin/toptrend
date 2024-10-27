<?php
// Enable SVG
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');

// Enqueue script and styles
require 'inc/enqueue.php';

// Register ACF blocks
require 'blocks/acf/register-acf-blocks.php';