<?php 
    if(isset($message)){
        foreach($message as $message){
        echo' 
        <div class="message">
                <span> '.$message.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>';
        }
    }
?>

<?php require("admin_page.php")?>
<section class="home">
    <section class="update_profile">
        <div class="text">UPDATE PROFILE</div>
        <div class="line"></div>

        
        <form action="" method="POST" enctype="multipart/form-data">
            <img src="uploaded_img/<?= $fetch_profile['IMAGE']?>" alt="dp">
           <div class="flex-btn">
                <div class="inputBox">
                    <span>USERNAME </span>
                    <input type="text" name="name" value="<?= $fetch_profile['NAME']?>" placeholder="Update username" required class="box">
                    <span>EMAIL </span>
                    <input type="email" name="email" value="<?= $fetch_profile['EMAIL']?>" placeholder="Update email" required class="box">
                    <span>NEW PROFILE PICTURE</span>
                    <input type="file" id="dp" name="dp" accept="image/jpg, image/jpeg, image/png" placeholder="Update profile picture" required class="box">
                    <input type="hidden" name="old_img" value="<?= $fetch_profile['IMAGE']?>">
                </div>
                <div class="inputBox">
                    <input type="hidden" name="old_pass" value="<?= $fetch_profile['PASSWORD']?>">
                    <span>OLD PASSWORD </span>
                    <input type="password" name="old_pass"  placeholder="Enter previous password" required class="box">
                    <span>NEW PASSWORD </span>
                    <input type="password" name="new_pass"  placeholder="Enter new password" required class="box">
                    <span>CONFIRM NEW PASSWORD </span>
                    <input type="password" name="confirm_pass"  placeholder="Confirm new password" required class="box">
                </div>
           </div>
            <div class="flex-btn">
                <input type="submit" class="btn" value="UPDATE" name="update_profile" >
                <a href="admin_page.php" class="option-btn">BACK</a>
            </div>
        </form>
    </section>


</section>