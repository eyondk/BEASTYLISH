$(document).ready(function () {
  const ROOT_URL = "http://localhost/BEASTYLISH/public"; // Replace with your actual root URL

  // Function to update quantity in cart
  function updateQuantity(button, change) {
    // const $wrapper = $(button).closest(".wrapper");
    // const $input = $wrapper.find(".num");
    // let currentQty = parseInt($input.val());
    //changed
    const wrapper = button.closest(".wrapper");
    const input = wrapper.querySelector(".num");
    let currentQty = parseInt(input.value);

    // Calculate new quantity
    let newQty = currentQty + change;

    // Ensure quantity doesn't go below 1
    if (newQty < 1) {
      newQty = 1;
    }

    // const cartId = $wrapper.find('input[type="hidden"]').val();
    // const $row = $wrapper.closest("tr");
    // const prodPrice = parseFloat($row.data("prodPrice"));
    // var availableStock = parseInt($row.data("prodStock"));
    //changed
    const cartId = wrapper.querySelector('input[type="hidden"]').value;
    const row = wrapper.closest("tr");
    const prodPrice = parseFloat(row.dataset.prodPrice);
    const availableStock = parseInt(row.dataset.prodStock);

    console.log("Prod Price", prodPrice, "Stock", availableStock);
    // if (newQty > availableStock) {
    //   alert("Cannot exceed available stock");
    //   $input.val(currentQty); // Reset input value to previous quantity
    //   return; // Exit function if quantity exceeds available stock
    // }
    //changed
    if (newQty > availableStock) {
      alert("Cannot exceed available stock");
      input.value = currentQty; // Reset input value to previous quantity
      return; // Exit function if quantity exceeds available stock
    }

    // Update input field with new quantity
    // $input.val(newQty);
    //changed
    input.value = newQty;

    // Update quantity in the server (you may adjust this part based on your backend implementation)
    //     $.ajax({
    //       url: ROOT_URL + "/cart/update",
    //       method: "POST",
    //       contentType: "application/json",
    //       data: JSON.stringify({ cart_id: cartId, cart_qty: newQty }),
    //       success: function (data) {
    //         if (data.success) {
    //           // Update subtotal displayed on the page
    //           const $subtotalElem = $row.find(".subtotal");
    //           const newSubtotal = prodPrice * newQty;
    //           $subtotalElem.text("₱ " + newSubtotal.toFixed(2));

    //           // Update total and other calculations
    //           updateTotals();
    //         } else {
    //           console.error("Failed to update quantity:", data.error);
    //           alert("Failed to update quantity. Please try again.");
    //         }
    //       },
    //       error: function (xhr, status, error) {
    //         console.error("Error updating quantity:", error);
    //         alert("Failed to update quantity. Please try again.");
    //       },
    //     });
    //   }
    //changed
    fetch(ROOT_URL + "/cart/update", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ cart_id: cartId, cart_qty: newQty }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          // Update subtotal displayed on the page
          const subtotalElem = row.querySelector(".subtotal");
          const newSubtotal = prodPrice * newQty;
          subtotalElem.textContent = "₱ " + newSubtotal.toFixed(2);

          // Update total and other calculations
          updateTotals();
        } else {
          console.error(
            "Failed to update quantity:",
            data.error || "Unknown error"
          );
          alert("Failed to update quantity. Please try again.");
          // Restore previous quantity in case of failure
          input.value = currentQty;
          location.reload();
        }
      })
      .catch((error) => {
        console.error("Error updating quantity:", error.message);
        alert("Failed to update quantity. Please try again.");
        // Restore previous quantity in case of error
        input.value = currentQty;
      });
  }

  window.updateQuantity = updateQuantity;

  // Function to remove item from cart
  window.removeItem = function (event, form) {
    event.preventDefault();
    const cartId = $(form).find('input[name="cart_id"]').val();

    $.ajax({
      url: ROOT_URL + "/cart/remove",
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify({ cart_id: cartId }),
      success: function (data) {
        if (data.success) {
          $(form).closest("tr").remove();
          updateTotals();
          alert("Item removed successfully.");
        } else {
          console.error("Failed to remove item:", data.error);
          alert("Failed to remove item. Please try again.");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error removing item:", error);
        alert("Failed to remove item. Please try again.");
      },
    });
  };
  $(document).on("change", 'input[name="selected_items[]"]', function () {
    updateTotals();
  });

  function updateTotals() {
    let itemCount = 0;
    let subtotal = 0;

    // Calculate totals only for selected items
    $(".product-display-table tbody tr").each(function () {
      const $checkbox = $(this).find('input[name="selected_items[]"]');
      if ($checkbox.is(":checked")) {
        const qty = parseInt($(this).find(".num").val());
        const price = parseFloat($(this).data("prod-price"));

        if (!isNaN(qty) && !isNaN(price)) {
          itemCount += qty;
          subtotal += qty * price;
        }
      }
    });

    const deliveryFee = 90.0;

    const total = subtotal + deliveryFee;

    $("#item-count").text(itemCount);
    $("#subtotal").text("₱ " + subtotal.toFixed(2));
    $("#total").text("₱ " + total.toFixed(2));
  }

  //   $(document).on("click", ".qty-container .minus", function () {
  //     updateQuantity(this, -1); // Decrease by 1
  //   });

  //   $(document).on("click", ".qty-container .plus", function () {
  //     updateQuantity(this, 1); // Increase by 1
  //   });

  // Function to handle adding product to cart
  function addToCart(productId) {
    $.ajax({
      url: ROOT_URL + "/cart/add",
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify({ product_id: productId, cart_qty: 1 }),
      success: function (data) {
        if (data.success) {
          alert("Product added to cart successfully.");
          updateTotals();
        } else {
          console.error("Failed to add product to cart:", data.error);
          alert("Failed to add product to cart. Please try again.");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error adding product to cart:", error);
        alert("Failed to add product to cart. Please try again.");
      },
    });
  }
  //chhanged
  document.querySelectorAll(".quantity-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const change = button.classList.contains("minus") ? -1 : 1;
      updateQuantity(button, change);
    });
  });
  //00
  // Attach event listeners to "Add to Cart" buttons
  $(".product-button").on("click", function () {
    const productId = $(this).data("productId");
    addToCart(productId);
  });

  // Initial call to update totals on page load
  updateTotals();

  // Function to handle the checkout process
  function proceedToCheckout() {
    const selectedItems = [];
    $('input[name="selected_items[]"]:checked').each(function () {
      const row = $(this).closest("tr");
      const cartId = row.data("cart-id");
      const cartQty = row.find(".num").val();

      selectedItems.push({
        cart_id: cartId,
        cart_qty: cartQty,
      });
    });

    if (selectedItems.length === 0) {
      alert("Please select at least one item to proceed to checkout.");
      return;
    }

    $.ajax({
      url: ROOT_URL + "/Checkout/processCheckout",
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify({ selected_items: selectedItems }),
      success: function (response) {
        console.log("Response from server:", response); // Log the full response
        sessionStorage.setItem("checkoutData", JSON.stringify(response.data));
        window.location.href = ROOT_URL + "/Checkout";
      },
      error: function (xhr, status, error) {
        console.error("Checkout error:", error);
        alert("Error processing checkout. Please try again.");
      },
    });
  }

  // Attach event listener to the checkout button
  $("#proceedtocheckout").on("click", function (e) {
    e.preventDefault(); // Prevent default form submission
    proceedToCheckout();
  });
});
