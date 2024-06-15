$(document).ready(function() {
    $('#checkoutbtn').click(function() {
        var subtotal = parseFloat($('#subtotal').text().replace(/[^0-9.-]+/g, ""));
        var total = parseFloat($('#total').text().replace(/[^0-9.-]+/g, ""));
        var paymentMethod = $('input[name="select"]:checked').val();
        var customerId = 2; // Ensure this value is being set correctly or dynamically retrieved

        console.log("Subtotal:", subtotal);
        console.log("Total:", total);
        console.log("Payment Method:", paymentMethod);
        console.log("Customer ID:", customerId);

        if (!subtotal || isNaN(subtotal) || !total || isNaN(total) || !paymentMethod || !customerId) {
            alert('Please complete all fields before submitting.');
            return;
        }

        var data = {
            order_subtotal: subtotal,
            order_total: total,
            payment_method: paymentMethod,
            cus_id: customerId, // Ensure this value is being set
            deliverm_id: 1,      // Example delivery method ID, consider replacing with actual dynamic value
            pstat_id: 1,         // Example payment status ID, consider replacing with actual dynamic value
            cart_items: collectCartItems()
        };

        console.log("Sending data:", data);

        $.ajax({
            url: 'Checkout/confirmOrder', // Ensure this is the correct relative path to your server endpoint
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(response) {
                console.log(response);
                if (response.data) {
                    window.open(response.data, '_blank');
                } else {
                    alert('Checkout URL not available.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                alert('An error occurred while processing your request. Please try again.');
            }
        });
    });
});

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
