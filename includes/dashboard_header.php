<?php
include_once('includes/connection.php');
include_once('includes/functions.php');
//session_start();

?>
<div class="overview-header">
                    
<div class="ovh-col ovh-col-1">

    <div class="not-box">
        <i class="fas fa-align-right menu-display-icon"></i>
        <i class="fas fa-user username-icon"></i>
            <span class="username-name"><?php echo $_SESSION['username']; ?> - <span class="username-title">
            <?php
                $select = mysqli_query($db, "SELECT * FROM user WHERE username = '{$_SESSION['username']}'");
                $selected = mysqli_fetch_assoc($select);
                
                echo $selected['designation'];
            ?>
            </span></span>
    </div>

</div>
<div class="ovh-col ovh-col-2">

    <div class="not-box">
        <a href="generate.php" class="fas fa-weight-hanging"></a>
        <a href="generate.php" class="notification"><?php item_num_display(); ?></a>
    </div>

    <div class="not-box">
        <a class="fas fa-cog cog-icon" href="#"></a>
    </div>

</div>
    
</div>