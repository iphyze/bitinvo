<?php
    include_once('includes/connection.php');
    include_once('includes/functions.php');
    session_start();

    if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, md5($_POST['password']));

    $select = mysqli_query($db, "SELECT * FROM user WHERE username = '$username' && password = '$password'");
    $num = mysqli_num_rows($select);

    if($num > 0){
        $_SESSION['username'] = $username;
        header('location:index.php');
    }else{
        $errMsg = '<div class="err-message wow bounceIn">Invalid credential, please correct & try again!</div>';
    }

}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Css assets Menu -->
        <?php 
            include_once('includes/head.php');
        ?>
        <title>Invoicing</title>
    </head>

<body>
    
    <div class="whole-container">
        
        <div class="login-container">
            <div class="login-container-wrapper">
                <div class="login-title wow fadeInDown">Bit<span class="logo-span">Invo</span></div>
                
                <div class="login-form-container">
                    
                    <?php if(!empty($errMsg)){ echo $errMsg; }?>
                    
                    <form action="" method="post">
                        <div class="form-group wow fadeInUp">
                            <input type="text" name="username" placeholder="Username">
                            <i class="fas fa-user icons"></i>
                        </div>
                        <div class="form-group wow fadeInUp">
                            <input type="password" name="password" placeholder="Password" id='password-form'>
                            <div class="fas fa-eye icons" id="password-icon-open"></div>
                        <div class="fas fa-eye-slash icons" id="password-icon-close"></div>
                        </div>
                        <div class="form-group form-btn wow fadeInDown">
                            <button name="login" type="submit">Log In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
    
</body>

    
    
<script type="text/javascript" src="assets/js/style.js"></script>
<script type="text/javascript" src="assets/js/libraries/wow.min.js"></script>
<script>
new WOW().init();
    
$(document).ready(function(){
   $('#password-icon-close').click(function(){
     $('#password-icon-close').hide();
     $('#password-icon-open').show();

       var password_show = document.getElementById("password-form");
       if(password_show.type === "password"){
           password_show.type = "text";
       }

   });


    $('#password-icon-open').click(function(){
     $('#password-icon-open').hide();
     $('#password-icon-close').show();

        var password_show = document.getElementById("password-form");
        if(password_show.type === "text"){
           password_show.type = "password";
        }

   });
});
</script>
</html>