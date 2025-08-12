import { initNavigation } from './modules/navigation.js';
import { onScreenMax, onScreenMin } from './modules/utils.js';

document.addEventListener('DOMContentLoaded', () => {
  onScreenMax(768, () => {
    initNavigation();
  });
});