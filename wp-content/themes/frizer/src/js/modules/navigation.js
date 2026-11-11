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

  // Keyboard support for href-less submenu toggles (<a role="button">): Enter/Space act as a click.
  document.querySelectorAll('.menu-item__toggle').forEach(control => {
    control.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        control.click();
      }
    });
  });

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

        // aria-expanded belongs on the control, not the <li>.
        const control = toggle.querySelector(':scope > .menu-item__toggle, :scope > a');
        control?.setAttribute('aria-expanded', subMenu.classList.contains('is-open').toString());
      });
    }
  });
}