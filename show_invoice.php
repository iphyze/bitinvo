<?php
    include_once('includes/connection.php');
    include_once('includes/functions.php');
    session_start();

    if(!isset($_SESSION['username']) || $_SESSION['username'] == ''){
        header('location:login.php');
    }

    if(isset($_GET['invoice_id']) && $_GET['invoice_id'] != ''){
        $invoice_id = $_GET['invoice_id'];   
    }else{
        header('Location:invoice.php');
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
                        <p class="ao-title">INVOICE #: <?php echo $invoice_id; ?></p>
                        <p class="ao-subtitle">Edit invoice number <?php echo $invoice_id; ?></p>
                </div>
                
                <div class="invoice-menu">
                    <a href="invoice.php" class="im-link iml-2">
                        &larr; Back
                    </a>
                </div>
                
                
                <div class="invoice-table">
                    <table id="invoice_tab">
                        
                        <thead>
                        <tr>
                            <td>#ID</td>
                            <td>Amount (NGN)</td>
                            <td>Quantity</td>
                            <td>Total (NGN)</td>
                            <td>Discount (NGN)</td>
                            <td>Vat (NGN)</td>
                            <td>Updated By</td>
                            <td>Updated At</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                        
                        <tbody>
                        <?php include_once('includes/display_invoice.php'); ?>
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