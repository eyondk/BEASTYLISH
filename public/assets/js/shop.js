document.addEventListener("DOMContentLoaded", function () {
  const ROOT_URL = "http://localhost/BEASTYLISH/public"; // Update with your actual root URL

  const accBtn = document.getElementById("acc-btn");
  const brandnewBtn = document.getElementById("brandnew-btn");
  const prelovedBtn = document.getElementById("preloved-btn");
  const accShow = document.getElementById("acc-show");
  const brandnewShow = document.getElementById("brandnew-show");
  const prelovedShow = document.getElementById("preloved-show");
  const modal = document.getElementById("myModal");
  const cards = document.querySelectorAll(".product-card");
  const span = document.getElementsByClassName("close")[0];

  let productStock = 0; // Variable to track product stock

  // Sub-menus js
  if (accBtn && brandnewBtn && prelovedBtn) {
    accBtn.addEventListener("click", function (event) {
      event.preventDefault();
      accShow.classList.toggle("show");
      accBtn.querySelector(".fa-chevron-down").classList.toggle("flip");
    });

    brandnewBtn.addEventListener("click", function (event) {
      event.preventDefault();
      brandnewShow.classList.toggle("show");
      brandnewBtn.querySelector(".fa-chevron-down").classList.toggle("flip");
    });

    prelovedBtn.addEventListener("click", function (event) {
      event.preventDefault();
      prelovedShow.classList.toggle("show");
      prelovedBtn.querySelector(".fa-chevron-down").classList.toggle("flip");
    });
  }

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

    // Update cart totals (uncomment and adjust element IDs as necessary)
    // const itemCountElem = document.getElementById("item-count");
    // const subtotalElem = document.getElementById("subtotal");
    // const totalElem = document.getElementById("total");

    // if (itemCountElem) itemCountElem.textContent = itemCount;
    // if (subtotalElem) subtotalElem.textContent = subtotal.toFixed(2);
    // if (totalElem) totalElem.textContent = total.toFixed(2);
  }


  // Handle product card clicks to show modal with product details
  cards.forEach(function (card) {
    card.addEventListener("click", function () {
      const productId = this.getAttribute("data-id");
      const productImage = this.getAttribute("data-image");
      const productName = this.getAttribute("data-name");
      const productPrice = parseFloat(this.getAttribute("data-price"));
      const productDescription = this.getAttribute("data-description");
      const productDiscount = parseInt(this.getAttribute("data-discount"));
      productStock = parseInt(this.getAttribute("data-stock"));

      document.querySelector(".modal-product-img").src = "../public/assets/images/",productImage;
      document.querySelector(".modal-product-name").textContent = productName;
      document.querySelector(".modal-description").textContent =
        productDescription;
      document.querySelector(
        ".modal-stock"
      ).textContent = `Available Stock: ${productStock}`;
      document
        .querySelector(".modal-add-btn")
        .setAttribute("data-id", productId);
      document
        .querySelector(".modal-add-btn")
        .setAttribute("data-name", productName);
      document
        .querySelector(".modal-add-btn")
        .setAttribute("data-price", productPrice);

      if (productDiscount > 0) {
        const discountedPrice =
          productPrice - (productPrice * productDiscount) / 100;
        document.querySelector(
          ".modal-price-num"
        ).innerHTML = `&#x20B1;${discountedPrice.toFixed(2)}`;
        document.querySelector(
          ".modal-origprice-num"
        ).innerHTML = `<del>&#x20B1;${productPrice.toFixed(2)}</del>`;
        document.querySelector(
          ".modal-sale"
        ).textContent = `${productDiscount}%`;
      } else {
        document.querySelector(
          ".modal-price-num"
        ).innerHTML = `&#x20B1;${productPrice.toFixed(2)}`;
        document.querySelector(".modal-origprice-num").innerHTML = "";
        document.querySelector(".modal-sale").textContent = "";
      }

      modal.style.display = "block";
    });
  });

  // Close modal when clicking on the close button or outside the modal
  span.onclick = function () {
    modal.style.display = "none";
  };

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };

  // Handle product quantity changes in modal
  const plusButton = document.querySelector(".plus");
  const minusButton = document.querySelector(".minus");
  const numInput = document.querySelector(".num");

  let count = parseInt(numInput.value);
  plusButton.addEventListener("click", function () {
    if (count < productStock) {
      count++;
      numInput.value = count < 10 ? "0" + count : count;
      minusButton.style.color = "#6c4a21";
      minusButton.style.cursor = "pointer";
      minusButton.disabled = false;
      plusButton.classList.add("clicked");
      setTimeout(() => {
        plusButton.classList.remove("clicked");
      }, 200);
    } else {
      alert("Cannot exceed available stock");
    }
  });

  minusButton.addEventListener("click", function () {
    if (count > 1) {
      count--;
      numInput.value = count < 10 ? "0" + count : count;
      if (count === 1) {
        minusButton.style.color = "#6c4a2186";
        minusButton.style.cursor = "not-allowed";
        minusButton.disabled = true;
      }
      minusButton.classList.add("clicked");
      setTimeout(() => {
        minusButton.classList.remove("clicked");
      }, 200);
    }
  });

  // Function to fetch cart quantity for a specific product
  function fetchCartQuantity(productId) {
    return fetch(ROOT_URL + "/cart/quantity", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ product_id: productId }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          return data.quantity;
        } else {
          throw new Error(data.message || "Failed to fetch cart quantity.");
        }
      })
      .catch((error) => {
        console.error("Error fetching cart quantity:", error.message);
        alert("Failed to fetch cart quantity. Please try again.");
        return 0;
      });
  }

  // Function to handle adding product to cart
  function addToCart(productId, productName, productPrice, quantity) {
    fetch(ROOT_URL + "/cart/add", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        product_id: productId,
        product_name: productName,
        product_price: productPrice,
        cart_qty: quantity,
      }),
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
        alert("Failed to add product to cart. Please try again.");
      });
  }

  // Add event listener to "Add to Cart" button in modal
  document
    .querySelector(".modal-add-btn")
    .addEventListener("click", function () {
      const productId = this.getAttribute("data-id");
      const productName = this.getAttribute("data-name");
      const productPrice = parseFloat(this.getAttribute("data-price"));
      const quantity = parseInt(numInput.value);

      if (isNaN(quantity) || quantity < 1) {
        alert("Please enter a valid quantity.");
        return;
      }

      fetchCartQuantity(productId).then((cartQuantity) => {
        const totalQuantity = cartQuantity + quantity;
        if (totalQuantity > productStock) {
          alert("The total quantity in the cart exceeds available stock.");
        } else {
          addToCart(productId, productName, productPrice, quantity);
          modal.style.display = "none";
        }
      });
    });
});