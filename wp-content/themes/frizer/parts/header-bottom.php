<div class="header__bottom">
    <div class="container container--header">
        <div class="header__bottom__inner">
            <div id="branding" class="header__bottom__branding" itemscope itemtype="https://schema.org/Organization">
                <?php
                if (function_exists('the_custom_logo') && has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<a href="' . esc_url(home_url('/')) . '" class="site-title">' . get_bloginfo('name') . '</a>';
                }
                ?>
            </div>
            <div class="header__bottom__menu">
                <button id="mobileMenuToggle" class="mobile-menu-toggle" aria-controls="mainNav" aria-expanded="false">
                    <svg class="hamburger" viewBox="0 0 25 25" width="25" height="25">
                        <rect class="hamburger__top hamburger--line" y="2" width="25" height="3"></rect>
                        <rect class="hamburger__middle hamburger--line" y="11" width="25" height="3"></rect>
                        <rect class="hamburger__bottom hamburger--line" y="20" width="25" height="3"></rect>
                    </svg>
                </button>
                <nav id="mainNav" class="main-nav" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
                    <?php wp_nav_menu(array('theme_location' => 'main-menu', 'link_before' => '<span itemprop="name">', 'link_after' => '</span>'));
                    ?>
                </nav>
            </div>
            <button class="header__bottom__sidebar-toggle" aria-controls="slidingSidebar" aria-expanded="false">
                <svg viewBox="0 0 24 24" width="24" height="24">
                    <rect class="sliding-sidebar__top sliding-sidebar--line" y="2" width="24" height="2" rx="2"></rect>
                    <rect class="sliding-sidebar__middle sliding-sidebar--line" y="11" width="24" height="2" rx="2"></rect>
                    <rect class="sliding-sidebar__bottom sliding-sidebar--line" y="20" width="24" height="2" rx="2"></rect>
                </svg>
            </button>
        </div>
    </div>
</div>