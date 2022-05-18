<?php
if(isset($_GET['id'])){
    $invoice_number = $_GET['id'];
    $total = 0;
    $total_discount = 0;
    $total_vat = 0;


    $select = mysqli_query($db, "SELECT * FROM invoice_table WHERE invoice_number = '$invoice_number'");
    $selected = mysqli_fetch_array($select);
    $num = mysqli_num_rows($select);

    if($num > 0){
        foreach($select as $selected){
            $invoice_number = $selected['invoice_number'];
            $customer_name = $selected['customer_name'];
            $status = $selected['status'];
            $po_number = $selected['po_number'];
            $updated_at = date('d D F, Y', strtotime($selected['updated_at']));
            $updated_by = $_SESSION['username'];
            
            $get = mysqli_query($db, "SELECT * FROM new_invoice_table WHERE invoice_number = '$invoice_number'");
            $gotten = mysqli_fetch_array($get);
            $gotten_num = mysqli_num_rows($get);
            
            foreach($get as $gotten){
               $total = $total + $gotten['total']; 
               $total_discount = $total_discount + $gotten['discount_figure']; 
               $total_vat = $total_vat + $gotten['vat_figure'];
            }
            
            $sum = ($total - $total_discount) + $total_vat;
?>


<div class="product-code">Invoice Number: <span><?php echo $invoice_number; ?></span></div>
<div class="product-desc">Customer: <span><?php echo $customer_name; ?></span></div>
<div class="product-desc">Invoice Gross: <span><?php echo 'NGN ' . number_format($total, 2); ?></span></div>
<div class="product-desc">Total Invoice Discount: <span><?php echo 'NGN ' . number_format($total_discount, 2); ?></span></div>
<div class="product-desc">Total Invoice Vat: <span><?php echo 'NGN ' . number_format($total_vat, 2); ?></span></div>
<div class="product-desc">Net Total: <span><?php echo 'NGN ' . number_format($sum, 2); ?></span></div>
<div class="product-price">Last Updated By: <span><?php echo $updated_by; ?></span></div>
<div class="product-price">Last Updated At: <span><?php echo $updated_at; ?></span></div>

<div class="form-container">
    <form method="post" action="">
        <div class="form-group">
            <select name="status" required>
                <option value=""> -- Selected Status -- </option>
                <option value="cleared">Cleared</option>
                <option value="uncleared">Uncleared</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" name="update_invoice_status">Update Invoice Status</button>
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
    echo "<div class='product-code'>Click on edit to change status!</div>";
}


?>