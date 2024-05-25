document.addEventListener("DOMContentLoaded", function() {
    const accBtn = document.getElementById("acc-btn");
    const brandnewBtn = document.getElementById("brandnew-btn");
    const prelovedBtn = document.getElementById("preloved-btn");
    const accShow = document.getElementById("acc-show");
    const brandnewShow = document.getElementById("brandnew-show");
    const prelovedShow = document.getElementById("preloved-show");

   

    // Select all size options
    var sizeOptions = document.querySelectorAll(".size-value span");


    accBtn.addEventListener("click", function(event) {
        event.preventDefault();
        accShow.classList.toggle("show");
        accBtn.querySelector(".fa-chevron-down").classList.toggle("flip");
    });

    brandnewBtn.addEventListener("click", function(event) {
        event.preventDefault();
        brandnewShow.classList.toggle("show");
        brandnewBtn.querySelector(".fa-chevron-down").classList.toggle("flip");
    });

    prelovedBtn.addEventListener("click", function(event) {
        event.preventDefault();
        prelovedShow.classList.toggle("show");
        prelovedBtn.querySelector(".fa-chevron-down").classList.toggle("flip");
    });


    // Add click event listener to each size option
    sizeOptions.forEach(function(option) {
        option.addEventListener("click", function() {
            // Remove the active class from all size options
            sizeOptions.forEach(function(opt) {
                opt.classList.remove("active");
            });

            // Add the active class to the clicked size option
            this.classList.add("active");
        });
    });
    
});
