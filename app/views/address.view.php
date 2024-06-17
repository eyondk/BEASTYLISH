<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Form</title>
    <link rel="stylesheet" href="<?=ROOT?>/assets/css/components.css">
</head>
<body>
<section class="form-container" id="address">
    <form action="<?= ROOT ?>/address" method="POST">
        <h3 style="font-weight: 500; margin-bottom: 2rem;">SET ADDRESS</h3>
        <?php
        if (isset($message)) {
            echo '
                    <div class="message">
                        <span>' . $message . '</span>
                        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                    </div>';
        }
        ?>
        <input type="text" name="street" class="box" placeholder="STREET" required>
        <select class="box" name="city" id="city" required>
            <option value="" disabled selected>CITY</option>
            <option value="BOGO CITY">Bogo City</option>
            <option value="CAR CITY">Carcar City</option>
            <option value="CEBU CITY">Cebu City</option>
            <option value="DANAO CITY">Danao City</option>
            <option value="LAPU-LAPU CITY">Lapu-lapu City</option>
            <option value="MANDAUE CITY">Mandaue City</option>
            <option value="NAGA CITY">Naga City</option>
            <option value="TALISAY CITY">Talisay City</option>
            <option value="TOLEDO CITY">Toledo City</option>
        </select>
        <select class="box" name="province" id="province" required>
            <option value="" disabled selected>PROVINCE</option>
            <option value="CEBU">Cebu</option>
        </select>

        <input type="submit" value="Save" class="btn" name="submitAddress">
    </form>
</section>

</body>
</html>
