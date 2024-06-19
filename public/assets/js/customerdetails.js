$(document).ready(function() {
    var customerData = JSON.parse(localStorage.getItem('customerData'));
    var cusId = localStorage.getItem('cusId');

    if (customerData && cusId) {
        // Use the stored data to populate the page
        console.log('Customer Data:', customerData);

        // For example, you could populate HTML elements with this data
        // $('#customerName').text(customerData.customer.cus_fname + ' ' + customerData.customer.cus_lname);
        // $('#customerAddress').text(customerData.customer.customer_address);
        // ... and so on
    } else {
        // If no data in local storage, fetch from server (fallback)
        fetchCustomerDetailsFromServer(cusId);
    }

    function fetchCustomerDetailsFromServer(cusId) {
        $.ajax({
            url: 'CustomerDetails/index',
            type: 'POST',
            data: { cus_id: cusId },
            success: function(response) {
                console.log('Fetched Data:', response);
                // Populate the page with fetched data
                // $('#customerName').text(response.customer.cus_fname + ' ' + response.customer.cus_lname);
                // $('#customerAddress').text(response.customer.customer_address);
                // ... and so on
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error:', textStatus, errorThrown);
                alert('Error loading customer details.');
            }
        });
    }

   $('.cus-dlt-btn').click(function() {
    var customerId = $(this).data('customer-id');

    if (confirm('Are you sure you want to delete this customer? This action cannot be undone.')) {
        $.ajax({
            url: 'CustomerDetails/deleteCustomer',
            method: 'POST',
            data: { customer_id: customerId },
            success: function(response) {
                try {
                    var data = JSON.parse(response);
                    alert(data.message);
                    if (data.status === 'success') {
                        window.location.href = 'AdminCustomer';
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    alert('An unexpected error occurred: ' + response); // Show the raw response for debugging
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                alert('Failed to communicate with the server.');
            }
        });
    }
});

    

});
