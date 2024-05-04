<?php require('shared/header.inc.php')?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" type="text/css" href="../../public/assets/css/contact.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<body>
    <div class="contact-container">
        <form action="https://api.web3forms.com/submit" method="POST" class="contact-left">
            <div class="contact-left-title">
                <h2>CONTACT US</h2>
                <hr>
                <h3><i class='fas fa-phone-square' style='font-size:24px'></i>+63 9275 669 888</h3>
                <h3><i class='fas fa-mail-bulk' style='font-size:24px'></i>beatrice061599@gmail.com</h3>
            </div>

            <input type="hidden" name="access_key" value="">
            <input type="text" name="name" placeholder="Your Name" class="contact-inputs" required>
            <input type="email" name="email" placeholder="Your Email" class="contact-inputs" required>
            <textarea name="message" placeholder="Your Message" class="contact-inputs" required></textarea>
            <button type="submit">Submit</button>
        </form>
        <div class="contact-right">
           
        </div>
    </div>
    

</body>
</html>