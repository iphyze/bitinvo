<?php
    include_once('includes/connection.php');  
    include_once('includes/functions.php');
    session_start();
    
    if(!isset($_SESSION['username']) || $_SESSION['username'] == ''){
        header('location:login.php');
    }
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
                        <p class="ao-title">ADD ITEMS</p>
                        <p class="ao-subtitle">All created products</p>
                </div>
                
                <div class="print-container">
                    <a href="invoice.php">Back</a>
                </div>
                
                
                <div class="product-container">
                    <div class="pro-con-col">
                        
                        <div class="invoice-table pcc-invoice-table">
                        
                            <table id="invoice_tab">
                                <thead>
                                <tr>
                                    <td>#ID</td>
                                    <td>Item Code</td>
                                    <td>Item Description</td>
                                    <td>Item Price</td>
                                    <td>Action</td>
                                </tr>
                                </thead>
                                
                                <tbody>
                                <?php include_once('includes/add_view_items.php'); ?>
                                </tbody>
                                
                            </table>
                            
                        </div>
                        
                    </div>
                    
                    <div class="pro-con-col pcc">
                        
                        
                        <?php include_once('includes/display_added_item.php');?>
                        
                        
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