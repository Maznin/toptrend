/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/modules/navigation.js":
/*!**************************************!*\
  !*** ./src/js/modules/navigation.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   initNavigation: () => (/* binding */ initNavigation)
/* harmony export */ });
function initNavigation() {
  const navToggle = document.querySelector('#mobileMenuToggle');
  const navMenu = document.querySelector('.main-nav');
  if (navToggle && navMenu) {
    navToggle.addEventListener('click', () => {
      navMenu.classList.toggle('is-open');
      navToggle.classList.toggle('is-active');
      navToggle.setAttribute('aria-expanded', navMenu.classList.contains('is-open').toString());
    });
  }

  // Sub-menu logic
  const subMenuToggles = document.querySelectorAll('.menu-item-has-children');
  subMenuToggles.forEach(toggle => {
    const subMenu = toggle.querySelector('.sub-menu');
    console.log(toggle);
    if (subMenu && subMenu.classList.contains('sub-menu')) {
      toggle.addEventListener('click', e => {
        e.preventDefault();
        subMenu.classList.toggle('is-open');
        toggle.classList.toggle('is-active');
        toggle.setAttribute('aria-expanded', subMenu.classList.contains('is-open').toString());
      });
    }
  });
}

/***/ }),

/***/ "./src/js/modules/slideout-modal.js":
/*!******************************************!*\
  !*** ./src/js/modules/slideout-modal.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   initSlideout: () => (/* binding */ initSlideout)
/* harmony export */ });
function initSlideout() {
  const slideout = document.querySelector('.slideout');
  const closeBtn = document.querySelector('.slideout__close');
  const sidebarToggle = document.querySelector('.header__bottom__sidebar-toggle');

  // Create backdrop
  let backdrop = document.createElement('div');
  backdrop.className = 'slideout-backdrop';
  backdrop.style.cssText = `
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 999;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s;
  `;
  document.body.appendChild(backdrop);
  function openSlideout() {
    slideout.style.transform = 'translateX(0)';
    backdrop.style.opacity = '1';
    backdrop.style.pointerEvents = 'auto';
    document.body.style.overflow = 'hidden';
  }
  function closeSlideout() {
    slideout.style.transform = 'translateX(100%)';
    backdrop.style.opacity = '0';
    backdrop.style.pointerEvents = 'none';
    document.body.style.overflow = '';
  }
  sidebarToggle?.addEventListener('click', openSlideout);
  closeBtn?.addEventListener('click', closeSlideout);
  backdrop.addEventListener('click', closeSlideout);
}

/***/ }),

/***/ "./src/js/modules/utils.js":
/*!*********************************!*\
  !*** ./src/js/modules/utils.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   onScreenMax: () => (/* binding */ onScreenMax),
/* harmony export */   onScreenMin: () => (/* binding */ onScreenMin)
/* harmony export */ });
/**
 * Runs a callback when the screen width is at most maxWidth.
 * @param {number} maxWidth - The maximum width in pixels.
 * @param {Function} callback - The function to run when the condition is met.
 */
function onScreenMax(maxWidth, callback) {
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
function onScreenMin(minWidth, callback) {
  const mq = window.matchMedia(`(min-width: ${minWidth}px)`);
  function check(e) {
    if (e.matches) callback();
  }
  mq.addEventListener('change', check);
  // Initial check
  if (mq.matches) callback();
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!************************!*\
  !*** ./src/js/main.js ***!
  \************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modules_navigation_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules/navigation.js */ "./src/js/modules/navigation.js");
/* harmony import */ var _modules_slideout_modal_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/slideout-modal.js */ "./src/js/modules/slideout-modal.js");
/* harmony import */ var _modules_utils_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modules/utils.js */ "./src/js/modules/utils.js");



document.addEventListener('DOMContentLoaded', () => {
  (0,_modules_utils_js__WEBPACK_IMPORTED_MODULE_2__.onScreenMin)(769, () => {
    (0,_modules_slideout_modal_js__WEBPACK_IMPORTED_MODULE_1__.initSlideout)();
  });
  (0,_modules_utils_js__WEBPACK_IMPORTED_MODULE_2__.onScreenMax)(768, () => {
    (0,_modules_navigation_js__WEBPACK_IMPORTED_MODULE_0__.initNavigation)();
  });
});
})();

/******/ })()
;
//# sourceMappingURL=theme.js.map