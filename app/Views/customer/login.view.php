<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?=ASSETS?>/css/components.css">
    <link rel="shortcut icon" href="<?=ROOT?>/assets/images/logo.png" type="image/x-icon">
    <title>Beastylish</title>
    <style>
        .option_field {
            margin-top: 1px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .form-container .forgot_pw {
            color: #6c4a21;
            font-size: 15px;
        }
        .form-container .forgot_pw:hover {
            text-decoration: underline;
        }

        .checkbox {
            margin-left: 0.8rem;
            display: flex;
            column-gap: 5px;
            white-space: nowrap;
        }

        .form-container .checkbox input {
            accent-color: #6c4a21;
            background-color: #f1f1f1;
            border: 2px solid #6c4a21;
        }

      

        .checkbox label {
            font-size: 15px;
            cursor: pointer;
            user-select: none;
            color: #6c4a21;
        }
        </style>
</head>
<body>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<section class="form-container" id="loginform">
    <form action="<?= ROOT ?>/login/authenticate" enctype="multipart/form-data" method="POST">
        <h3>Login</h3>
        <h4>Hello! Welcome back.</h4>
        <?php if (isset($message)): ?>
            <div class="message">
                <span><?= $message ?></span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
        <?php endif; ?>
        <input type="email" name="email" class="box" placeholder="EMAIL" required>
        <input type="password" name="password" class="box" placeholder="PASSWORD" required>
        
        <div class="option_field">
            <span class="checkbox">
                <input type="checkbox" id="check" style="display: none;" />
                <label for="check" style="display: none;">remember me</label>
            </span>
            <a class="forgot_pw" id="forgotpass">forgot password?</a>
        </div>

        <input type="submit" value="Login" class="btn" name="submit">
        <p>Don't have an account? <a href="<?= ROOT ?>signup">Sign Up now</a></p>
    </form>
</section>


<section class="form-container" id="resetpass" style="display: none;">
    <form action="<?= ROOT ?>/login/requestReset" enctype="multipart/form-data" method="POST">
        <h3>RESET PASSWORD</h3>
        <h4>We will send you an email to reset your password</h4>
        <?php if (isset($message)): ?>
            <div class="message">
                <span><?= $message ?></span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
        <?php endif; ?>
        <input type="email" name="email" class="box" placeholder="EMAIL" required>
        <input type="submit" value="Email Me" class="btn" name="submit">
    </form>
</section>

</body>
<script src="<?=ROOT?>js/login.js"></script>
</html>