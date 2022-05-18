<?php
  include_once('includes/connection.php');
    include_once('includes/functions.php');
    session_start();

    if(!isset($_SESSION['username']) || $_SESSION['username'] == ''){
        header('location:login.php');
    }
    
    edit_invoice();
    
    if(isset($_GET['id']) && $_GET['id'] != ''){
        $id = $_GET['id'];   
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
                        <p class="ao-title">INVOICE</p>
                        <p class="ao-subtitle">EDIT INVOICE</p>
                </div>
                
                <div class="print-container">
                    <a href="show_invoice.php" onclick="">Back</a>
                </div>
                
                
                <?php
                    $get_product_id = mysqli_query($db, "SELECT * FROM new_invoice_table WHERE id = '$id'");
                    $id_array = mysqli_fetch_array($get_product_id);
                
                    $id = $id_array['id'];
                    $invoice_number = $id_array['invoice_number'];
                    $po_number = $id_array['po_number'];
                    $project = $id_array['project'];
                    $product_code = $id_array['product_code'];
                    $product_name = $id_array['product_description'];
                    $product_price = $id_array['product_price'];
                    $product_quantity = $id_array['product_quantity'];
                    $total = $id_array['total'];
                    $vat = $id_array['vat'];
                    $vat_figure = $id_array['vat_figure'];
                    $discount = $id_array['discount'];
                    $discount_figure = $id_array['discount_figure'];
                    $customer = $id_array['customer'];
                    $updated_by = 'admin';
                ?>
                
                <div class="product-wrapper">
                    <p class="ao-title">INVOICE NO #: <?php echo $invoice_number . ' - ' . $id; ?></p>
                    <p class="ao-subtitle">Fill the below form to edit product</p>                    
                    
                    
                    <?php include_once('includes/messages.php'); ?>
                    
                    <div class="edit-form-container">
                            <div class="edit-product-form-wrapper">
                                
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Customer <?php echo "({$customer})"; ?></label>
                                        <select name="customer" required>
                                            <option value="">-- Select Customer --</option>
                                            
                                            <?php
                                            
                                                $customer = mysqli_query($db, "SELECT * FROM customer_table");
                                                $customers = mysqli_fetch_assoc($customer);
                                                
                                                foreach($customer as $customers){
                                                    $customer_customer = $customers['customer_name'];
                                                    echo "<option value='{$customer_customer}'>{$customer_customer}</option>";
                                                }
                                            ?>
                                            
                                        </select>
                                        <button name="update_product_customer" class='fas fa-edit'></button>
                                    </form>
                                </div>
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Delivery Address</label>
                                        <input type="text" name='project' placeholder="<?php echo $project; ?>" required>
                                        <button class='fas fa-edit' name="update_project"></button>
                                    </form>
                                </div>
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Purchase Order Number</label>
                                        <input type="text" name='po_number' placeholder="<?php echo $po_number; ?>" required>
                                        <button class='fas fa-edit' name="update_po_number"></button>
                                    </form>
                                </div>
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Product Code</label>
                                        <input type="text" value="<?php echo $product_code; ?>" required disabled>
                                        <button class='fas fa-edit' disabled></button>
                                    </form>
                                </div>
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Product Name <?php echo "({$product_name})"; ?></label>
                                        <select name="product_name" required>
                                            <option value="">-- Select Product --</option>
                                            
                                            <?php
                                            
                                                $product = mysqli_query($db, "SELECT * FROM products_table");
                                                $products = mysqli_fetch_assoc($product);
                                                
                                                foreach($product as $products){
                                                    $product_product = $products['product_name'];
                                                    echo "<option value='{$product_product}'>{$product_product}</option>";
                                                }
                                            ?>
                                            
                                        </select>
                                        <button name="update_product_name" class='fas fa-edit'></button>
                                    </form>
                                </div>
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Product Price</label>
                                        <input type="number" placeholder="<?php echo number_format($product_price, 2); ?>" required disabled>
                                        <button class='fas fa-edit' disabled></button>
                                    </form>
                                </div>
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Product Quantity</label>
                                        <input type="number" name="new_product_quantity" value="<?php echo $product_quantity; ?>" required>
                                        <button name="update_invoice_quantity" class='fas fa-edit'></button>
                                    </form>
                                </div>
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Total</label>
                                        <input type="number" name="total" placeholder="<?php echo number_format($total, 2);?>" required disabled>
                                        <button name="update_product_price" class='fas fa-edit' disabled></button>
                                    </form>
                                </div>
                                
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Product Discount (%)</label>
                                        <input type="number" name="discount" value="<?php echo $discount; ?>" required>
                                        <button name="update_invoice_discount" class='fas fa-edit'></button>
                                    </form>
                                </div>
                                
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Discount Value</label>
                                        <input type="number" name="discount_figure" placeholder="<?php echo number_format($discount_figure, 2); ?>" required disabled>
                                        <button name="update_product_price" class='fas fa-edit' disabled></button>
                                    </form>
                                </div>
                                
                                
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Vat Status: <span class='label-span'>Vattable Product (Yes) | Non Vattable Product (No)</span></label>
                                        <select name="vat" required step="any">
                                            <option value="">-- Change Vat (%) --</option>
                                            <option value="7.5">7.5%</option>
                                            <option value="0">0%</option>
                                        </select>
                                        <button name="update_invoice_vat" class='fas fa-edit'></button>
                                    </form>
                                </div>
                                
                                
                                <div class="form-group">
                                    <form method="post" action="">
                                        <label>Vat Value</label>
                                        <input type="number" name="vat_figure" placeholder="<?php echo number_format($vat_figure, 2); ?>" required disabled>
                                        <button name="update_product_price" class='fas fa-edit' disabled></button>
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