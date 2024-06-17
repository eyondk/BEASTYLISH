document.addEventListener("DOMContentLoaded", function () {
  const ROOT_URL = "http://localhost/beatest/public"; // Replace with your actual root URL

  // Function to update quantity in cart
  function updateQuantity(button, change) {
    const wrapper = button.closest(".wrapper");
    const input = wrapper.querySelector(".num");
    let currentQty = parseInt(input.value);

    // Calculate new quantity
    let newQty = currentQty + change;

    // Ensure quantity doesn't go below 1
    if (newQty < 1) {
      newQty = 1;
    }

    const cartId = wrapper.querySelector('input[type="hidden"]').value;
    const row = wrapper.closest("tr");
    const prodPrice = parseFloat(row.dataset.prodPrice);
    const availableStock = parseInt(row.dataset.prodStock);

    // Ensure quantity doesn't exceed available stock
    if (newQty > availableStock) {
      alert("Cannot exceed available stock");
      input.value = currentQty; // Reset input value to previous quantity
      return; // Exit function if quantity exceeds available stock
    }

    // Update input field with new quantity
    input.value = newQty;

    // Update quantity in the server (you may adjust this part based on your backend implementation)
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
    const cartId = form.querySelector('input[name="cart_id"]').value;

    fetch(ROOT_URL + "/cart/remove", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ cart_id: cartId }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          form.closest("tr").remove();
          updateTotals();
          alert("Item removed successfully.");
        } else {
          console.error("Failed to remove item:", data.error);
          alert("Failed to remove item. Please try again.");
        }
      })
      .catch((error) => {
        console.error("Error removing item:", error);
        alert("Failed to remove item. Please try again.");
      });
  };

  // Function to update totals in cart
  function updateTotals() {
    let itemCount = 0;
    let subtotal = 0;

    document
      .querySelectorAll(".product-display-table tbody tr")
      .forEach((row) => {
        const qty = parseInt(row.querySelector(".num").value);
        const price = parseFloat(row.dataset.prodPrice);

        if (!isNaN(qty) && !isNaN(price)) {
          itemCount += qty;
          subtotal += qty * price;
        }
      });

    const deliveryFeeElem = document.getElementById("delivery-fee");
    let deliveryFee = 0; // Default to 0 if the element is not found

    if (deliveryFeeElem) {
      deliveryFee = parseFloat(deliveryFeeElem.textContent) || 0;
    }

    // const deliveryFeeElem = document.getElementById("delivery-fee");
    // const deliveryFee = parseFloat(deliveryFeeElem.textContent);
    // const deliveryFee = 90;
    // const deliveryFee = parseFloat(
    //   document.getElementById("delivery-fee").textContent
    // );

    const total = subtotal + deliveryFee;

    // Update totals display (adjust as per your HTML structure)
    document.getElementById("item-count").textContent = itemCount;
    document.getElementById("subtotal").textContent = subtotal.toFixed(2);
    document.getElementById("total").textContent = total.toFixed(2);
  }

  // Function to handle adding product to cart
  function addToCart(productId, quantity) {
    fetch(ROOT_URL + "/cart/add", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ product_id: productId, cart_qty: quantity }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          alert("Product added to cart successfully.");
          updateTotals();
        } else {
          throw new Error(data.error || "Unknown error occurred");
        }
      })
      .catch((error) => {
        console.error("Error adding product to cart:", error.message);
        alert(
          "Failed to add product to cart. Quantity exceeds the available stocks."
        );
      });
  }

  // Attach event listeners to "Add to Cart" buttons on product pages
  document.querySelectorAll(".product-button").forEach((button) => {
    button.addEventListener("click", function () {
      const productId = button.dataset.productId;
      addToCart(productId, 1); // Assuming quantity is hardcoded to 1 for product buttons
    });
  });

  // Attach event listeners to quantity buttons
  document.querySelectorAll(".quantity-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const change = button.classList.contains("minus") ? -1 : 1;
      updateQuantity(button, change);
    });
  });

  // Initial call to update totals on page load
  updateTotals();

  // Function to handle deleting all items from the cart
  function deleteAllItems() {
    if (confirm("Are you sure you want to delete all items from your cart?")) {
      fetch(ROOT_URL + "/cart/removeAll", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Network response was not ok");
          }
          return response.text(); // Change to response.text() to debug the response content
        })
        .then((text) => {
          console.log("Server response text:", text); // Log the raw response text for debugging
          try {
            const data = JSON.parse(text); // Parse the response text as JSON
            if (data.success) {
              alert("All items removed successfully.");
              // Remove all rows from the cart table
              const rows = document.querySelectorAll(
                ".product-display-table tbody tr"
              );
              rows.forEach((row) => row.remove());
              // Update totals
              updateTotals();
            } else {
              console.error("Failed to remove items:", data.error);
              alert("Failed to remove items. Please try again.");
            }
          } catch (error) {
            console.error("Error parsing JSON:", error, "Response text:", text);
            alert("Failed to remove items. Invalid response from server.");
          }
        })
        .catch((error) => {
          console.error("Error removing items:", error);
          alert("Failed to remove items. Please try again.");
        });
    }
  }

  // Attach event listener to "Delete All Items" button
  const deleteAllBtn = document.getElementById("delete-all");
  if (deleteAllBtn) {
    deleteAllBtn.addEventListener("click", deleteAllItems);
  } else {
    console.warn("Delete All button not found.");
  }
});
