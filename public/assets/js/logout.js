document.addEventListener('DOMContentLoaded', function () {

    var detailsmodal = document.getElementById('detailsModal');
    var cancelmodal = document.getElementById('cancelModal');
    var modifymodal = document.getElementById('modifyModal');
    var logoutmodal = document.getElementById('logoutModal');


    // close
    var span = document.getElementsByClassName("close");
    var back = document.getElementsByClassName("back");

    var logoutbtn = document.getElementsByClassName("logoutbtn");


    
    window.logout = function(){
        logoutmodal.style.display = 'flex';
    }

    window.viewDetails = function (productId) {
        detailsmodal.style.display = 'flex';
    };
    


    // Function to handle order modification
    window.modifyOrder = function (productId) {
        // alert("Modify order: " + productId);

        modifymodal.style.display = 'flex';
    };

    window.cancelOrder = function (productId) {
        cancelmodal.style.display = 'flex';

    };

    logoutbtn.onclick = function (){
        window.location.href = '../Account/logout';
        
    }
    
    for (var i = 0; i < span.length; i++) {
        span[i].onclick = function () {
            detailsmodal.style.display = 'none';
            cancelmodal.style.display = 'none';   
            modifymodal.style.display = 'none'; 

        }
    }


    
    for (var i = 0; i < back.length; i++) {
        back[i].onclick = function () {
            cancelmodal.style.display = 'none';
            modifymodal.style.display = 'none';
            logoutmodal.style.display = 'none';
    
        }
    }

    

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == detailsmodal) {
            detailsmodal.style.display = 'none';
        }

        if(event.target == cancelmodal){
            cancelmodal.style.display = 'none';
        }
        if(event.target == modifymodal){
            modifymodal.style.display = 'none';
        }
    };
});