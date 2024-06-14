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

    // Update input field with new quantity
    input.value = newQty;

    const cartId = wrapper.querySelector('input[type="hidden"]').value;
    const row = wrapper.closest("tr");
    const prodPrice = parseFloat(row.dataset.prodPrice);

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
          console.error("Failed to update quantity:", data.error);
          alert("Failed to update quantity. Please try again.");
        }
      })
      .catch((error) => {
        console.error("Error updating quantity:", error);
        alert("Failed to update quantity. Please try again.");
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

    const deliveryFee = 90.0;
    const discount = 100.0;
    const total = subtotal + deliveryFee - discount;

    const itemCountElem = document.getElementById("item-count");
    const subtotalElem = document.getElementById("subtotal");
    const totalElem = document.getElementById("total");

    if (itemCountElem) {
      itemCountElem.textContent = itemCount;
    } else {
      console.warn("Item count element not found.");
    }

    if (subtotalElem) {
      subtotalElem.textContent = subtotal.toFixed(2);
    } else {
      console.warn("Subtotal element not found.");
    }

    if (totalElem) {
      totalElem.textContent = total.toFixed(2);
    } else {
      console.warn("Total element not found.");
    }
  }

  // Attach event listeners to quantity buttons using event delegation
  document.addEventListener("click", function (event) {
    if (event.target.matches(".qty-container .minus")) {
      updateQuantity(event.target, -1); // Decrease by 1
    } else if (event.target.matches(".qty-container .plus")) {
      updateQuantity(event.target, 1); // Increase by 1
    }
  });

  // Function to handle adding product to cart
  function addToCart(productId) {
    fetch(ROOT_URL + "/cart/add", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ product_id: productId, cart_qty: 1 }),
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
          console.error("Failed to add product to cart:", data.error);
          alert("Failed to add product to cart. Please try again.");
        }
      })
      .catch((error) => {
        console.error("Error adding product to cart:", error);
        alert("Failed to add product to cart. Please try again.");
      });
  }

  // Attach event listeners to "Add to Cart" buttons
  document.querySelectorAll(".product-button").forEach((button) => {
    button.addEventListener("click", function () {
      const productId = button.dataset.productId;
      addToCart(productId);
    });
  });

  // Initial call to update totals on page load
  updateTotals();
});
