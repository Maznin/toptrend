let elem = document.querySelector('.tab-gallery');
let msnry = new Masonry( elem, {
  // options
  columnWidth: '.grid-sizer',
  itemSelector: '.grid-item',
  percentPosition: true,
  gutter: 10
});

// msnry.on( 'layoutComplete', onLayout );

// function onLayout(event, items) {
//     console.log(event);
    
// }