import { initNavigation } from './modules/navigation.js';
import { initSlideout } from './modules/slideout-modal.js';
import { onScreenMax, onScreenMin } from './modules/utils.js';
import { onFirstUserInteraction } from './modules/user-interaction-init.js';
import { fancyBoxGallery } from './modules/fancybox.js';
import { headerBanner } from './modules/headerBanner.js';
import { initClickTracking } from './modules/clickTracking.js';
import { initBookingBar } from './modules/bookingBar.js';

function initializeScript() {
  fancyBoxGallery();

  onScreenMin(769, () => {
    initSlideout();
  });
  onScreenMax(991, () => {
    initNavigation();
  });
}

// Registered right away (not deferred): the first click is often the first interaction.
initClickTracking();
initBookingBar();
headerBanner();
onFirstUserInteraction(initializeScript);