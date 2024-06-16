$(document).ready(function () {
  $("#checkoutbtn").click(function () {
    // Collect order summary data
    var subtotal = parseFloat(
      $("#subtotal")
        .text()
        .replace(/[^0-9.-]+/g, "")
    );
    var total = parseFloat(
      $("#total")
        .text()
        .replace(/[^0-9.-]+/g, "")
    );
    var paymentMethod = $('input[name="select"]:checked').val();
    var customerId = 2; // Ensure this value is being set correctly or dynamically retrieved

    // Check if all necessary fields are filled
    if (
      !subtotal ||
      isNaN(subtotal) ||
      !total ||
      isNaN(total) ||
      !paymentMethod ||
      !customerId
    ) {
      alert("Please complete all fields before submitting.");
      return;
    }

    // Collect address data
    var address = {
      street: $("#street").val(),
      brgy: $("#brgy").val(),
      city: $("#city").val(),
      province: $("#province").val(),
      zipcode: $("#zipcode").val(),
      default: $("#address_type").is(":checked"),
    };

    // Collect cart items
    var cartItems = collectCartItems();

    var data = {
      attributes: {
        amount: Math.round(total * 100), // Amount in cents
        redirect: {
          success: "http://localhost/BEASTYLISH/public/CheckoutSuccess",
          failed: "http://localhost/BEASTYLISH/public/CheckoutFailed",
        },
        description: "Order payment",
        metadata: {
          order_id: customerId,
          payment_method: paymentMethod,
          address: address,
          cart_items: cartItems,
        },
      },
    };

    // Make AJAX request to the proxy server
    $.ajax({
      url: "http://localhost:3000/api/proxy",
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify(data),
      success: function (response) {
        if (
          response.data &&
          response.data.attributes &&
          response.data.attributes.checkout_url
        ) {
          window.open(response.data.attributes.checkout_url, "_blank");
        } else {
          alert("Checkout URL not available.");
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", xhr.responseText);
        alert(
          "An error occurred while processing your request. Please try again."
        );
      },
    });
  });
});

// Function to collect cart items
function collectCartItems() {
  var items = [];
  $(".cart-item").each(function () {
    var item = {
      prod_id: $(this).data("product-id"),
      qty: parseInt($(this).find(".quantity").text(), 10),
      cart_id: $(this).data("cart-id"),
    };
    items.push(item);
  });
  return items;
}

// $(document).ready(function () {
//   $("#checkoutbtn").click(function () {
//     // Collect order summary data
//     var subtotal = parseFloat(
//       $("#subtotal")
//         .text()
//         .replace(/[^0-9.-]+/g, "")
//     );
//     var total = parseFloat(
//       $("#total")
//         .text()
//         .replace(/[^0-9.-]+/g, "")
//     );
//     var paymentMethod = $('input[name="select"]:checked').val();
//     var customerId = 2; // Ensure this value is being set correctly or dynamically retrieved

//     // Check if all necessary fields are filled
//     if (
//       !subtotal ||
//       isNaN(subtotal) ||
//       !total ||
//       isNaN(total) ||
//       !paymentMethod ||
//       !customerId
//     ) {
//       alert("Please complete all fields before submitting.");
//       return;
//     }

//     // Collect address data
//     var address = {
//       street: $("#street").val(),
//       brgy: $("#brgy").val(),
//       city: $("#city").val(),
//       province: $("#province").val(),
//       zipcode: $("#zipcode").val(),
//       default: $("#address_type").is(":checked"),
//     };

//     // Collect cart items
//     var cartItems = collectCartItems();

//     var data = {
//       order_id: customerId, // Ideally, this should be a unique order ID
//       order_total: total,
//       payment_method: paymentMethod,
//       cus_id: customerId,
//       deliverm_id: 1,
//       pstat_id: 1,
//       cart_items: cartItems,
//       address: address,
//     };

//     // Make AJAX request to the proxy server
//     $.ajax({
//       url: "http://localhost:3000/api/proxy",
//       type: "POST",
//       contentType: "application/json",
//       data: JSON.stringify(data),
//       success: function (response) {
//         if (
//           response.data &&
//           response.data.attributes &&
//           response.data.attributes.checkout_url
//         ) {
//           window.open(response.data.attributes.checkout_url, "_blank");
//         } else {
//           alert("Checkout URL not available.");
//         }
//       },
//       error: function (xhr, status, error) {
//         console.error("AJAX error:", xhr.responseText);
//         alert(
//           "An error occurred while processing your request. Please try again."
//         );
//       },
//     });
//   });
// });

// // Function to collect cart items
// function collectCartItems() {
//   var items = [];
//   $(".cart-item").each(function () {
//     var item = {
//       prod_id: $(this).data("product-id"),
//       qty: parseInt($(this).find(".quantity").text(), 10),
//       cart_id: $(this).data("cart-id"),
//     };
//     items.push(item);
//   });
//   return items;
// }
