document.addEventListener('DOMContentLoaded', function () {
    
    var checkoutBtn = document.getElementById('proceedtocheckout');
    const minusButton = document.querySelector('.minus');
    const plusButton = document.querySelector('.plus');
    const quantityInput = document.getElementById('quantity');

    checkoutBtn.onclick = function () {
        window.location.href = "checkout.php";
    }


    plusButton.addEventListener('click', function () {
        let currentValue = parseInt(quantityInput.value, 10);
        quantityInput.value = currentValue + 1;
        minusButton.disabled = false; // Enable the minus button if it was disabled
    });

    minusButton.addEventListener('click', function () {
        let currentValue = parseInt(quantityInput.value, 10);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
        if (quantityInput.value == 1) {
            minusButton.disabled = true; // Disable the minus button if the value is 1
        }
    });

    // Disable the minus button initially if the value is 1
    if (quantityInput.value == 1) {
        minusButton.disabled = true;
    }

    // Prevent input value from being less than 1
    quantityInput.addEventListener('input', function () {
        if (quantityInput.value < 1) {
            quantityInput.value = 1;
        }
    });







});

