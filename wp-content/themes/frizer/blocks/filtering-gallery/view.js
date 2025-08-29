// Configure your options
// Default options
const options = {
    layout: 'sameWidth',
    gutterPixels: 5,
    callbacks: {
    onFilteringEnd: function() {
        let filter = filterizr.options.filter;

        // Remove active class from all filter buttons
        document.querySelectorAll('.filter-button').forEach(button => {
            button.classList.remove('active');
        });

        // Add active class to the clicked filter button
        if (filter) {
            const activeButton = document.querySelector(`.filter-button[data-filter="${filter}"]`);
            if (activeButton) {
                activeButton.classList.add('active');
            }
        }

    }
  }
} 

// Adjust the CSS selector to match the container where
// you set up your image gallery
const filterizr = new Filterizr('.filter-container', options);


