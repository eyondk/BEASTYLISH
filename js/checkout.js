document.addEventListener("DOMContentLoaded", function () {

    var cancelbtn = document.getElementById("cancel");
    var span = document.getElementsByClassName("closecheck");
    var checkoutbtn = document.getElementById("checkoutbtn");
    var checkedoutmodal = document.getElementById("checkedModal");
    

    

    cancelbtn.onclick = function (){
        window.location = "cart.php";
    };


    checkoutbtn.onclick = function () {
        checkedoutmodal.style.display = "block";
    };

    
    span.onclick = function () {
        checkedoutmodal.style.display = "none";
        
    };


    // Close modals on window click
    window.onclick = function (event) {
        if (event.target == checkedoutmodal) {
            checkedoutmodal.style.display = "none";
        }
       
    };
});
