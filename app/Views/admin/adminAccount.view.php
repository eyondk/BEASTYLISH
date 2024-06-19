<?php include("admin_header.php")?>
<section class="home">
    <section class="update_profile" id="profile">
        <div class="text">ADMIN PROFILE</div>
        <div class="line"></div>

        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="error-messages ">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form action="" >
            <?php if (isset($_SESSION['admin_profile']) && !empty($_SESSION['admin_profile'])): ?>
                <img src="<?= ROOT . htmlspecialchars($_SESSION['admin_profile']) ?>" height="50" alt="Profile Picture">
            <?php endif; ?>
           <div class="flex">
                <div class="inputBox">
                    <span>FIRST NAME</span>
                    <input type="text" name="fname" class="box" value="<?= isset($_SESSION['admin_fname']) ? htmlspecialchars($_SESSION['admin_fname']) : '' ?>" disabled>
                    <span>LAST NAME</span>
                    <input type="text" name="fname" class="box" value=" <?= isset($_SESSION['admin_lname']) ? htmlspecialchars($_SESSION['admin_lname']) : '' ?>" disabled>
                    <span>USER NAME</span>
                    <input type="text" id="username" name="username" class="box" value="<?= isset($_SESSION['admin_username']) ? htmlspecialchars($_SESSION['admin_username']) : '' ?>" disabled>
                </div>
                <div class="inputBox">
                        <span>EMAIL</span>
                        <input type="email" name="email" class="box" value="<?= isset($_SESSION['admin_email']) ? htmlspecialchars($_SESSION['admin_email']) : '' ?>" disabled>
                        <span>PHONE NUMBER</span>
                        <input type="text" name="phone" class="box" value="<?= isset($_SESSION['admin_phonenum']) ? htmlspecialchars($_SESSION['admin_phonenum']) : '' ?>" disabled>
                        <span>SEX</span>
                        <input type="text" name="sex" class="box" value="<?= isset($_SESSION['admin_sex']) ? htmlspecialchars($_SESSION['admin_sex']) : '' ?>" disabled>
                </div>
           </div>
            <div class="flex">
                <a id="updateprofilebtn" class="btn">EDIT INFO</a>
            </div>
        </form>
    </section>

    <section class="update_profile" id="updateprofileSec" style="display:none">
            <div class="text">UPDATE PROFILE</div>
            <div class="line"></div>

            <form  action="<?=ROOT?>/AdminAccount/updateAdmin" method="POST" enctype="multipart/form-data" style="border:none;">
           
                <div class="inputBox">
                        <span>UPDATE PROFILE PICTURE</span>
                        <input type="file" id="updateprofile" name="updateprofile" accept="image/jpg, image/jpeg, image/png" placeholder="Update profile picture" class="box">
                        <span>UPDATE FIRST NAME</span>
                        <input type="text" name="updatefname" class="box"  placeholder="Update first name">
                        <span>UPDATE LAST NAME</span>
                        <input type="text" name="updatelname" class="box"  placeholder="Update last name">
                        <span>UPDATE USERNAME</span>
                        <input type="text" name="updateusername" class="box" placeholder="Update username" >
                </div>
                <div class="inputBox">
                        <span>UPDATE EMAIL </span>
                        <input type="email" name="email" placeholder="Update email" class="box">
                        <span>UPDATE PHONE NUMBER</span>
                        <input type="tel" name="updatephonenum" class="box" placeholder="Update phone number" 
                        pattern="(\+639|09)\d{9}"  title="Sample phone number: +639xxxxxxxxx or 09xxxxxxxxx" >
                        <span>UPDATE SEX</span>
                        <select class="box" name="updatesex" id="updatesex" >
                            <option value="" disabled selected>Sex</option>
                            <option value="FEMALE">Female</option>
                            <option value="MALE">Male</option>
                        </select>               
                </div>
                <div class="inputBox">
                            <span>OLD PASSWORD </span>
                            <input type="password" name="oldpass" class="box" placeholder="Enter old password" >
                            <span>NEW PASSWORD </span>
                            <input type="password" name="updatepass" class="box" placeholder="Enter old password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" >
                            <span>CONFIRM NEW PASSWORD </span>
                            <input type="password" name="confirmpass" class="box" placeholder="Confirm new password" >
                </div>
                <div class="flex" style="margin-bottom:2rem;">
                    <input type="submit" class="btn" value="UPDATE" name="update_profile" >
                    <a class="option-btn" id="back-btn">BACK</a>
                </div>
        </form>
        
    </section>


</section>
<script src="<?=ASSETS?>js/adminaccount.js"></script>
<script src="<?= ASSETS ?>js/admin.js"></script>