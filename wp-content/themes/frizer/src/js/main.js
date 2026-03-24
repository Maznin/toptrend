import { initNavigation } from './modules/navigation.js';
import { initSlideout } from './modules/slideout-modal.js';
import { onScreenMax, onScreenMin } from './modules/utils.js';
import { onFirstUserInteraction } from './modules/user-interaction-init.js';
import { fancyBoxGallery } from './modules/fancybox.js';
import { headerBanner } from './modules/headerBanner.js';
import { initBookingTracking } from './modules/booking-tracking.js';

function initializeScript() {
  fancyBoxGallery();

  onScreenMin(769, () => {
    initSlideout();
  });
  onScreenMax(991, () => {
    initNavigation();
  });
}

initBookingTracking();
headerBanner();
onFirstUserInteraction(initializeScript);