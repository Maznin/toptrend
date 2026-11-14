/**
 * Sends Google Analytics events for the clicks that matter to the salon:
 * - booking_click: links to the booking page (/zakazivanje/)
 * - phone_click:   tel: links
 * - map_click:     links to Google Maps
 * - social_click:  Instagram / Facebook links
 *
 * Each event carries link_location (where on the page the link is, e.g. "hero",
 * "pricing", "mobile_bar"). It uses the GA tag that Site Kit already loads; nothing
 * new is loaded and no extra cookies are set. If the tag hasn't loaded yet, the event
 * waits in dataLayer and is sent once it does.
 */

// Nearest matching container wins, so more specific areas come first.
const LOCATIONS = [
  ['.booking-bar', 'mobile_bar'],
  ['.booking-preselected', 'change_service'],
  ['.header__top', 'header_top'],
  ['.main-nav', 'menu'],
  ['.header', 'header'],
  ['.slideout', 'sidebar'],
  ['.hero', 'hero'],
  ['.pricing-table', 'pricing'],
  ['.related-page-link', 'page_buttons'],
  ['.working-hours', 'working_hours'],
  ['.about', 'about'],
  ['.contact', 'contact'],
  ['.footer', 'footer'],
];

function linkLocation(link) {
  for (const [selector, name] of LOCATIONS) {
    if (link.closest(selector)) {
      return name;
    }
  }
  return 'content';
}

function sendEvent(name, params) {
  if (typeof window.gtag === 'function') {
    window.gtag('event', name, params);
    return;
  }
  // gtag.js reads "arguments" objects from dataLayer, not plain arrays.
  window.dataLayer = window.dataLayer || [];
  (function () {
    window.dataLayer.push(arguments);
  })('event', name, params);
}

function classify(link) {
  const href = link.getAttribute('href') || '';

  if (href.startsWith('tel:')) {
    return ['phone_click', { phone_number: href.slice(4) }];
  }

  let url;
  try {
    url = new URL(href, window.location.href);
  } catch {
    return null;
  }

  if (url.host === window.location.host && /^\/zakazivanje\/?$/.test(url.pathname)) {
    const params = {};
    const service = url.searchParams.get('usluga');
    if (service) {
      params.service_id = service;
    }
    return ['booking_click', params];
  }

  const host = url.hostname.replace(/^www\./, '');
  if (
    /^maps\.google\./.test(host) ||
    host === 'maps.app.goo.gl' ||
    (host === 'goo.gl' && url.pathname.startsWith('/maps')) ||
    (/^google\./.test(host) && url.pathname.startsWith('/maps'))
  ) {
    return ['map_click', {}];
  }

  if (/(^|\.)instagram\.com$/.test(host) || /(^|\.)facebook\.com$/.test(host)) {
    return ['social_click', { network: host.includes('instagram') ? 'instagram' : 'facebook' }];
  }

  return null;
}

export function initClickTracking() {
  document.addEventListener(
    'click',
    (event) => {
      const link = event.target.closest && event.target.closest('a[href]');
      if (!link) {
        return;
      }
      const result = classify(link);
      if (!result) {
        return;
      }
      const [name, params] = result;
      sendEvent(name, {
        ...params,
        link_location: linkLocation(link),
        link_text: (link.textContent || '').trim().slice(0, 100),
      });
    },
    { capture: true }
  );
}
