// user-interaction-init.js
// Initializes a callback after the first user interaction (click, scroll, keydown, mousemove, or touchstart)

export function onFirstUserInteraction(callback) {
  let initialized = false;
  function handler() {
    if (!initialized) {
      callback();
      initialized = true;
      window.removeEventListener('click', handler);
      window.removeEventListener('scroll', handler);
      window.removeEventListener('keydown', handler);
      window.removeEventListener('mousemove', handler);
      window.removeEventListener('touchstart', handler);
    }
  }
  window.addEventListener('click', handler);
  window.addEventListener('scroll', handler);
  window.addEventListener('keydown', handler);
  window.addEventListener('mousemove', handler);
  window.addEventListener('touchstart', handler);
}
