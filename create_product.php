<?php
  include_once('includes/connection.php');
    include_once('includes/functions.php');
    session_start();

    if(!isset($_SESSION['username']) || $_SESSION['username'] == ''){
        header('location:login.php');
    }
    
    add_new_product();
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        
        <!-- Css assets Menu -->
        <?php 
            include_once('includes/head.php');
        ?>
        
        <title>Bitinvo - Product</title>
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
                        <p class="ao-title">PRODUCTS</p>
                        <p class="ao-subtitle">CREATE NEW PRODUCT</p>
                </div>
                
                <div class="print-container">
                    <a href="product.php">Back</a>
                </div>
                
                
                <div class="product-wrapper">
                    
                    <p class="ao-title">Add Products</p>
                    <p class="ao-subtitle">Fill the below form to create a new product</p>
                    
                    <?php include_once('includes/messages.php'); ?>
                    
                    <div class="form-container">
                        <form method="post" action="">
                            <div class="product-form-wrapper">
                                
                                <div class="form-group">
                                    <label>Product Code</label>
                                    <input type="text" name="product_code" placeholder="Product Code" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input type="text" name="product_name" placeholder="Product Name" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Product Price</label>
                                    <input type="number" name="product_price" placeholder="Product Price" required step="any">
                                </div>
                                
                                <div class="form-group">
                                    <label>Vat Status: <span class='label-span'>Vattable Product (Yes) | Non Vattable Product (No)</span></label>
                                    <select name="vat_status" required>
                                        <option value="">--Select Vat Status --</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label>Discount Status: <span class='label-span'>Discounted (Yes) | Not Discounted (No)</span></label>
                                    <select name="disc_status" required>
                                        <option value="">--Select Discount Status --</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                
                                <div class="form-group-btn">
                                    <button type="submit" name="create_product">Create</button>
                                </div>
                                
                            </div>
                        </form>
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