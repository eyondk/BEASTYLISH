document.addEventListener("DOMContentLoaded", function () {


    var addmodal = document.getElementById("addCatModal");
    var deletemodal = document.getElementById("deleteCatModal");
    var editmodal = document.getElementById("editCatModal");

    var addbtn = document.getElementById("addcatmodal");
    var editbtn = document.getElementById("editcatmodal");
    var deletebtn = document.getElementById("deletecatmodal");

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

    // Close modals
    for (var i = 0; i < span.length; i++) {
        span[i].onclick = function () {
            addmodal.style.display = "none";
            editmodal.style.display = "none";
            deletemodal.style.display = "none";
        };
    }

    for (var i = 0; i < cancel.length; i++) {
        cancel[i].onclick = function () {
            addmodal.style.display = "none";
            editmodal.style.display = "none";
            deletemodal.style.display = "none";
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
       
    };
});
