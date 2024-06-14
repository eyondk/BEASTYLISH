document.addEventListener("DOMContentLoaded", function () {
    const accBtn = document.getElementById("acc-btn");
    const brandnewBtn = document.getElementById("brandnew-btn");
    const prelovedBtn = document.getElementById("preloved-btn");
    const accShow = document.getElementById("acc-show");
    const brandnewShow = document.getElementById("brandnew-show");
    const prelovedShow = document.getElementById("preloved-show");
    const plusButton = document.querySelector(".plus");
    const minusButton = document.querySelector(".minus");
    const numInput = document.querySelector(".num");
    const modal = document.getElementById("myModal");
    const cards = document.querySelectorAll(".product-card");
    const span = document.getElementsByClassName("close")[0];
  
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
  
    // js for product details card modal start
    cards.forEach(function (card) {
      card.addEventListener("click", function (event) {
        event.stopPropagation(); // Prevent event from propagating to the modal
  
        const productImage = this.getAttribute("data-image");
        const productName = this.getAttribute("data-name");
        const productPrice = parseFloat(this.getAttribute("data-price"));
        const productDescription = this.getAttribute("data-description");
        const productDiscount = parseInt(this.getAttribute("data-discount"));
  
        document.querySelector(".modal-product-img").src = productImage;
        document.querySelector(".modal-product-name").textContent = productName;
        document.querySelector(".modal-description").textContent =
          productDescription;
  
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
  
    span.onclick = function () {
      modal.style.display = "none";
    };
  
    window.onclick = function (event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };
  
    // product qty start
    let count = parseInt(numInput.value);
    plusButton.addEventListener("click", function () {
      count++;
      numInput.value = count < 10 ? "0" + count : count;
      minusButton.style.color = "#6c4a21";
      minusButton.style.cursor = "pointer";
      minusButton.disabled = false;
      plusButton.classList.add("clicked");
      setTimeout(() => {
        plusButton.classList.remove("clicked");
      }, 200);
    });
  
    minusButton.addEventListener("click", function () {
      if (count > 1) {
        count--;
        numInput.value = count < 10 ? "0" + count : count;
        minusButton.classList.add("clicked");
        setTimeout(() => {
          minusButton.classList.remove("clicked");
        }, 200);
      } else {
        minusButton.style.color = "#6c4a2186";
        minusButton.disabled = true;
      }
    });
  
    // Handle input to allow only numbers
    numInput.addEventListener("input", function () {
      this.value = this.value.replace(/\D/g, "");
      count = parseInt(this.value) || 0;
      if (count < 1) {
        count = 1;
        this.value = "1";
      }
  
      if (count > 1) {
        minusButton.style.color = "#6c4a21";
        minusButton.style.cursor = "pointer";
        minusButton.disabled = false;
      } else {
        minusButton.style.color = "#6c4a2186";
        minusButton.style.cursor = "not-allowed";
        minusButton.disabled = true;
      }
    });
  
    // product qty end
  });