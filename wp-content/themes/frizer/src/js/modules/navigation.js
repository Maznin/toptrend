export function initNavigation() {
  const navToggle = document.querySelector('#mobileMenuToggle');
  const navMenu = document.querySelector('.main-nav');

  if (navToggle && navMenu) {
    navToggle.addEventListener('click', () => {
      navMenu.classList.toggle('is-open');
      navToggle.classList.toggle('is-active');
      navToggle.setAttribute('aria-expanded', navMenu.classList.contains('is-open').toString());
    });
  }

  // Sub-menu logic
  const subMenuToggles = document.querySelectorAll('.menu-item-has-children');
  subMenuToggles.forEach(toggle => {
    const subMenu = toggle.querySelector('.sub-menu');

    if (subMenu && subMenu.classList.contains('sub-menu')) {
      toggle.addEventListener('click', (e) => {
        // Prevent toggling if clicking inside the submenu
        if (subMenu.contains(e.target)) return;
        e.preventDefault();

        subMenu.classList.toggle('is-open');
        toggle.classList.toggle('is-active');
        toggle.setAttribute('aria-expanded', subMenu.classList.contains('is-open').toString());
      });
    }
  });
}