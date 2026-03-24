// user-interaction-init.js
// Initializes a callback after the first meaningful user interaction.
// Uses early events (pointerdown/touchstart) so click handlers are attached before click fires.

export function onFirstUserInteraction(callback) {

  console.log('onFirstUserInteraction initialized');

  let initialized = false;

  const events = [
    { name: 'pointerdown', options: { capture: true, passive: true } },
    { name: 'touchstart', options: { capture: true, passive: true } },
    { name: 'keydown', options: { capture: true } },
    { name: 'scroll', options: { passive: true } },
    { name: 'mousemove', options: { passive: true } },
  ];

  function removeListeners() {
    events.forEach(({ name, options }) => {
      window.removeEventListener(name, handler, options);
    });
  }

  function handler() {
    if (initialized) {
      return;
    }

    initialized = true;
    callback();
    removeListeners();
  }

  events.forEach(({ name, options }) => {
    window.addEventListener(name, handler, options);
  });
}
