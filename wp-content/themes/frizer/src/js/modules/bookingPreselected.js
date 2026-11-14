/**
 * /zakazivanje/?usluga=<id>: on Amelia's confirmation step, "Završi" restarts the same
 * form with the service still preselected. Send the visitor to the regular booking page
 * instead (the "Promeni uslugu" link's URL, without ?usluga).
 */
export function initBookingPreselected() {
  document.addEventListener(
    'click',
    (event) => {
      const wrapper = event.target.closest && event.target.closest('.booking-preselected');
      if (!wrapper || !wrapper.querySelector('.am-fs__congrats')) {
        return;
      }
      if (!event.target.closest('.am-fs__main-footer button')) {
        return;
      }
      const link = wrapper.querySelector('.booking-preselected__change');
      if (!link) {
        return;
      }
      event.preventDefault();
      event.stopPropagation();
      window.location.href = link.href;
    },
    { capture: true }
  );
}
