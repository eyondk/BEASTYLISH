<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/404.css">
    <link rel="shortcut icon" href="img/Beastylish-favicon.png" type="image/x-icon">  
    <title>File not found</title>
</head>
<body>

    <div class="er">
        <img src="img/11.png" alt="404 ERROR PAGE NOT FOUND" class="error">
        <button type="button" class="btn" id="goback">go back home</button>
    </div>
    
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var gobckbtn = document.getElementById('goback');
    
        gobckbtn.onclick = function(){
            window.location.href = "home.php";
        };
    });
</script>
</html>
