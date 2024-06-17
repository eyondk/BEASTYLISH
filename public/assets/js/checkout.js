$(document).ready(function() {
    
    // Store the original delivery fee as a variable
    var originalDeliveryFee = parseFloat($('#delivery_fee').text().replace(/[^0-9.-]+/g, ""));
    $('#delivery_fee').data('original-fee', originalDeliveryFee);

    $('#checkoutbtn').on('click', function() {
        var subtotal = parseFloat($('#subtotal').text().replace(/[^0-9.-]+/g, ""));
        var total = parseFloat($('#total').text().replace(/[^0-9.-]+/g, ""));
        var paymentMethod = $('input[name="select"]:checked').val();
        var customerId = $('#customerId').val();

        console.log("Subtotal:", subtotal);
        console.log("Total:", total);
        console.log("Payment Method:", paymentMethod);
        console.log("Customer ID:", customerId);

        if (!subtotal || isNaN(subtotal) || !total || isNaN(total) || !paymentMethod || !customerId) {
            alert('Please complete all fields before submitting.');
            return;
        }

        var discount = parseFloat($('#discount').text().replace(/[^0-9.-]+/g, ""));
        if (isNaN(discount)) {
            discount = 0;
        }

        // Adjust the total if MEET UP is selected
        var deliveryFee;
        if (paymentMethod === 'MEET UP') {
            deliveryFee = 0;
        } else {
            deliveryFee = $('#delivery_fee').data('original-fee');
        }
        
        // Calculate the total
        total = subtotal + deliveryFee - discount;

        console.log("Delivery Fee:", deliveryFee);
        console.log("Total after adjustment:", total);

        $('#delivery_fee').text(deliveryFee.toFixed(2));
        $('#total').text(total.toFixed(2));

        var data = {
            order_subtotal: subtotal,
            order_total: total,
            payment_method: paymentMethod,
            cus_id: customerId,
            deliverm_id: 1,  // Example delivery method ID, consider replacing with actual dynamic value
            pstat_id: 1,     // Example payment status ID, will be updated after PayPal approval
            cart_items: collectCartItems()
        };

        console.log("Sending data:", data);

        if (paymentMethod === 'PAYPAL') {
            $('#paypalModal').show();

            // Hardcoded exchange rate PHP to USD
            var exchangeRate = 55; // Update this rate periodically

            var totalInUSD = convertPHPtoUSD(total, exchangeRate);
            console.log("Total in USD:", totalInUSD.toFixed(2));
            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: totalInUSD.toFixed(2),
                                currency_code: 'USD'
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        $('#paypalModal').hide();

                        var dataToSend = {
                            order_subtotal: subtotal,
                            order_total: total,
                            payment_method: 'PAYPAL',
                            cus_id: customerId,
                            deliverm_id: 1,
                            pstat_id: 2, // Set to 2 for PayPal
                            cart_items: collectCartItems()
                        };

                        $.ajax({
                            url: 'Checkout/confirmOrder', // Ensure this is the correct relative path to your server endpoint
                            type: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify(dataToSend),
                            success: function(response) {
                                console.log(response);
                              
                                $('#checkedModal').show();
                                // window.location.href = 'home'; // Redirect to home page
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX error:', error);
                                alert('An error occurred while processing your request. Please try again.');
                            }
                        });
                    });
                }
            }).render('#paypal-button-container');
        } else {
            // Handle other payment methods
            $.ajax({
                url: 'Checkout/confirmOrder', // Ensure this is the correct relative path to your server endpoint
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    console.log(response);
                    
                    $('#checkedModal').show();
                    // window.location.href = 'home'; // Redirect to home page
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                    alert('An error occurred while processing your request. Please try again.');
                }
            });
        }
    });

    $('#closePaypalModal').on('click', function() {
        $('#paypalModal').hide();
    });

    $('input[name="select"]').on('change', function() {
        // Get the subtotal and discount
        var subtotal = parseFloat($('#subtotal').text().replace(/[^0-9.-]+/g, ""));
        var discount = parseFloat($('#discount').text().replace(/[^0-9.-]+/g, ""));
        var deliveryFee = parseFloat($('#delivery_fee').data('original-fee'));

        // Ensure subtotal, discount, and deliveryFee are valid numbers
        if (isNaN(subtotal)) {
            console.error('Invalid subtotal:', subtotal);
            return;
        }
        if (isNaN(discount)) {
            discount = 0; // Default discount if invalid
        }
        if (isNaN(deliveryFee)) {
            console.error('Invalid delivery fee:', deliveryFee);
            deliveryFee = 0; // Default delivery fee if invalid
        }

        // Get the selected payment method
        var paymentMethod = $('input[name="select"]:checked').val();

        // Set delivery fee based on payment method
        if (paymentMethod === 'MEET UP') {
            deliveryFee = 0;
        }

        // Calculate the total
        var total = subtotal + deliveryFee - discount;

        // Update the delivery fee and total in the UI
        $('#delivery_fee').text(deliveryFee.toFixed(2));
        $('#total').text(total.toFixed(2));

        console.log('Payment method:', paymentMethod);
        console.log('Subtotal:', subtotal);
        console.log('Discount:', discount);
        console.log('Delivery fee:', deliveryFee);
        console.log('Total:', total);
    });

    // Function to collect cart items
    function collectCartItems() {
        var items = [];
        $('.cart-item').each(function() {
            var item = {
                prod_id: $(this).data('product-id'),
                qty: parseInt($(this).find('.quantity').text(), 10), // Ensure text is an integer
                cart_id: $(this).data('cart-id') // Ensure cart_id is collected
            };
            items.push(item);
        });
        return items;
    }

    // Function to convert PHP to USD
    function convertPHPtoUSD(amountInPHP, exchangeRate) {
        return amountInPHP / exchangeRate;
    }


    function showModal(modalId) {
        $(modalId).fadeIn();
    }


    function hideModal(modalId) {
        $(modalId).fadeOut();
    }


    


    $('#closeCheckedModal').on('click', function() {
        hideModal('#checkedModal');
    });


    $('#goHome').on('click', function() {
        window.location.href = 'home'; 
    });

    $('#cancel').on('click', function() {
        window.location.href = 'cart'; 
    });


    
    $('#closePaypalModal').on('click', function() {
        hideModal('#paypalModal');
    });
});
