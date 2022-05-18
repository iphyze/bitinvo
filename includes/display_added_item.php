<?php
if(isset($_GET['item_id'])){
    $item_id = $_GET['item_id'];


    $select = mysqli_query($db, "SELECT * FROM products_table WHERE id = '$item_id'");
    $selected = mysqli_fetch_array($select);
    $num = mysqli_num_rows($select);

    if($num > 0){
        foreach($select as $selected){
            $product_code = $selected['product_code'];
            $product_name = $selected['product_name'];
            $product_price = number_format($selected['product_price'], 2);
            $vat_status = $selected['vat_status'];
            $disc_status = $selected['disc_status'];
            $created_at = date('Y-m-d h:i:s', time()-3600);
            $created_by = $_SESSION['username'];
            $updated_at = $selected['updated_at'];
            $updated_by = $_SESSION['username'];
?>


<div class="product-code">Product Code: <span><?php echo $product_code; ?></span></div>
<div class="product-desc">Product Description: <span><?php echo $product_name; ?></span></div>
<?php
   if($vat_status == 'No'){
?>
<div class="product-price">Vattable: <span>No</span></div>
<div class="product-price">Product Price: <span>Varries</span></div>
<?php
   }else{
?>
<div class="product-price">Vattable: <span>Yes</span></div>
<div class="product-price">Vat (%): <span>7.5</span></div>
<div class="product-price">Product Price: <span><?php echo $product_price; ?></span></div>
<?php
   }
?>

<?php
   if($disc_status == 'No'){
?>
<div class="product-price">Discount: <span>None</span></div>
<?php
   }
?>

<div class="form-container">
    <form method="post" action="generate.php?action=add_to_invoice&id=<?php echo $selected['id']; ?>">
        <div class="form-group">
            <?php
                if($vat_status == 'No'){
            ?>
            <input type="hidden" name="item_quantity" min="1" value="1" required>
            <?php
                if($disc_status == 'Yes'){
            ?>
            <input type="number" name="item_discount" min="0" placeholder="<?php echo 'Discount: ' . number_format(0) . '%'; ?>" step="any" olderired>
            <?php
                }else{
            ?>
            <input type="hidden" name="item_discount" min="0" value="0">
            <?php
                }
            ?>
            
            <input type="hidden" name="item_vat" min="0" value="0">
            <input type="number" name="item_price" value="<?php echo $selected['product_price']; ?>" step="any" required>
            <?php
               }else{
            ?>   
            <input type="number" name="item_quantity" min="1" placeholder="<?php echo 'Quantity: ' . number_format(0); ?>" step="any" required>
            <?php
                if($disc_status == 'Yes'){
            ?>
            <input type="number" name="item_discount" min="0" placeholder="<?php echo 'Discount: ' . number_format(0) . '%'; ?>" step="any" required>
            <?php
                }else{
            ?>
            <input type="hidden" name="item_discount" min="0" value="0">
            <?php
                }
            ?>
            <input type="hidden" name="item_vat" min="0" value="7.5" step="any" required>
            <input type="hidden" name="item_price" value="<?php echo $selected['product_price']; ?>" step="any">
            <?php
                }
            ?>
            <input type="hidden" name="item_code" value="<?php echo $product_code; ?>" step="any">
            <input type="hidden" name="item_description" value="<?php echo $product_name; ?>" step="any" >
        </div>
        <div class="form-group">
            <button type="submit" name="add_to_invoice">Add to invoice</button>
        </div>
    </form>
</div>


<?php
            }
        }else{
        
?>

<div class="product-code">No results found!</div>

<?php
    }
    }else{
    echo "<div class='product-code'>Click on add to add items!</div>";
}


?>