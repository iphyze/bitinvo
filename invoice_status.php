<?php
    include_once('includes/connection.php');  
    include_once('includes/functions.php');
    session_start();
    
    if(!isset($_SESSION['username']) || $_SESSION['username'] == ''){
        header('location:login.php');
    }

    update_invoice_status();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
        
        <!-- Css assets Menu -->
        <?php 
            include_once('includes/head.php');
        ?>
        
        <title>Invoicing</title>
</head>

<body>
    
    <div class="whole-container">
        
        <div class="container-flex-box">
            
            <!-- Dashboard Menu -->
            <?php 
                include_once('includes/dashboard_menu.php');
            ?>
            
            <div class="col overview">
                <!-- Dashboard Header -->
                <?php 
                    include_once('includes/dashboard_header.php');
                ?>
                
                <div class="area-one">
                        <p class="ao-title">UPDATE INVOICE STATUS</p>
                        <p class="ao-subtitle">Ensure that you have received payments from clients before clearing invoice.</p>
                </div>
                
                <div class="print-container">
                    <a href="invoice.php">Back</a>
                </div>
                
                <?php 
                    if(!empty($_SESSION['updateMsg'])){
                        echo $_SESSION['updateMsg'];
                        unset($_SESSION['updateMsg']);
                    }
                ?>
                
                <div class="product-container">
                    <div class="pro-con-col">
                        
                        <div class="invoice-table pcc-invoice-table">
                        
                            <table id="invoice_tab">
                                <thead>
                                <tr>
                                    <td>#ID</td>
                                    <td>Invoice Number</td>
                                    <td>Company</td>
                                    <td>Present Status</td>
                                    <td>Action</td>
                                </tr>
                                </thead>
                                
                                <tbody>
                                <?php include_once('includes/update_invoice_status.php'); ?>
                                </tbody>
                                
                            </table>
                            
                        </div>
                        
                    </div>
                    
                    <div class="pro-con-col pcc">
                        
                        <?php include_once('includes/display_current_invoice.php');?>
                        
                        
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
    </div>
    
</body>

    
    
<script type="text/javascript" src="assets/js/style.js"></script>
<script type="text/javascript" src="assets/js/libraries/wow.min.js"></script>
<script>
new WOW().init();
</script>
</html>