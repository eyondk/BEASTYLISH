$(document).ready(function () {
    const statusMap = {
        "Pending": 1,
        "On Ship": 2,
        "On Delivery": 3,
        "Completed": 4,
        "Cancelled": 5
    };
    $('select[name="order_status"]').on('change', function () {
        var $selectElement = $(this);
        var orderId = $selectElement.data('order-id');
        var newStatusString = $selectElement.val();
        var newStatus = statusMap[newStatusString];
        var paymentMethod = $selectElement.data('payment-method');
        var paymentStatus = $selectElement.data('payment-status');

        // Ensure paymentMethod and paymentStatus are strings
        paymentMethod = paymentMethod ? paymentMethod.toUpperCase() : '';
        paymentStatus = paymentStatus ? paymentStatus.toUpperCase() : '';

        // Define disallowed methods in uppercase
        var disallowedMethods = ["GCASH", "PAYPAL", "CREDIT CARD"];

        // Check if the payment status is "UNPAID" and the payment method is disallowed
        if (paymentStatus === "UNPAID" && disallowedMethods.includes(paymentMethod)) {
            alert('You cannot change the order status if the payment status is "Unpaid" and the payment method is "Gcash", "Paypal", or any credit card.');
            $selectElement.val('Pending'); // Revert to original status
            return;
        }

        
        
        $selectElement.data('original-status', newStatus);

       
        $.ajax({
            type: 'POST',
            url: 'OrderPending/index',
            data: {
                order_id: orderId,
                order_status: newStatus
            },
            success: function (response) {
                console.log(response);
                location.reload(); 
            },
            error: function () {
                alert('Failed to update order status.');
            }
        });
    });


});
