document.addEventListener("DOMContentLoaded", function () {
  const cards = document.querySelectorAll(".product-gallery .product-card");
  const modal = document.getElementById("myModal");
  const modalContent = modal.querySelector(".modal-content");
  const span = modal.querySelector(".close");

  cards.forEach(function (card) {
    card.addEventListener("click", function () {
      const productName = card.querySelector(".details .product-name");
      const productPrice = card.querySelector(".size-price .price-num");
      const productOldPrice = card.querySelector(
        ".size-price .origprice-num del"
      );
      const productDescription = card.querySelector(".size-price .prod-det");
      const productImage = card.querySelector(".main-images .product-img");

      if (
        productName &&
        productPrice &&
        productOldPrice &&
        productDescription &&
        modalContent &&
        productImage
      ) {
        modalContent.querySelector(".product-name").textContent =
          productName.textContent;
        modalContent.querySelector(".price-num").textContent =
          productPrice.textContent;
        modalContent.querySelector(".origprice-num del").textContent =
          productOldPrice.textContent;
        modalContent.querySelector(".prod-det").textContent =
          productDescription.textContent;
        modalContent.querySelector(".product-img").src = productImage.src;

        modal.style.display = "block";
      } else {
        console.error(
          "One or more product details elements or modal content not found."
        );
      }
    });
  });

  span.onclick = function () {
    modal.style.display = "none";
  };

  window.onclick = function (event) {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  };
});
