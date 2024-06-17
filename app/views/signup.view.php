<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components.css">
    <link rel="shortcut icon" href="<?=ROOT?>/assets/images/logo.png" type="image/x-icon">
    <title>Beastylish</title>
</head>
<body>

<section class="form-container" id="signupform">
    <form action="<?=ROOT?>/Signup/register" enctype="multipart/form-data" method="POST">
        <h3>SignUp</h3>
        <h4>create your account</h4>
        <?php 
            if(isset($message)){
                foreach($message as $msg){
                    echo' 
                    <div class="message">
                        <span>'.$msg.'</span>
                        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                    </div>';
                }
            }
        ?>
        <input type="text" name="fname" class="box" placeholder="FIRST NAME" required>
        <input type="text" name="lname" class="box" placeholder="LAST NAME" required>
        <input type="text" name="username" class="box" placeholder="USER NAME" required>
        <input type="email" name="email" class="box" placeholder="EMAIL" required>
        <input type="text" name="phonenum" class="box" placeholder="PHONE NUMBER" pattern="(\+639|09)\d{9}"  title="Sample phone number: +639xxxxxxxxx or 09xxxxxxxxx" required>
        <select class="box" name="sex" id="sex" required>
            <option value="" disabled selected>SEX</option>
            <option value="FEMALE">Female</option>
            <option value="MALE">Male</option>
        </select>
        <input type="password" name="password" class="box" placeholder="PASSWORD" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
        title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
        <input type="password" name="cpassword" class="box" placeholder="CONFIRM PASSWORD" required>
        <input type="file" name="image" id="files" class="box" style="display: flex;" required accept="image/jpg, image/jpeg, image/png">
        <input type="submit" value="Signup" class="btn" name="submit">
        <p>already have account? <a href="<?=ROOT?>/Login">login now</a></p>
    </form>
</section>

</body>
</html>
