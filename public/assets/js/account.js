document.addEventListener("DOMContentLoaded", function() {
    const accountInfoLink = document.getElementById("account-info-link");
    const changepasslink = document.getElementById("change-pass-link");
    const orderslink = document.getElementById("orders-link");
    const faqLink = document.getElementById("faq-link");
    const addlink = document.getElementById("address-link");

    const accInfoSection = document.querySelector(".acc_info");
    const changePassSec = document.querySelector(".changePass");
    const ordersSec = document.querySelector(".orders");
    const editProfilebtn = document.querySelector(".btn"); 
    const editForm = document.querySelector(".edit_acc");
    const users = document.querySelector(".user_details");
    const faqSec = document.querySelector(".faqSection");
    const addSec = document.querySelector(".addressSec");
    const editAdd = document.querySelector(".edit_add");
    const editAddform = document.querySelector(".edit_address");
    const viewadd = document.querySelector(".address_details");

    const backbtn = document.querySelector(".option-btn");
    const bacbtn = document.querySelector(".back-btn");




    addlink.addEventListener("click", function(event){
        addSec.style.display = "flex";
        faqSec.style.display = "none";
        accInfoSection.style.display = "none";
        changePassSec.style.display = "none"; 
        ordersSec.style.display = "none"; 

    });


    faqLink.addEventListener("click", function(event){
        faqSec.style.display = "flex";
        accInfoSection.style.display = "none";
        changePassSec.style.display = "none"; 
        ordersSec.style.display = "none"; 
        addSec.style.display = "none";

    });


    accountInfoLink.addEventListener("click", function(event) {

        if (accInfoSection.style.display === "none" || accInfoSection.style.display === "") {
            accInfoSection.style.display = "flex";
            changePassSec.style.display ="none"; 
            ordersSec.style.display = "none"; 
            faqSec.style.display = "none";
            addSec.style.display = "none";


        } 
    });

    changepasslink.addEventListener("click", function(event){
        if(changePassSec.style.display === "none" || changePassSec.style.display === ""){
            changePassSec.style.display = "flex";
            accInfoSection.style.display = "none";
            ordersSec.style.display = "none";
            faqSec.style.display = "none";
            addSec.style.display = "none";

        }
    });


    orderslink.addEventListener("click", function(event){
        if(ordersSec.style.display === "none" || ordersSec.style.display === ""){
            ordersSec.style.display = "flex";
            changePassSec.style.display ="none"; 
            accInfoSection.style.display = "none"; 
            faqSec.style.display = "none";
            addSec.style.display = "none";



        }

    });

    editAdd.addEventListener("click", function(event){
        event.preventDefault();

        editAddform.style.display = "block";
        viewadd.style.display = "none";


    });



    editProfilebtn.addEventListener("click", function(event) { 
        event.preventDefault(); 

        editForm.style.display = "block"; // Display the edit_acc form
        users.style.display = "none";

    });


    bacbtn.addEventListener("click", function(event){
        event.preventDefault();

        editAddform.style.display = "none";
        viewadd.style.display = "block";

    });


    backbtn.addEventListener("click", function(event){
        event.preventDefault();

        users.style.display = "block";
        editForm.style.display = "none";

    });

    

    const faqQuestions = document.querySelectorAll('.faq-question');

    faqQuestions.forEach(question => {
        question.addEventListener('click', function () {
            const answer = this.nextElementSibling;
            const plusIcon = this.querySelector('.plus-icon');
            if (answer.style.display === "none" || answer.style.display === "") {
                answer.style.display = "block";
                plusIcon.textContent = "-";
            } else {
                answer.style.display = "none";
                plusIcon.textContent = "+";
            }
        });
    });


});