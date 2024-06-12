document.addEventListener("DOMContentLoaded", function () {
    var forgotpassbtn = document.getElementById("forgotpass");
    var resetformsSec = document.getElementById("resetpass");
    var loginformsec = document.getElementById("loginform");

    forgotpassbtn.onclick = function(){
        resetformsSec.style.display = "flex";
        loginformsec.style.display = "none";

    };
});