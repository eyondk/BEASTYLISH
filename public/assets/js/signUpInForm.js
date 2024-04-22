const loginBtn=document.getElementById('loginlink')
const signupBtn= document.getElementById('signuplink')
const signupform = document.getElementById('signUp')
const loginform = document.getElementById('logIn')
const rememberMeSection = document.querySelector('.rememberme');
const iconElement = rememberMeSection.querySelector('label i');
const rememberCheckbox = rememberMeSection.querySelector('input[type="checkbox"]');


signupBtn.addEventListener('click', function(){
    loginform.style.display="none";
    signupform.style.display="block";
})

loginBtn.addEventListener('click', function(){
    loginform.style.display="block";
    signupform.style.display="none";
})

rememberCheckbox.addEventListener('change', function() {
    if (this.checked) {
        iconElement.style.display = 'inline'; // Display the icon if checkbox is checked
    } else {
        iconElement.style.display = 'none'; // Hide the icon if checkbox is unchecked
    }
});