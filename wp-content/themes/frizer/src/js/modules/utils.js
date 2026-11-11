/**
 * Runs a callback once, the first time the media query matches
 * (immediately, or later when the viewport changes).
 * @param {string} query - Media query string.
 * @param {Function} callback - Initializer to run once.
 */
function onceWhenMatches(query, callback) {
  const mq = window.matchMedia(query);

  if (mq.matches) {
    callback();
    return;
  }

  function check(e) {
    if (e.matches) {
      mq.removeEventListener('change', check);
      callback();
    }
  }
  mq.addEventListener('change', check);
}

/**
 * Runs a callback once when the screen width is at most maxWidth.
 * Initializers attach event listeners, so running them more than once
 * (e.g. on tablet rotation) would stack duplicate handlers.
 * @param {number} maxWidth - The maximum width in pixels.
 * @param {Function} callback - The function to run when the condition is met.
 */
export function onScreenMax(maxWidth, callback) {
  onceWhenMatches(`(max-width: ${maxWidth}px)`, callback);
}

/**
 * Runs a callback once when the screen width is at least minWidth.
 * @param {number} minWidth - The minimum width in pixels.
 * @param {Function} callback - The function to run when the condition is met.
 */
export function onScreenMin(minWidth, callback) {
  onceWhenMatches(`(min-width: ${minWidth}px)`, callback);
}
