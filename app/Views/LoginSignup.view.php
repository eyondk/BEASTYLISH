<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeAstylish</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?=ASSETS?>css/signUpInStyles.css">
   
</head>
<body>
    <div class="container" id="signUp" style="display: none;">
        <h1 class="form-title">SignUp</h1>
        <h3 class="form-subtitle">create your account</h3>
        <form method="post" action="">
            <div class="input-group">
                <input type="text" name="fname" id="fname" placeholder="First Name" required>
                <label for="fname">First Name</label>
            </div>
            <div class="input-group">
                <input type="text" name="lname" id="lname" placeholder="Last Name" required>
                <label for="lname">Last Name</label>
            </div>
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <input type="text" name="username" id="username" placeholder="Username" required>
                <label for="username">Username</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <div class="input-group">
                <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required>
                <label for="confirmpassword">Confirm Password</label>
            </div>

            <input type="submit" class="btnclck" value="Sign Up" name="signup">
        </form>
        <div class="links">
            <p>already have account? <a id="loginlink" href="#login">Login</a></p>
        </div>
    </div>

    <div class="container" id="logIn">
        <h1 class="form-title">Login</h1>
        <h3 class="form-subtitle">hello! welcome back</h3>
        <form method="post" action="">
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <div class="rememberme">
                <input type="checkbox" id="rememberme" name="rememberme" value="rememberme">
                <label for="rememberme"> <i class="fas fa-check"></i>remember me</label>

                <a class="forgot-password" href="#">forgot password</a>
            </div>

            

            <input type="submit" class="btnclck" value="Log In" name="login">
        </form>
        <div class="links">
            <p>don't have account yet? <a id="signuplink" href="#signup">Signup</a></p>
        </div>
    </div>

    <script src="<?=ASSETS?>js/signUpInForm.js"></script>
</body>
</html>