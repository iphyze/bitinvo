<?php

function item_num_display(){
    global $db;
    if(!empty($_SESSION['item'])){
        $total = 0;
        $total_quantity = 0;
        foreach($_SESSION['item'] as $keys => $value){
        $total = $total + ($value['quantity'] * $value['price']);
        $total_quantity = $total_quantity + ($value['quantity']);
        }
    }
    if(!empty($total_quantity)){
        echo $total_quantity;
    }else{
        echo 0;
    }
}


function get_total_invoices(){
    global $db;
    $select = mysqli_query($db, "SELECT invoice_number FROM invoice_table");
    $num = mysqli_num_rows($select);
    echo number_format($num, 0);
}

function get_total_cleared_invoices(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM invoice_table WHERE status = 'cleared'");
    $num = mysqli_num_rows($select);
    echo number_format($num, 0);
}

function get_total_uncleared_invoices(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM invoice_table WHERE status = 'uncleared'");
    $num = mysqli_num_rows($select);
    echo number_format($num, 0);
}



function get_amount_invoices_sold(){
    global $db;
    $total = 0;
    $total_discount = 0;
    $total_vat = 0;
    $select = mysqli_query($db, "SELECT * FROM new_invoice_table");
    $selected = mysqli_fetch_assoc($select);
    foreach($select as $selected){
        $total = ($total + $selected['total']);
        $total_discount = $total_discount + $selected['discount_figure'];
        $total_vat = $total_vat + $selected['vat_figure'];
    }
    
    $sum = ($total - $total_discount) + $total_vat;
    echo number_format($sum, 2);
}



function get_daily_sales_total(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM new_invoice_table WHERE DATE(created_at) = DATE(NOW())");
    $selected = mysqli_fetch_assoc($select);
    $total = 0;
    $total_discount = 0;
    $total_vat = 0;
    foreach($select as $selected){
        $total += $selected['total'];
        $total_discount = $total_discount + $selected['discount_figure'];
        $total_vat = $total_vat + $selected['vat_figure'];
    }
    
    $sum = ($total - $total_discount) + $total_vat;
    echo number_format($sum, 2);
}


function get_weekly_sales_total(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM new_invoice_table WHERE created_at >= DATE(NOW()) - INTERVAL 7 DAY");
    $selected = mysqli_fetch_assoc($select);
    $total = 0;
    $total_discount = 0;
    $total_vat = 0;
    
    foreach($select as $selected){
        $total += $selected['total'];
        $total_discount = $total_discount + $selected['discount_figure'];
        $total_vat = $total_vat + $selected['vat_figure'];
    }
    $sum = ($total - $total_discount) + $total_vat;
    echo number_format($sum, 2);
}


function get_monthly_sales_total(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM new_invoice_table WHERE MONTH(created_at) = MONTH(NOW())");
    $selected = mysqli_fetch_assoc($select);
    $total = 0;
    $total_discount = 0;
    $total_vat = 0;
    
    foreach($select as $selected){
        $total += $selected['total'];
        $total_discount = $total_discount + $selected['discount_figure'];
        $total_vat = $total_vat + $selected['vat_figure'];
    }
    $sum = ($total - $total_discount) + $total_vat;
    echo number_format($sum, 2);
}


function get_yearly_sales_total(){
    global $db;
    $select = mysqli_query($db, "SELECT * FROM new_invoice_table WHERE YEAR(created_at) = YEAR(NOW())");
    $selected = mysqli_fetch_assoc($select);
    $total = 0;
    $total_discount = 0;
    $total_vat = 0;
    
    foreach($select as $selected){
        $total += $selected['total'];
        $total_discount = $total_discount + $selected['discount_figure'];
        $total_vat = $total_vat + $selected['vat_figure'];
    }
    $sum = ($total - $total_discount) + $total_vat;
    echo number_format($sum, 2);
}



function add_new_product(){
    global $db;
    
    if(isset($_POST['create_product'])){
        $product_name = mysqli_real_escape_string($db, $_POST['product_name']);
        $product_code = mysqli_real_escape_string($db, $_POST['product_code']);
        $product_price = mysqli_real_escape_string($db, $_POST['product_price']); 
        $vat_status = mysqli_real_escape_string($db, $_POST['vat_status']);
        $disc_status = mysqli_real_escape_string($db, $_POST['disc_status']);
        $created_by = $_SESSION['username'];
        $updated_by = $_SESSION['username'];
        
        $get_product = mysqli_query($db, "SELECT * FROM products_table WHERE product_name = '$product_name'");
        $get_num = mysqli_num_rows($get_product);
        
        
        if($get_num == 1){
            $_SESSION['get_nameErr'] = '<div class="danger">A product with this name already exists!</div>';
            //$_SESSION['get_codeErr'] = $get_codeErr;
        }else{
            mysqli_query($db, "INSERT INTO products_table(product_code, product_name, product_price, vat_status, disc_status, created_by, updated_by)VALUES('$product_code', '$product_name', '$product_price', '$vat_status', '$disc_status', '$created_by', '$updated_by')");
            $_SESSION['success'] = '<div class="success">Product has been created successfully!</div>';
        }
        
    }
    
}


function edit_product(){
    global $db;
    
    if(isset($_GET['product_id']) && $_GET['product_id'] != ''){
        $product_id = $_GET['product_id'];   
    }
    
    if(isset($_POST['update_product_code'])){
        $product_code = mysqli_real_escape_string($db, $_POST['product_code']);
        $updated_by = $_SESSION['username'];
        $updated_at = date('Y-m-d h:i:s', time()-3600);
        
        $find = mysqli_query($db, "SELECT * FROM products_table WHERE id = '$product_id'");
        $found = mysqli_fetch_assoc($find);
        $curr_product_code = $found['product_code'];
        
        if($product_code == $curr_product_code){
            $_SESSION['existsErr'] = '<div class="danger">No changes Made!</div>';
            
        }else{
            mysqli_query($db, "UPDATE products_table SET product_code = '$product_code', updated_by = '$updated_by', updated_at = '$updated_at' WHERE id = '$product_id'");
            $_SESSION['success'] = '<div class="success">Product code has been updated successfully!</div>';
        }
        
    }
        
    
    if(isset($_POST['update_product_name'])){
        $product_name = mysqli_real_escape_string($db, $_POST['product_name']);
        //$product_price = mysqli_real_escape_string($db, $_POST['product_price']); 
        //$vat_status = mysqli_real_escape_string($db, $_POST['vat_status']);
        //$disc_status = mysqli_real_escape_string($db, $_POST['disc_status']);
        $updated_by = $_SESSION['username'];
        $updated_at = date('Y-m-d h:i:s', time()-3600);
        
        $get_product = mysqli_query($db, "SELECT * FROM products_table WHERE product_name = '$product_name'");
        $get_num = mysqli_num_rows($get_product);
        
        $find = mysqli_query($db, "SELECT * FROM products_table WHERE id = '$product_id'");
        $found = mysqli_fetch_assoc($find);
        
        $curr_product_name = $found['product_name'];
        
        
        if($get_num == 1 && ($product_name != $curr_product_name)){
            $_SESSION['get_nameErr'] = '<div class="danger">A product with this name already exists!</div>';
            //$_SESSION['get_codeErr'] = $get_codeErr;
        }
        
        if($get_num == 1 && ($product_name == $curr_product_name)){
            
            $_SESSION['existsErr'] = '<div class="danger">No changes Made!</div>';
            
        }
        
        if($get_num != 1 && ($product_name != $curr_product_name)){
            
            mysqli_query($db, "UPDATE products_table SET product_name = '$product_name', updated_by = '$updated_by', updated_at = '$updated_at' WHERE id = '$product_id'");
            $_SESSION['success'] = '<div class="success">Product name has been updated successfully!</div>';
            
        }
        
    }
    
    
    if(isset($_POST['update_product_price'])){
        $product_price = mysqli_real_escape_string($db, $_POST['product_price']);
        $updated_by = $_SESSION['username'];
        $updated_at = date('Y-m-d h:i:s', time()-3600);
        
        $find = mysqli_query($db, "SELECT * FROM products_table WHERE id = '$product_id'");
        $found = mysqli_fetch_assoc($find);
        $curr_product_price = $found['product_price'];
        
        if($product_price == $curr_product_price){
            $_SESSION['existsErr'] = '<div class="danger">No changes Made!</div>';
            
        }else{
            mysqli_query($db, "UPDATE products_table SET product_price = '$product_price', updated_by = '$updated_by', updated_at = '$updated_at' WHERE id = '$product_id'");
            $_SESSION['success'] = '<div class="success">Product price has been updated successfully!</div>';
        }
        
    }
    
    
    if(isset($_POST['update_product_vat'])){
        $vat_status = mysqli_real_escape_string($db, $_POST['vat_status']);
        $updated_by = $_SESSION['username'];
        $updated_at = date('Y-m-d h:i:s', time()-3600);
        
        $find = mysqli_query($db, "SELECT * FROM products_table WHERE id = '$product_id'");
        $found = mysqli_fetch_assoc($find);
        $curr_vat_status = $found['vat_status'];
        
        if($vat_status == $curr_vat_status){
            $_SESSION['existsErr'] = '<div class="danger">No changes Made!</div>';
            
        }else{
            mysqli_query($db, "UPDATE products_table SET vat_status = '$vat_status', updated_by = '$updated_by', updated_at = '$updated_at' WHERE id = '$product_id'");
            $_SESSION['success'] = '<div class="success">Vat status has been updated successfully!</div>';
        }
        
    }
    
    
    if(isset($_POST['update_product_disc'])){
        $disc_status = mysqli_real_escape_string($db, $_POST['disc_status']);
        $updated_by = $_SESSION['username'];
        $updated_at = date('Y-m-d h:i:s', time()-3600);
        
        $find = mysqli_query($db, "SELECT * FROM products_table WHERE id = '$product_id'");
        $found = mysqli_fetch_assoc($find);
        $curr_disc_status = $found['disc_status'];
        
        if($disc_status == $curr_disc_status){
            $_SESSION['existsErr'] = '<div class="danger">No changes Made!</div>';
            
        }else{
            mysqli_query($db, "UPDATE products_table SET disc_status = '$disc_status', updated_by = '$updated_by', updated_at = '$updated_at' WHERE id = '$product_id'");
            $_SESSION['success'] = '<div class="success">Discount status has been updated successfully!</div>';
        }
        
    }
    
}


function edit_invoice(){
    global $db;
    
    if(isset($_GET['id']) && $_GET['id'] != ''){
        $id = $_GET['id'];   
    }
    
    $get_invoice_id = mysqli_query($db, "SELECT * FROM new_invoice_table WHERE id = '$id'");
        $id_array = mysqli_fetch_array($get_invoice_id);
    
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
        $updated_by = $_SESSION['username'];
        $updated_at = date('Y-m-d h:i:s', time()-3600);
        $new_invoice_total = 0;
        $new_discount_val = 0;
        $new_vat_val = 0;
    
    
    if(isset($_POST['update_invoice_quantity'])){
        
        
        $new_product_quantity = mysqli_real_escape_string($db, $_POST['new_product_quantity']);
        
        if($new_product_quantity == $product_quantity){
            $_SESSION['existsErr'] = '<div class="danger">No changes Made!</div>';
        }else{
            $new_invoice_total += $product_price * $new_product_quantity;
            $new_discount_val += $new_invoice_total * ($discount/100);
            $new_vat_val += ($new_invoice_total -  $new_discount_val) * ($vat/100);
            
            mysqli_query($db, 
            "UPDATE new_invoice_table SET 
            product_quantity = '$new_product_quantity', 
            total = '$new_invoice_total', 
            discount_figure = '$new_discount_val', 
            vat_figure = '$new_vat_val', 
            updated_by = '$updated_by', 
            updated_at = '$updated_at' 
            WHERE id = $id");
            
            $_SESSION['success'] = '<div class="success">Product quantity has been updated successfully!</div>';
            //echo "<script>window.location();</script>";
        }
    }
    
    
    if(isset($_POST['update_product_customer'])){
        
        
        $new_product_customer = mysqli_real_escape_string($db, $_POST['customer']);
        
        
        if($new_product_customer == $customer){
            $_SESSION['existsErr'] = '<div class="danger">No changes Made!</div>';
        }else{ 
            mysqli_query($db, 
            "UPDATE new_invoice_table SET 
            customer = '$new_product_customer',
            updated_by = '$updated_by', 
            updated_at = '$updated_at'
            WHERE invoice_number = '$invoice_number'");
            
            mysqli_query($db, 
            "UPDATE invoice_table SET 
            customer_name = '$new_product_customer',
            updated_by = '$updated_by', 
            updated_at = '$updated_at'
            WHERE invoice_number = '$invoice_number'");
            
            $_SESSION['success'] = '<div class="success">Customer has been updated successfully!</div>';
            //echo "<script>window.location();</script>";
        }
    }
    
    
    if(isset($_POST['update_po_number'])){
        
        
        $new_po_number = mysqli_real_escape_string($db, $_POST['po_number']);
        
        
        if($new_po_number == $po_number){
            $_SESSION['existsErr'] = '<div class="danger">No changes Made!</div>';
        }else{ 
            mysqli_query($db, 
            "UPDATE new_invoice_table SET 
            po_number = '$new_po_number',
            updated_by = '$updated_by', 
            updated_at = '$updated_at'
            WHERE invoice_number = '$invoice_number'");
            
            mysqli_query($db, 
            "UPDATE invoice_table SET 
            po_number = '$new_po_number',
            updated_by = '$updated_by', 
            updated_at = '$updated_at'
            WHERE invoice_number = '$invoice_number'");
            
            $_SESSION['success'] = '<div class="success">Po Number has been updated successfully!</div>';
            //echo "<script>window.location();</script>";
        }
    }
    
    
    
    if(isset($_POST['update_product_name'])){
        
        
        $new_product_name = mysqli_real_escape_string($db, $_POST['product_name']);
        $get = mysqli_query($db, "SELECT * FROM products_table WHERE product_name = '$new_product_name'");
        $gotten = mysqli_fetch_assoc($get);
        
        $new_product_code = $gotten['product_code'];
        
        if($new_product_name == $product_name){
            $_SESSION['existsErr'] = '<div class="danger">No changes Made!</div>';
        }else{ 
            mysqli_query($db, 
            "UPDATE new_invoice_table SET 
            product_description = '$new_product_name',
            product_code = '$new_product_code',
            updated_by = '$updated_by', 
            updated_at = '$updated_at'
            WHERE invoice_number = '$invoice_number' && id = '$id'");
            
            $_SESSION['success'] = '<div class="success">Product name & code have been updated successfully!</div>';
            //echo "<script>window.location();</script>";
        }
    }
    
    
    
    
    if(isset($_POST['update_project'])){
        
        
        $new_project = mysqli_real_escape_string($db, $_POST['project']);
        
        
        if($new_project == $project){
            $_SESSION['existsErr'] = '<div class="danger">No changes Made!</div>';
        }else{ 
            mysqli_query($db, 
            "UPDATE new_invoice_table SET 
            project = '$new_project',
            updated_by = '$updated_by', 
            updated_at = '$updated_at'
            WHERE invoice_number = '$invoice_number'");
            
            mysqli_query($db, 
            "UPDATE invoice_table SET 
            project = '$new_project',
            updated_by = '$updated_by', 
            updated_at = '$updated_at'
            WHERE invoice_number = '$invoice_number'");
            
            $_SESSION['success'] = '<div class="success">Delivery address has been updated successfully!</div>';
            //echo "<script>window.location();</script>";
        }
    }
    
    
    
    if(isset($_POST['update_invoice_discount'])){
        
        
        $new_invoice_discount = mysqli_real_escape_string($db, $_POST['discount']);
        
        if($new_invoice_discount == $discount){
            $_SESSION['existsErr'] = '<div class="danger">No changes Made!</div>';
        }else{
            $new_invoice_total += $product_price * $product_quantity;
            $new_discount_val += $new_invoice_total * ($new_invoice_discount/100);
            $new_vat_val += ($new_invoice_total -  $new_discount_val) * ($vat/100);
            
            mysqli_query($db, 
            "UPDATE new_invoice_table SET 
            discount = '$new_invoice_discount', 
            total = '$new_invoice_total', 
            discount_figure = '$new_discount_val', 
            vat_figure = '$new_vat_val', 
            updated_by = '$updated_by', 
            updated_at = '$updated_at' 
            WHERE id = $id");
            
            $_SESSION['success'] = '<div class="success">Product discount has been updated successfully!</div>';
            //echo "<script>window.location();</script>";
        }
    }
    
    
    
    if(isset($_POST['update_invoice_vat'])){
        
        
        $new_invoice_vat = mysqli_real_escape_string($db, $_POST['vat']);
        
        if($new_invoice_vat == $vat){
            $_SESSION['existsErr'] = '<div class="danger">No changes Made!</div>';
        }else{
            $new_invoice_total += $product_price * $product_quantity;
            $new_discount_val += $new_invoice_total * ($discount/100);
            $new_vat_val += ($new_invoice_total -  $new_discount_val) * ($new_invoice_vat/100);
            
            mysqli_query($db, 
            "UPDATE new_invoice_table SET 
            vat = '$new_invoice_vat', 
            total = '$new_invoice_total', 
            discount_figure = '$new_discount_val', 
            vat_figure = '$new_vat_val', 
            updated_by = '$updated_by', 
            updated_at = '$updated_at' 
            WHERE id = $id");
            
            $_SESSION['success'] = '<div class="success">Product discount has been updated successfully!</div>';
            //echo "<script>window.location();</script>";
        }
    }
    
    
}


function delete_unique_invoice(){
    global $db;
    
    if(isset($_GET['unique_id']) && $_GET['unique_id'] != ""){
        $id = $_GET['id'];
        $invoice_number = $_GET['unique_id'];
        
        $select = mysqli_query($db, "SELECT * FROM new_invoice_table WHERE invoice_number = '$invoice_number'");
        $num = mysqli_num_rows($select);
        
        if($num > 1){
            mysqli_query($db, "DELETE FROM new_invoice_table WHERE invoice_number = '$invoice_number' && id = '$id'");
            header('location:invoice.php');
            $_SESSION['delete'] = '<div class="success">Item has been deleted successfully!</div>';
        }elseif($num == 1){
            mysqli_query($db, "DELETE FROM new_invoice_table WHERE invoice_number = '$invoice_number'");
            mysqli_query($db, "DELETE FROM invoice_table WHERE invoice_number = '$invoice_number'");
            header('location:invoice.php');
            $_SESSION['delete'] = '<div class="success">Invoice has been deleted successfully!</div>';
        }
        
    }
}



function delete_invoice(){
    global $db;
    
    if(isset($_GET['delete_invoice_id']) && $_GET['delete_invoice_id'] != ""){
        $invoice_number = $_GET['delete_invoice_id'];
                
        mysqli_query($db, "DELETE FROM new_invoice_table WHERE invoice_number = '$invoice_number'");
        mysqli_query($db, "DELETE FROM invoice_table WHERE invoice_number = '$invoice_number'");
        header('location:invoice.php');
        $_SESSION['delete'] = '<div class="success">Invoice has been deleted successfully!</div>';
        
    }
}


function delete_product(){
    global $db;
    
    if(isset($_GET['product_id']) && $_GET['product_id'] != ""){
        $product_id = $_GET['product_id'];
        
        mysqli_query($db, "DELETE FROM products_table WHERE id = '$product_id'");
        header('location:product.php');
        $_SESSION['delete'] = '<br><div class="success">Product has been deleted successfully!</div>';
        
    }
}


function update_invoice_status(){
    global $db;
    
    if(isset($_POST['update_invoice_status'])){
        $invoice_number = $_GET['id'];
        $status = mysqli_real_escape_string($db, $_POST['status']);
        $updated_by = $_SESSION['username'];
        $updated_at = date('Y-m-d h:i:s', time()-3600);
        
        $select = mysqli_query($db, "SELECT * FROM invoice_table WHERE invoice_number = '$invoice_number' && status = '$status'");
        $num = mysqli_num_rows($select);
        
        if($num == 1){
            $_SESSION['updateMsg'] = '<br><div class="danger">No changes made!</div>';
        }else{
            mysqli_query($db, "UPDATE invoice_table SET status = '$status', updated_by = '$updated_by', updated_at = '$updated_at' WHERE invoice_number = '$invoice_number'");
            mysqli_query($db, "UPDATE new_invoice_table SET status = '$status', updated_by = '$updated_by', updated_at = '$updated_at' WHERE invoice_number = '$invoice_number'");
            $_SESSION['updateMsg'] = '<br><div class="success">Invoice status has been updated successfully!</div>';
            //header('location:invoice_status.php');    
        }
    }
}
?>