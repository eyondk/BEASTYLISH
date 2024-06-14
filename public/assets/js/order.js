$(document).ready(function () {
    var $viewmodal = $("#viewProdModal");
    var $viewbtns = $(".view");
    var $span = $(".closemodal");
    var $cancel = $(".opt-btn");

    // Attach event listeners to each view button
    $(".view").on("click", function() {
       

        var orderId = $(this).data('order-id');
        var customerName = $(this).data('customer-name');
        var phone = $(this).data('phone');
        var email = $(this).data('email');
        var address = $(this).data('address');
        var stat = $(this).data('stat');

           
      
        $('#orderID').text(orderId);
        $('#customerName').text(customerName);
        $('#phoneNumber').text(phone);
        $('#email').text(email);
        $('#address').text(address);
        $('#orderStatus').text(stat);

      
        $.ajax({
            url: 'Orders/index', 
            method: 'POST',
            data: { orderId: orderId },
            dataType: 'json',  
            success: function(response) {
                console.log('Response from server:', response);
                try {
                    if (Array.isArray(response)) {
                        var html = '';
                        var totalItems = 0;
                        response.forEach(function(product) {
                            html += '<p><strong>Product Name:</strong> ' + product.prod_name + 
                                    '</br><strong>Quantity:</strong> ' + product.orderi_qty + '</p>';
                            totalItems += parseInt(product.orderi_qty);
                        });
                        $('#productsContainer').html(html);
                        $('#totalItems').text(totalItems);
                    } else {
                        console.error('Response is not an array:', response);
                        alert('Unexpected response format.');
                    }
                } catch (e) {
                    console.error('Error processing response:', e);
                    alert('Error processing data.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr.responseText);
                alert('Error fetching order details. Please try again later.');
            }
        });
        // Show the modal
        $("#viewProdModal").show();
    });

    // Close modal
    $span.on("click", function () {
        $viewmodal.hide();
    });

    $cancel.on("click", function () {
        $viewmodal.hide();
    });

    // Close modal on window click
    $(window).on("click", function (event) {
        if ($(event.target).is($viewmodal)) {
            $viewmodal.hide();
        }
    });

    $('#search-btn').click(function() {
        var searchTerm = $('#searchInput').val().toLowerCase();
    
        $('#orderTable tbody tr').each(function() {
            var row = $(this);
            var allText = row.text().toLowerCase();
    
            if (allText.indexOf(searchTerm) !== -1) {
                row.show();
            } else {
                row.hide();
            }
        });
    });

});
