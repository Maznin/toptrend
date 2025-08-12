export function initNavigation() {
  const navToggle = document.querySelector('#mobileMenuToggle');
  const navMenu = document.querySelector('.main-nav');

  if (!navToggle || !navMenu) return;

  navToggle.addEventListener('click', () => {
    navMenu.classList.toggle('is-open');
    navToggle.classList.toggle('is-active');
    navToggle.setAttribute('aria-expanded', navMenu.classList.contains('is-open').toString());
  });
}