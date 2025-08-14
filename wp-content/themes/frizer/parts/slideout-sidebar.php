<div class="slideout">
    <div class="slideout__header">
        <div class="logo">
            <?php 
                if (function_exists('the_custom_logo') && has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<a href="' . esc_url(home_url('/')) . '" class="site-title">' . get_bloginfo('name') . '</a>';
                }
            ?>
            <span><?php bloginfo('name'); ?></span>
        </div>
        <button class="slideout__close">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="0 0 24 24">
                <path stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16 16-4-4m0 0L8 8m4 4 4-4m-4 4-4 4" />
            </svg>
        </button>
    </div>
    <div class="slideout__content">
        <p class="description">
            "Haircut" is a term used to describe when a person removes the hair on their head. This is done to allow for better access to the part of the body that needs cutting.
        </p>
        <div class="image-container">
            <img src="barber.jpg" alt="Barber at work">
        </div>
        <div class="contact-info">
            <h2>Contact Info</h2>
            <div class="contact-item">
                <span class="icon phone"></span>
                <div>
                    <div class="label">Call Now</div>
                    <div class="value">+125 (895) 658 568</div>
                </div>
            </div>
            <div class="contact-item">
                <span class="icon email"></span>
                <div>
                    <div class="label">Quick Email</div>
                    <div class="value">info.help@gmail.com</div>
                </div>
            </div>
            <div class="contact-item">
                <span class="icon location"></span>
                <div>
                    <div class="label">Office Address</div>
                    <div class="value">PV3M+X68 Welshpool United Kingdom</div>
                </div>
            </div>
        </div>
        <div class="socials">
            <a href="#"><span class="icon behance"></span></a>
            <a href="#"><span class="icon facebook"></span></a>
            <a href="#"><span class="icon linkedin"></span></a>
        </div>
    </div>
</div>