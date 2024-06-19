<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components.css">
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
        .btns {
            display: flex;
            justify-content: space-between; /* Align items with space between them */
            margin-top: 1rem; /* Adjust margin between buttons */
        }

        .btn-back {
            display: block;
            width: 48%; /* Adjust width of the buttons */
            border-radius: 4px;
            font-size: 2rem;
            padding: 1.5rem 3rem;
            cursor: pointer;
            color: #faf2e8;
            background-color: #6c4a2199;
            transition: background-color 0.5s, color 0.5s;
        }

        .btn-back:hover {
            background-color: #6c4a21;
        }

        .btn-reset {
            display: block;
            width: 48%; /* Adjust width of the buttons */
            border-radius: 4px;
            font-size: 2rem;
            padding: 1.5rem 3rem;
            cursor: pointer;
            color: #faf2e8;
            background-color: #6c4a21;
            transition: background-color 0.5s, color 0.5s;
        }

        .btn-reset:hover {
            background-color: #a47133;
        }


        </style>
</head>
<body>

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
        <p style="font-size: small; margin-bottom: 1rem;">By logging in, you agree to our <a href="<?= ROOT ?>/policy" style="font-size: small;  margin-bottom: 1rem;">Terms and Conditions</a>.</p>

        <p>Don't have an account? <a href="<?= ROOT ?>/signup">Sign Up now</a></p>
    </form>
</section>

<section class="form-container" id="resetpass" style="display: none;">
    <form action="<?= ROOT ?>/login/requestReset" enctype="multipart/form-data" method="POST">
        <h3>RESET PASSWORD</h3>
        <h4>We will send you an email to reset your password</h4>
        <input type="email" name="email" class="box" placeholder="EMAIL" required>
        <div class="btns">
            <button type="button" id="btn-back" class="btn-back">Cancel</button>
            <input type="submit" value="Email Me" class="btn-reset" name="submit">
        </div>
    </form>
</section>

<script src="<?=ROOT?>/assets/js/login.js"></script>

</body>
</html>
