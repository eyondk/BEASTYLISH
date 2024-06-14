// $(document).ready(function() {
//     $('.view-details').click(function(e) {
//         e.preventDefault();
//         var cusId = $(this).data('cus-id'); // Assuming you have data-cus-id attribute on your element

//         $.ajax({
//             url: 'CustomerDetails/index',
//             type: 'POST',
//             data: { cus_id: cusId },
//             success: function(response) {
                
//             console.log(response);
                
//             },
//             error: function(jqXHR, textStatus, errorThrown) {
//                 console.error('Error:', textStatus, errorThrown);
//                 alert('Error loading customer details.');
//             }
//         });
//     });
// });
