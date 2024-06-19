$(document).ready(function() {
    const ROOT_URL = "http://localhost/BEASTYLISH/public";
    const statusMap = {
        "PENDING": 1,
        "ON SHIPPED": 2,
        "ON DELIVERY": 3,
        "COMPLETED": 4,
        "CANCELLED": 5
    };

    $('.orderstatus input').click(function() {
        const status = $(this).val();
        const statusCode = statusMap[status];
        
        fetchOrders(statusCode);
    });

    function fetchOrders(status) {
        $.ajax({
            url: ROOT_URL + '/Account/fetchOrders',
            type: 'POST',
            data: { status: status },
            success: function(response) {
                console.log('Response:', response); // Log the response to debug
                try {
                    if (typeof response !== 'object') {
                        response = JSON.parse(response);
                    }
                    if (response.success) {
                        updateOrderTable(response.orders);
                    } else {
                        console.error('Error:', response.message);
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    console.error('Response:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error('Failed to fetch orders');
                console.error('Status:', status);
                console.error('Error:', error);
                console.error('Response:', xhr.responseText);
            }
        });
    }

    function cancelOrder(orderId) {
        $.ajax({
            url: ROOT_URL + '/Account/fetchOrders',
            type: 'POST',
            data: { status: 'cancel', order_id: orderId },
            success: function(response) {
                console.log('Cancel Response:', response);
                try {
                    if (typeof response !== 'object') {
                        response = JSON.parse(response);
                    }
                    if (response.success) {
                        alert('Order cancelled successfully');
                        fetchOrders(1); // Refresh the pending orders
                    } else {
                        console.error('Error:', response.message);
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    console.error('Response:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error('Failed to cancel order');
                console.error('Status:', status);
                console.error('Error:', error);
                console.error('Response:', xhr.responseText);
            }
        });
    }
    // Use event delegation for dynamically added elements
    $('body').on('click', '.cancel-order', function() {
        var orderId = $(this).data('order-id');
        cancelOrder(orderId);
    });

    function updateOrderTable(orders) {
        const tbody = $('.order-table tbody');
        tbody.empty();
        if (orders.length === 0) {
            tbody.append('<tr><td colspan="6">No orders found</td></tr>');
        } else {
            orders.forEach(order => {
                let buttonText = 'ON GOING';
                let cancelButtonDisabled = 'disabled';
    
                if (order.order_status === "PENDING" && order.payment_status !== "PAID") {
                    buttonText = 'Cancel';
                    cancelButtonDisabled = '';
                } else if (order.order_status === "COMPLETED" || order.order_status === "CANCELLED") {
                    buttonText = 'DONE';
                }
    
                const tr = `
                    <tr>
                        <td>${order.order_id}</td>
                        <td>&#8369; ${order.order_total}</td>
                        <td>${order.order_date}</td>
                        <td>${order.payment_status}</td>
                        <td>${order.order_status}</td>
                        <td>
                            <button class="cancel-order" data-order-id="${order.order_id}" ${cancelButtonDisabled}>${buttonText}</button>
                        </td>
                    </tr>
                `;
                tbody.append(tr);
            });
        }
    }
    
    
});
