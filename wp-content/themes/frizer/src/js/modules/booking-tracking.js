function emitTrackingEvent(eventName, params = {}, options = {}) {
  const debugModeEnabled = (() => {
    try {
      const queryParams = new URLSearchParams(window.location.search);
      return queryParams.get('ga_debug') === '1' || window.localStorage.getItem('frizer_ga_debug') === '1';
    } catch (error) {
      return false;
    }
  })();

  const payload = {
    page_path: window.location.pathname,
    page_title: document.title,
    ...params,
  };

  if (debugModeEnabled) {
    payload.debug_mode = true;
  }

  if (typeof window.gtag === 'function') {
    const eventPayload = {
      ...payload,
    };

    if (typeof options.eventCallback === 'function') {
      eventPayload.event_callback = options.eventCallback;
      eventPayload.event_timeout = options.eventTimeout || 1200;
    }

    window.gtag('event', eventName, eventPayload);
  } else {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
      event: eventName,
      ...payload,
    });
  }

  document.dispatchEvent(
    new CustomEvent('frizer:tracking', {
      detail: {
        event: eventName,
        payload,
      },
    })
  );
}

function getClosestBookingCta(target) {
  return target.closest('[data-booking-cta]');
}

function normalizeText(value) {
  return (value || '')
    .replace(/\s+/g, ' ')
    .trim();
}

function containsBookingSuccessText(text) {
  if (!text) {
    return false;
  }

  const normalized = normalizeText(text).toLowerCase();
  const hasSuccessSignal =
    normalized.includes('thank you') ||
    normalized.includes('success') ||
    normalized.includes('confirmed') ||
    normalized.includes('successfully booked') ||
    normalized.includes('appointment confirmed') ||
    normalized.includes('hvala') ||
    normalized.includes('uspes') ||
    normalized.includes('uspes') ||
    normalized.includes('potvrdjen') ||
    normalized.includes('potvrden');
  const hasBookingSignal =
    normalized.includes('reservation') ||
    normalized.includes('booking') ||
    normalized.includes('appointment') ||
    normalized.includes('booked') ||
    normalized.includes('rezerv') ||
    normalized.includes('zakaz') ||
    normalized.includes('termin');

  return normalized.includes('thank you') || normalized.includes('successfully booked') || (hasSuccessSignal && hasBookingSignal);
}

function createTrackedEventGuard() {
  const sent = new Set();

  return function hasSent(key) {
    if (sent.has(key)) {
      return true;
    }

    sent.add(key);
    return false;
  };
}

function getAmeliaContainer() {
  return document.querySelector('#amelia-container');
}

function getActiveAmeliaStep(container) {
  if (!container) {
    return '';
  }

  const stepSelectors = [
    '.am-fs-sb__step.-active p',
    '.am-fs-sb__step.--active p',
    '.am-fs-sb__step.active p',
    '.am-fs-sb__step.-active .am-fs-sb__step-name',
    '.am-fs-sb__step.--active .am-fs-sb__step-name',
    '.am-fs-sb__step.active .am-fs-sb__step-name',
    '.am-fs__main-content h1',
    '.am-fs__main-content h2',
    '.am-fs__main-content h3',
  ];

  for (const selector of stepSelectors) {
    const node = container.querySelector(selector);
    const text = normalizeText(node?.textContent);

    if (text) {
      return text;
    }
  }

  return '';
}

function isCompletionState(container) {
  if (!container) {
    return false;
  }

  const successSelectors = [
    '[class*="success"]',
    '[class*="congrat"]',
    '[class*="confirm"]',
    '.am-notification',
    '[aria-live]',
  ];

  for (const selector of successSelectors) {
    const nodes = container.querySelectorAll(selector);

    for (const node of nodes) {
      if (containsBookingSuccessText(node.textContent)) {
        return true;
      }
    }
  }

  return containsBookingSuccessText(container.textContent);
}

function getSubmitButtonFromTarget(target, container) {
  if (!target || !container) {
    return null;
  }

  const button = target.closest('button, [role="button"]');

  if (!button || !container.contains(button)) {
    return null;
  }

  return getSubmitButton(container) === button ? button : null;
}

function shouldDelayNavigation(event, cta) {
  if (!cta || cta.tagName !== 'A') {
    return false;
  }

  if (cta.target && cta.target !== '_self') {
    return false;
  }

  if (event.defaultPrevented || event.button !== 0) {
    return false;
  }

  return !(event.metaKey || event.ctrlKey || event.shiftKey || event.altKey);
}

function navigateToCta(cta) {
  const href = cta?.getAttribute('href');

  if (href) {
    window.location.assign(href);
  }
}

function getSubmitButton(container) {
  if (!container) {
    return null;
  }

  const buttons = container.querySelectorAll('button, [role="button"]');

  for (const button of buttons) {
    const text = normalizeText(button.textContent).toLowerCase();

    if (
      text.includes('confirm') ||
      text.includes('book') ||
      text.includes('reserve') ||
      text.includes('zak') ||
      text.includes('rezerv') ||
      text.includes('potvrd')
    ) {
      return button;
    }
  }

  return null;
}

function observeAmeliaWidget() {
  const hasSent = createTrackedEventGuard();
  let lastStep = '';
  let hasSubmitted = false;

  function bindSubmitTracking(container) {
    if (container.dataset.bookingSubmitTrackingAttached === 'true') {
      return;
    }

    container.dataset.bookingSubmitTrackingAttached = 'true';
    container.addEventListener('click', (event) => {
      const submitButton = getSubmitButtonFromTarget(event.target, container);

      if (!submitButton) {
        return;
      }

      hasSubmitted = true;
      emitTrackingEvent('booking_submit_click', {
        booking_provider: 'amelia',
        booking_step: getActiveAmeliaStep(container) || 'unknown',
        booking_label: normalizeText(submitButton.textContent),
      });
    });
  }

  function evaluateState(container) {
    if (!container) {
      return;
    }

    if (!hasSent('widget_view')) {
      emitTrackingEvent('booking_widget_view', {
        booking_provider: 'amelia',
      });
    }

    const step = getActiveAmeliaStep(container);

    if (step && step !== lastStep) {
      lastStep = step;
      emitTrackingEvent('booking_step_view', {
        booking_provider: 'amelia',
        booking_step: step,
      });
    }

    bindSubmitTracking(container);

    if (hasSubmitted && isCompletionState(container) && !hasSent('booking_complete')) {
      emitTrackingEvent('booking_completed', {
        booking_provider: 'amelia',
        booking_step: lastStep || 'completed',
      });
    }
  }

  function attachObserver(container) {
    if (!container || container.dataset.bookingTrackingAttached === 'true') {
      return;
    }

    container.dataset.bookingTrackingAttached = 'true';
    evaluateState(container);

    const observer = new MutationObserver(() => {
      evaluateState(container);
    });

    observer.observe(container, {
      childList: true,
      subtree: true,
      attributes: true,
      characterData: true,
    });
  }

  const container = getAmeliaContainer();
  if (container) {
    attachObserver(container);
  }

  const rootObserver = new MutationObserver(() => {
    const nextContainer = getAmeliaContainer();
    if (nextContainer) {
      attachObserver(nextContainer);
    }
  });

  rootObserver.observe(document.body, {
    childList: true,
    subtree: true,
  });
}

function initBookingCtaTracking() {
  document.addEventListener('click', (event) => {
    const cta = getClosestBookingCta(event.target);

    if (!cta) {
      return;
    }

    const payload = {
      booking_source: cta.dataset.bookingSource || 'unknown',
      booking_destination: cta.getAttribute('href') || '',
      booking_label: normalizeText(cta.textContent),
    };

    if (!shouldDelayNavigation(event, cta)) {
      emitTrackingEvent('booking_cta_click', payload);
      return;
    }

    event.preventDefault();

    let hasNavigated = false;
    const navigate = () => {
      if (hasNavigated) {
        return;
      }

      hasNavigated = true;
      navigateToCta(cta);
    };

    emitTrackingEvent('booking_cta_click', payload, {
      eventCallback: navigate,
      eventTimeout: 1200,
    });

    window.setTimeout(navigate, 300);
  });
}

export function initBookingTracking() {
  if (window.__frizerBookingTrackingInitialized) {
    return;
  }

  window.__frizerBookingTrackingInitialized = true;

  initBookingCtaTracking();
  observeAmeliaWidget();
}
