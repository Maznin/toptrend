<?php

/**
 * Functions and definitions.
 */
define('THEME_URL', get_template_directory_uri());
define('THEME_PATH', get_template_directory());


// Include files from the functions directory
require_once THEME_PATH . '/functions/assets.php';
require_once THEME_PATH . '/functions/setup.php';
require_once THEME_PATH . '/functions/roles.php';
require_once THEME_PATH . '/blocks/register-acf-blocks.php';

