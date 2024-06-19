document.addEventListener("DOMContentLoaded", function() {
    const editadminbtn = document.getElementById("updateprofilebtn");
    const editadminSec = document.getElementById("updateprofileSec");
    const profileadminSec = document.getElementById("profile");
    const backbtn = document.getElementById("back-btn");

 
    editadminbtn.addEventListener("click", function(event){
         event.preventDefault();  // Prevent default action if any
         editadminSec.style.display = "block";
         profileadminSec.style.display = "none";
    });

    backbtn.addEventListener("click", function(event){
          editadminSec.style.display = "none";
          profileadminSec.style.display = "block";
    });
 });