<?php
  include_once('includes/connection.php');
    include_once('includes/functions.php');
    session_start();

    if(!isset($_SESSION['username']) || $_SESSION['username'] == ''){
        header('location:login.php');
    }

    if(isset($_GET['product_id']) && $_GET['product_id'] != ''){
        $product_id = $_GET['product_id'];   
    }else{
        header('Location:product.php');
    }
    
    edit_product();
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
                        <p class="ao-subtitle">EDIT PRODUCT</p>
                </div>
                
                <div class="print-container">
                    <a href="product.php">Back</a>
                </div>
                
                
                <?php
                    $get_product_id = mysqli_query($db, "SELECT * FROM products_table WHERE id = '$product_id'");
                    $id_array = mysqli_fetch_array($get_product_id);
                
                    $product_name = $id_array['product_name'];
                    $product_code = $id_array['product_code'];
                    $product_price = $id_array['product_price'];
                    $vat_status = $id_array['vat_status'];
                    $disc_status = $id_array['disc_status'];
                    $updated_by = 'admin';
                ?>
                
                <div class="product-wrapper">
                    <p class="ao-title"><?php echo $product_name; ?></p>
                    <p class="ao-subtitle">Fill the below form to edit product</p>                    
                    
                    
                    <?php include_once('includes/messages.php'); ?>
                    
                    <div class="edit-form-container">
                            <div class="edit-product-form-wrapper">
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Product Code</label>
                                        <input type="text" name="product_code" value="<?php echo $product_code; ?>" required>
                                        <button name="update_product_code" class='fas fa-edit'></button>
                                    </form>
                                </div>
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Product Name</label>
                                        <input type="text" name="product_name" value="<?php echo $product_name; ?>" required>
                                        <button name="update_product_name" class='fas fa-edit'></button>
                                    </form>
                                </div>
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Product Price</label>
                                        <input type="number" name="product_price" value="<?php echo $product_price; ?>" required step="any">
                                        <button name="update_product_price" class='fas fa-edit'></button>
                                    </form>
                                </div>
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Vat Status (<?php echo $vat_status; ?>): <span class='label-span'>Vattable Product (Yes) | Non Vattable Product (No)</span></label>
                                        <select name="vat_status" required>
                                            <option value="">--Change Vat Status --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                        <button name="update_product_vat" class='fas fa-edit'></button>
                                    </form>
                                </div>
                                
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Discount Status (<?php echo $disc_status; ?>): <span class='label-span'>Discounted (Yes) | Not Discounted (No)</span></label>
                                        <select name="disc_status" required>
                                            <option value="">--Change Discount Status --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    <button name="update_product_disc" class='fas fa-edit'></button>
                                    </form>
                                </div>
                                
                            </div>
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