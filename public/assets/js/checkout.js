$(document).ready(function() {
    $('#checkoutbtn').click(function() {
        var subtotal = parseFloat($('#subtotal').text().replace(/[^0-9.-]+/g, ""));
        var total = parseFloat($('#total').text().replace(/[^0-9.-]+/g, ""));
        var paymentMethod = $('input[name="select"]:checked').val();
        var customerId = 2; // Ensure this value is being set correctly

        console.log("Subtotal:", subtotal);
        console.log("Total:", total);
        console.log("Payment Method:", paymentMethod);
        console.log("Customer ID:", customerId);

        if (!subtotal || !total || !paymentMethod || !customerId) {
            alert('Please complete all fields before submitting.');
            return;
        }

        var data = {
            order_subtotal: subtotal,
            order_total: total,
            payment_method: paymentMethod,
            cus_id: customerId, // Ensure this value is being set
            deliverm_id: 1,
            pstat_id: 1,
            cart_items: collectCartItems()
        };

        console.log("Sending data:", data);

        $.ajax({
            url: 'Checkout/confirmOrder',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(response) {
                console.log(response);
                if (response.success) {
                    alert('Order processed successfully!');
                    // Redirect or update the UI as needed
                } else {
                    alert('Error processing order: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                alert('AJAX error: ' + error);
            }
        });
    });
});

function collectCartItems() {
    var items = [];
    $('.cart-item').each(function() {
        var item = {
            prod_id: $(this).data('product-id'),
            qty: parseInt($(this).find('.quantity').text()),
            cart_id: $(this).data('cart-id') // Ensure cart_id is collected
        };
        items.push(item);
    });
    return items;
}
