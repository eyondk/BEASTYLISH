var addmodal = document.getElementById("addProdModal");
var editmodal = document.getElementById("editProdModal");
var deletemodal = document.getElementById("deleteProdModal");

var addbtn = document.getElementById("addmodal");
var editbtn = document.getElementById("editbtn");
var deletebtn = document.getElementById("deletebtn");

var span = document.getElementsByClassName("closemodal");
var cancel = document.getElementsByClassName("opt-btn");

// to open modals
addbtn.onclick = function() {
  addmodal.style.display = "block";
}

editbtn.onclick = function(){
    editmodal.style.display = "block";
}


deletebtn.onclick = function(){
    deletemodal.style.display = "block";
}

// to close modals
for (var i = 0; i < span.length; i++) {
    span[i].onclick = function() {
      addmodal.style.display = "none";
      editmodal.style.display = "none";
      deletemodal.style.display = "none";
    }
}
  
for (var i = 0; i < cancel.length; i++) {
    cancel[i].onclick = function() {
      addmodal.style.display = "none";
      editmodal.style.display = "none";
      deletemodal.style.display = "none";
    }
}

window.onclick = function(event) {
  if (event.target == addmodal) {
    addmodal.style.display = "none";
  }
  if (event.target == editmodal){
    editmodal.style.display = "none";
  }
  if (event.target == deletemodal){
    deletemodal.style.display = "none";
  }
}