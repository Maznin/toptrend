export function initSlideout() {
  
    const slideout = document.querySelector('.slideout');
    const closeBtn = document.querySelector('.slideout__header__close');
    const sidebarToggle = document.querySelector('.header__bottom__sidebar-toggle');

    // Create backdrop
    let backdrop = document.createElement('div');
    backdrop.className = 'slideout-backdrop';
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