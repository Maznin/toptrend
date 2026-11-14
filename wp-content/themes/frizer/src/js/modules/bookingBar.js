/**
 * Mobile booking bar (#bookingBar): hidden on page load, slides in once the visitor
 * has scrolled about half a screen. Pages too short to scroll that far show it at once.
 * The bar itself is hidden by CSS from 992px up.
 */
export function initBookingBar() {
  const bar = document.getElementById('bookingBar');
  if (!bar) {
    return;
  }

  let ticking = false;

  const update = () => {
    ticking = false;
    const threshold = Math.min(window.innerHeight * 0.5, 400);
    const maxScroll = document.documentElement.scrollHeight - window.innerHeight;
    const visible = window.scrollY > threshold || maxScroll < threshold;
    bar.classList.toggle('is-visible', visible);
  };

  window.addEventListener(
    'scroll',
    () => {
      if (!ticking) {
        ticking = true;
        window.requestAnimationFrame(update);
      }
    },
    { passive: true }
  );
  window.addEventListener('resize', update, { passive: true });
  update();
}
