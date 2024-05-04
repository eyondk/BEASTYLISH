document.addEventListener("DOMContentLoaded", function() {
    const accountInfoLink = document.getElementById("account-info-link");
    const changepasslink = document.getElementById("change-pass-link");
    const orderslink = document.getElementById("orders-link");
    const accInfoSection = document.querySelector(".acc_info");
    const changePassSec = document.querySelector(".changePass");
    const ordersSec = document.querySelector(".orders");
    const editProfilebtn = document.querySelector(".btn"); 
    const backbtn = document.querySelector(".option-btn");
    const editForm = document.querySelector(".edit_acc");
    const users = document.querySelector(".user_details");
    const changePass = document.querySelector(".changepass");


    accountInfoLink.addEventListener("click", function(event) {

        if (accInfoSection.style.display === "none" || accInfoSection.style.display === "") {
            accInfoSection.style.display = "flex";
            changePassSec.style.display ="none"; 
            ordersSec.style.display = "none"; 
            
        } 
    });

    changepasslink.addEventListener("click", function(event){
        if(changePassSec.style.display === "none" || changePassSec.style.display === ""){
            changePassSec.style.display = "flex";
            accInfoSection.style.display = "none";
            ordersSec.style.display = "none";
        }
    });


    orderslink.addEventListener("click", function(event){
        if(ordersSec.style.display === "none" || ordersSec.style.display === ""){
            ordersSec.style.display = "flex";
            changePassSec.style.display ="none"; 
            accInfoSection.style.display = "none"; 


        }

    });

    editProfilebtn.addEventListener("click", function(event) { 
        event.preventDefault(); 

        editForm.style.display = "block"; // Display the edit_acc form

        users.style.display = "none";
    });


    backbtn.addEventListener("click", function(event){
        event.preventDefault();

        users.style.display = "block";
        editForm.style.display = "none";
    });




});
