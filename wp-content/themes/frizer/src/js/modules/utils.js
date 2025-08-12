/**
 * Runs a callback when the screen width is at most maxWidth.
 * @param {number} maxWidth - The maximum width in pixels.
 * @param {Function} callback - The function to run when the condition is met.
 */
export function onScreenMax(maxWidth, callback) {
  const mq = window.matchMedia(`(max-width: ${maxWidth}px)`);
  function check(e) {
    if (e.matches) callback();
  }
  mq.addEventListener('change', check);
  // Initial check
  if (mq.matches) callback();
}

/**
 * Runs a callback when the screen width is at least minWidth.
 * @param {number} minWidth - The minimum width in pixels.
 * @param {Function} callback - The function to run when the condition is met.
 */
export function onScreenMin(minWidth, callback) {
  const mq = window.matchMedia(`(min-width: ${minWidth}px)`);
  function check(e) {
    if (e.matches) callback();
  }
  mq.addEventListener('change', check);
  // Initial check
  if (mq.matches) callback();
}