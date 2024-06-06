document.addEventListener("DOMContentLoaded", function () {
    var addmodal = document.getElementById("addProdModal");
    var editmodal = document.getElementById("editProdModal");
    var deletemodal = document.getElementById("deleteProdModal");
    var viewmodal = document.getElementById("viewProdModal");

    var addbtn = document.getElementById("addmodal");
    var editbtn = document.getElementById("editbtn");
    var deletebtn = document.getElementById("deletebtn");
    var viewbtns = document.querySelectorAll(".view");

    var span = document.getElementsByClassName("closemodal");
    var cancel = document.getElementsByClassName("opt-btn");

    // to open modals
    if (addbtn) {
        addbtn.onclick = function () {
            addmodal.style.display = "block";
        };
    }

    if (editbtn) {
        editbtn.onclick = function () {
            editmodal.style.display = "block";
        };
    }

    if (deletebtn) {
        deletebtn.onclick = function () {
            deletemodal.style.display = "block";
        };
    }

    // Attach event listeners to each view button
    viewbtns.forEach(function (btn) {
        btn.onclick = function () {
            var orderID = btn.getAttribute("data-order-id");
            var customerName = btn.getAttribute("data-customer-name");
            var phone = btn.getAttribute("data-phone");
            var email = btn.getAttribute("data-email");
            var address = btn.getAttribute("data-address");

            document.getElementById("orderID").textContent = orderID;
            document.getElementById("customerName").textContent = customerName;
            document.getElementById("phoneNumber").textContent = phone;
            document.getElementById("email").textContent = email;
            document.getElementById("address").textContent = address;

            viewmodal.style.display = "block";
        };
    });

    // Close modals
    for (var i = 0; i < span.length; i++) {
        span[i].onclick = function () {
            addmodal.style.display = "none";
            editmodal.style.display = "none";
            deletemodal.style.display = "none";
            viewmodal.style.display = "none";
        };
    }

    for (var i = 0; i < cancel.length; i++) {
        cancel[i].onclick = function () {
            addmodal.style.display = "none";
            editmodal.style.display = "none";
            deletemodal.style.display = "none";
            viewmodal.style.display = "none";
        };
    }

    // Close modals on window click
    window.onclick = function (event) {
        if (event.target == addmodal) {
            addmodal.style.display = "none";
        }
        if (event.target == editmodal) {
            editmodal.style.display = "none";
        }
        if (event.target == deletemodal) {
            deletemodal.style.display = "none";
        }
        if (event.target == viewmodal) {
            viewmodal.style.display = "none";
        }
    };
});
