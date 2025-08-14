import { initNavigation } from './modules/navigation.js';
import { initSlideout } from './modules/slideout-modal.js';
import { onScreenMax, onScreenMin } from './modules/utils.js';

document.addEventListener('DOMContentLoaded', () => {
  
  onScreenMin(769, () => {
    initSlideout();
  });

  onScreenMax(768, () => {
    initNavigation();
  });
});