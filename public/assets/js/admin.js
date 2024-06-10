document.addEventListener("DOMContentLoaded", function() {
  const prodBtn = document.getElementById("prod-btn");
  const prodShow = document.getElementById("prod-show");
  const orderBtn = document.getElementById("order-btn");
  const orderShow = document.getElementById("order-show");
  const toggleBtn = document.querySelector('.toggle');
  const sidebar = document.querySelector('.sidebar');

  if (toggleBtn) {
      toggleBtn.addEventListener("click", function () {
          sidebar.classList.toggle("close");
      });
  }

  if (orderBtn) {
      orderBtn.addEventListener("click", function(event) {
          event.preventDefault();
          orderShow.classList.toggle("show");
          orderBtn.querySelector(".fa-chevron-down").classList.toggle("flip");

          const parentLi = orderBtn.parentElement;
          const submenuHeight = orderShow.classList.contains('show') ? orderShow.scrollHeight : 0;

          let nextElement = parentLi.nextElementSibling;
          while (nextElement) {
              nextElement.style.marginTop = orderShow.classList.contains('show') ? `${submenuHeight}px` : '0';
              nextElement = nextElement.nextElementSibling;
          }
      });
  }

  if (prodBtn) {
      prodBtn.addEventListener("click", function(event) {
          event.preventDefault();
          prodShow.classList.toggle("show");
          prodBtn.querySelector(".fa-chevron-down").classList.toggle("flip");

          const parentLi = prodBtn.parentElement;
          const submenuHeight = prodShow.classList.contains('show') ? prodShow.scrollHeight : 0;

          let nextElement = parentLi.nextElementSibling;
          while (nextElement) {
              nextElement.style.marginTop = prodShow.classList.contains('show') ? `${submenuHeight}px` : '0';
              nextElement = nextElement.nextElementSibling;
          }
      });
  }
});
