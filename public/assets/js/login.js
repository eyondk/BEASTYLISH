document.addEventListener("DOMContentLoaded", function () {
    var forgotpassbtn = document.getElementById("forgotpass");
    var resetpassSec = document.getElementById("resetpass");
    var loginformSec = document.getElementById("loginform");
    var btnBack = document.getElementById('btn-back');

    forgotpassbtn.onclick = function(){
        resetpassSec.style.display = "flex";
        loginformSec.style.display = "none";
    };

    btnBack.addEventListener('click', function(event) {
        event.preventDefault();
        resetpassSec.style.display = 'none';
        loginformSec.style.display = 'flex';
    });
});
