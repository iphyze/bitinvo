<?php
$total = 0;
$total_quantity = 0;
$discount_figure = 0;
$vat_figure = 0;
$print_link = "";

if(isset($_POST['generate_invoice'])){
    $customer_name = mysqli_real_escape_string($db, $_POST['customer_name']);
    $po_number = mysqli_real_escape_string($db, $_POST['po_number']);
    $project = mysqli_real_escape_string($db, $_POST['project']);
    $created_by = $_SESSION['username'];
    
    $max_invoice_number = mysqli_query($db, "SELECT MAX(invoice_number) AS invoice_number FROM invoice_table");
    $selected_num = mysqli_fetch_array($max_invoice_number);
    $new_invoice_num = $selected_num['invoice_number'] += 1;
    
    
    $get_invoice_table_data = mysqli_query($db, "SELECT * FROM invoice_table WHERE invoice_number = '$new_invoice_num'");
    $get_num_invoice_table_data = mysqli_num_rows($get_invoice_table_data);
    
    if($get_num_invoice_table_data > 0){
         $_SESSION['duplicate_invoice_err'] = '<div class="danger">Oops invoice number already exists!</div>';
    }else{
        mysqli_query($db, "INSERT INTO invoice_table(invoice_number, customer_name, po_number, project,  created_by)VALUES('$new_invoice_num', '$customer_name', '$po_number', '$project', '$created_by')");
    }
        
    
    if(!empty($_SESSION['item'])){
            
        foreach($_SESSION['item'] as $keys => $value){
        
        $product_quantity = $value['quantity'];
        $product_price = $value['price'];
        $product_code = $value['code'];
        $product_description = $value['description'];
        $product_vat = $value['vat'];
        $product_discount = $value['discount'];
        
        $total = $value['price'] * $value['quantity'];

        $vat = ($value['vat']);
        
        $discount = ($value['discount']);
            
        $discount_figure = $total * ($value['discount']/100);
        
        if($discount == 0){
            $vat_figure = $total * ($value['vat']/100);
        }else{
            $vat_figure = ($total - $discount_figure) * ($value['vat']/100);   
        }       
            
        mysqli_query($db, "INSERT INTO new_invoice_table(invoice_number, po_number, project, product_code, product_description, product_price, product_quantity, total, vat, discount, vat_figure, discount_figure, customer, created_by)VALUES('$new_invoice_num', '$po_number', '$project', '$product_code', '$product_description', '$product_price', '$product_quantity', '$total', '$vat', '$discount', '$vat_figure', '$discount_figure', '$customer_name', '$created_by')");
            
        $_SESSION['success_invoice_gen'] = '<div class="success">Your invoice was successfully generated!</div>';
        $_SESSION['print_link'] = "<a href='display.php?invoice={$new_invoice_num}' class='add-more-items'>Print Invoice</a>";
        header('location:display.php?invoice='.$new_invoice_num);
        //unset($_SESSION['item']);
        }
    }
    
}



?>
