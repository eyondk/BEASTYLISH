<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/components.css">
    <link rel="shortcut icon" href="<?= ROOT ?>/assets/images/logo.png" type="image/x-icon">
    <title>Beastylish</title>
</head>
<body>

<section class="form-container" id="verifyform">
    <form action="<?= ROOT ?>/Signup/verifyOTP" method="POST">
        <h3>Enter the OTP code</h3>
        <?php 
            if (isset($message) && is_array($message)) {
                foreach ($message as $msg) {
                    echo '<div class="message">
                            <span>' . htmlspecialchars($msg) . '</span>
                            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                          </div>';
                }
            }
        ?>
        <input type="text" id="otp" name="otp" class="box" placeholder="Verification Code" required>
        <button type="submit" class="btn">Verify</button>
    </form>
</section>

</body>
</html>
