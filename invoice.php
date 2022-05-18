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
                        <p class="ao-title">INVOICE</p>
                        <p class="ao-subtitle">Invoice Analytics</p>
                </div>
                
                <div class="invoice-menu">
                    <a href="add_items.php" class="im-link">
                        <i class="fas fa-plus"></i> Generate New Invoice
                    </a>
                    <a href="invoice_status.php" class="im-link iml-2">
                        <i class="fas fa-edit"></i> Update Invoice Status
                    </a>
                </div>
                
                <?php
                    include_once('includes/messages.php')
                ?>
                
                <div class="invoice-table">
                    <table id="invoice_tab">
                        
                        <thead>
                        <tr>
                            <td>#ID</td>
                            <td>Invoice Number</td>
                            <td>Billed To</td>
                            <td>Created At</td>
                            <td>Created By</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        
                        <tbody>
                        <?php include_once('includes/view_invoices.php'); ?>
                        </tbody>
                        
                    </table>
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