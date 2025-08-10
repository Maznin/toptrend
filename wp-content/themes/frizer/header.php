<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header class="header" role="banner">
        <!-- Header Top -->
        <?php get_template_part('parts/header-top'); ?>
        <!-- Header Bottom -->
        <?php get_template_part('parts/header-bottom'); ?>
    </header>
    <main id="content" role="main">