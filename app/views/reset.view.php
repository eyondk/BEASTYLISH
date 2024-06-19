<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .reset-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .reset-form h2 {
            text-align: center;
        }
        .reset-form input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .reset-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #6c4a21;
            color: #faf2e8;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .reset-form input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error-message {
            color: #ff0000;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="reset-form">
        <h2>Reset Password</h2>
        <?php if (!empty($message)): ?>
            <p class="error-message"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <form action="<?= htmlspecialchars(ROOT . '/login/resetPassword', ENT_QUOTES, 'UTF-8') ?>" method="POST">
            <input type="hidden" name="token" id="token">            
            <input type="password" name="password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <input type="submit" value="Reset Password">
        </form>
    </div>

    <script>
        // Extract the token from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get('token');
        
        // Set the token value in the hidden input field
        if (token) {
            document.getElementById('token').value = token;
        }
    </script>
</body>
</html>
