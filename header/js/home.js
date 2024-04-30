// Get all carousel items
var carouselItems = document.querySelectorAll('.carousel-item');

// Initialize index variable
var currentIndex = 0;

// Function to toggle active class among carousel items
function toggleCarouselItems() {
    // Remove active class from current item
    carouselItems[currentIndex].classList.remove('active');

    // Increment index or reset to 0 if reached the end
    currentIndex = (currentIndex + 1) % carouselItems.length;

    // Add active class to the new current item
    carouselItems[currentIndex].classList.add('active');
}

// Set interval to toggle carousel items every 3 seconds (adjust as needed)
setInterval(toggleCarouselItems, 3000);
