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

    if(!isset($_SESSION['admin_id'])){
        header('location: login.php');
        
    }

    if(isset($_POST['update_profile'])){
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);


        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_img/'.$image;

        $old_img = $_POST['old_img'];

        if(!empty($image)){
            if($image_size > 20000000){
                $message[] = 'Image is too large!';
            } else{
                $update_img = $conn->prepare("UPDATE USER SET IMAGE = ? WHERE USER_ID = ?");
                $update_img->execute([$image, $admin_id]);
                if($update_img){
                    move_uploaded_file($image_tmp_name, $image_folder);
                    unlink('uploaded_img/'.$old_img);
                    $message[] = 'Profile picture updated successfully!';
                }; 
            };
        };
         
        $old_pass = $_POST['old_pass'];
        $update_pass = md5($_POST['update_pass']);
        $update_pass = filter_var($update_pass, FILTER_SANITIZE_STRING);
        $new_pass = md5($_POST['new_pass']);
        $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    
        $confirm_pass = md5($_POST['confirm_pass']);
        $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);
    
        if(!empty($update_pass) OR !empty($new_pass) OR !empty($confirm_pass)){
            if($old_pass != $update_pass){
                $message[] = 'old password not matched!';
            }elseif($new_pass != $confirm_pass){
                $message[] = 'confirm password not matched!';
            }else{
                $update_pass_query = $conn->prepare("UPDATE USER SET PASSWORD = ? WHERE USER_ID = ?");
                $update_pass_query->execute([$confirm_pass, $admin_id]);
                $message[] = 'password updated sucessfully!';
            }
        }
    }

?>



<?php include("admin_header.php")?>
<section class="home">
    <section class="update_profile">
        <div class="text">UPDATE PROFILE</div>
        <div class="line"></div>

        
        <form action="" method="POST" enctype="multipart/form-data">
            <img src="uploaded_img/<?= $fetch_profile['IMAGE']?>" alt="dp">
           <div class="flex">
                <div class="inputBox">
                    <span>USERNAME </span>
                    <input type="text" name="name" value="<?= $fetch_profile['NAME']?>" placeholder="Update username" class="box">
                    <span>EMAIL </span>
                <input type="email" name="email" value="<?= $fetch_profile['EMAIL']?>" placeholder="Update email" class="box">
                    <span>NEW PROFILE PICTURE</span>
                    <input type="file" id="dp" name="dp" accept="image/jpg, image/jpeg, image/png" placeholder="Update profile picture" class="box">
                    <input type="hidden" name="old_img" value="<?= $fetch_profile['IMAGE']?>">
                </div>
                <div class="inputBox">
                    <input type="hidden" name="old_pass" value="<?= $fetch_profile['PASSWORD']?>">
                    <span>OLD PASSWORD </span>
                    <input type="password" name="update_pass"  placeholder="Enter previous password" class="box">
                    <span>NEW PASSWORD </span>
                    <input type="password" name="new_pass"  placeholder="Enter new password" class="box">
                    <span>CONFIRM NEW PASSWORD </span>
                    <input type="password" name="confirm_pass"  placeholder="Confirm new password" class="box">
                </div>
           </div>
            <div class="flex">
                <input type="submit" class="btn" value="UPDATE" name="update_profile" >
                <a href="admin_page.php" class="option-btn">BACK</a>
            </div>
        </form>
    </section>


</section>
