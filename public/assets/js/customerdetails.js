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
});
