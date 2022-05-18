<?php
    include_once('includes/connection.php');  
    include_once('includes/functions.php');  
    session_start();

    if(!isset($_SESSION['username']) || $_SESSION['username'] == ''){
        header('location:login.php');
    }
   

    if(empty($_SESSION['item']) || !isset($_SESSION['item'])){
        $item_not_set = "<div class='danger'>Please select an item before invoice can be generated</div>";
        $_SESSION['item_not_set'] = $item_not_set;
        header('location:generate.php');
    }
                    
    if(isset($_GET['action']) && $_GET['action'] = 'delete'){
        unset($_SESSION['item']);
        $_SESSION['item_quantity'] = 0;
        $total = 0;
        $_SESSION['delete_all'] = '<div class="success">All items have been removed!</div>';
        header('location:generate.php');
    }

    include_once('includes/add_item_command.php');
    include_once('includes/generate_invoice.php');


?>

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
                        <p class="ao-title">GENERATE NEW INVOICE</p>
                        <p class="ao-subtitle">Fill the form below to make invoice</p>
                </div>
                
                <div class="print-container">
                    <a href="#" onclick="history.back()">Back</a>
                </div>
                
                <?php
                $max_invoice_number = mysqli_query($db, "SELECT MAX(invoice_number) AS invoice_number FROM invoice_table");
                $selected_num = mysqli_fetch_array($max_invoice_number);
                ?>
                
                <div class="area-one right-align">
                        <p class="ao-title">INVOICE #: <?php echo $selected_num['invoice_number'] += 1; ?></p>
                </div>
                
                <?php
                    if(isset($_SESSION['success'])){
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    }
                    if(isset($_SESSION['error'])){
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    }
                    if(isset($_SESSION['emptyCartErr'])){
                        echo $_SESSION['emptyCartErr'];
                        unset($_SESSION['emptyCartErr']);
                    }
                    if(isset($_SESSION['order_success'])){
                        echo $_SESSION['order_success'];
                        unset($_SESSION['order_success']);
                    }
                
                    if(isset($_SESSION['duplicate_invoice_err'])){
                        echo $_SESSION['duplicate_invoice_err'];
                        unset($_SESSION['duplicate_invoice_err']);
                    }
                    if(isset($_SESSION['success_invoice_gen'])){
                        echo $_SESSION['success_invoice_gen'];
                        unset($_SESSION['success_invoice_gen']);
                    }
                
                ?>
                
                <?php if(!empty($print_link)){echo $print_link; }?>
                
                <div class="invoice-table">
                    <table>
                        <thead>
                        <tr>
                            <td>#ID</td>
                            <td>Item Code</td>
                            <td>Item Description</td>
                            <td>Qty</td>
                            <td>Price</td>
                            <td>Discount</td>
                            <td>Vat</td>
                            <td>Total</td>
                        </tr>
                        </thead>
                        
                        
                        <?php
                                
                        if(!empty($_SESSION['item'])){
                            $total = 0;
                            $total_quantity = 0;
                            $discount = 0;
                            $total_discount = 0;
                            $sub_total = 0;
                            $inv_total = 0;
                            $total_vat = 0;
                            $vat = 0;
                            $get_vat = 0;
                            $id_num = 0;
                            $other_charges  = 0;
                            $net_total = 0;
                            $total_sub_total = 0;
                            $others = 0;
                            $new_other_charges = 0;
                            foreach($_SESSION['item'] as $keys => $value){
                        ?>
                        
                        <tr>
                            <td><?php echo $id_num+=1; ?></td>
                            <td><?php echo $value['code']; ?></td>
                            <td><?php echo $value['description']; ?></td>
                            <td><?php echo $value['quantity']; ?></td>
                            <td><?php echo number_format($value['price'], 2); ?></td>
                            <td><?php echo $value['discount'] . '%'; ?></td>
                            <td><?php echo $value['vat'] . '%'; ?></td>
                            <td><?php echo number_format($value['quantity'] * $value['price'], 2); ?></td>
                        </tr>
                        
                        <?php
                            if($value['vat'] == 0){
                                $other_charges = ($value['quantity'] * $value['price']);
                                $new_other_charges += $other_charges;
                            }else{
                                $total = $total + ($value['quantity'] * $value['price']);    
                            }
                            
                            $total_quantity = $total_quantity + ($value['quantity']);
                            $_SESSION['quantity'] = $total_quantity;
                    
                            
                            if($value['discount'] == 0){
                                $discount = $discount + 0;
                            }else{
                                $discount = $discount + (($value['quantity'] * $value['price']) * ($value['discount'] / 100));
                            }    
                                
                            if($value['vat'] == 0){    
                                $other_charges = ($value['quantity'] * $value['price']); 
                            }else{
                                $vat = ($total - $discount) * ($value['vat'] / 100);
                            }
                            
                            $inv_total = ($total - $discount)  + ($new_other_charges) + ($vat);
                            
                            }
                            
                            $total_discount += $discount;
                            $total_vat += $vat;
                            $net_total += $inv_total;
                            $others += $new_other_charges;
                            
                        }else{
                        ?>    
                        
                        <tr>
                            <td colspan="7" style="text-align: center">No items added yet</td>
                        </tr>
                        
                        <?php
                        }
                        ?>

                        <tr class="total-row">
                            <td colspan="6"></td>
                            <td class="total-col">SUB-TOTAL</td>
                            <td class="total-col tc-col">
                                <?php if(!empty($total)){echo number_format($total, 2);}else{echo "0.00";} ?>
                            </td>
                        </tr>
                        
                        
                        <tr class="total-row">
                            <td colspan="6"></td>
                            <td class="total-col">DISCOUNT</td>
                            <td class="total-col tc-col">
                                <?php if(!empty($total_discount)){echo number_format($total_discount, 2);}else{echo "0.00";} ?>
                            </td>
                        </tr>
                        
                        <tr class="total-row">
                            <td colspan="6"></td>
                            <td class="total-col">OTHER CHARGES</td>
                            <td class="total-col tc-col">
                                <?php if(!empty($others)){echo number_format($others, 2);}else{echo "0.00";} ?>
                            </td>
                        </tr>
                        
                        <tr class="total-row">
                            <td colspan="6"></td>
                            <td class="total-col">VAT (7.5%)</td>
                            <td class="total-col tc-col">
                                <?php if(!empty($total_vat)){echo number_format($total_vat, 2);}else{echo "0.00";} ?>
                            </td>
                        </tr>
                        
                        <tr class="total-row">
                            <td colspan="6"></td>
                            <td class="total-col">TOTAL (NGN)</td>
                            <td class="total-col tc-col">
                                <?php if(!empty($net_total)){echo number_format($net_total, 2);}else{echo "0.00";} ?>
                            </td>
                        </tr>
                        
                    </table>
                </div>
                
                <div class="supplier_details_container">
                    <div class="title">ENTER CUSTOMER'S DETAILS</div>
                    <p class="ao-subtitle">Fill the customer's form below to assign invoice to customer</p>
                    
                    <div class="form-container">
                        <form method="post" action="">
                            <div class="form-group">
                                <select name="customer_name" required class='supplier-select-form'>
                                    
                                    <option value='' class='supplier-select-form'>--Select Customer--</option>
                                    <?php
                                        $select = mysqli_query($db, "SELECT * FROM customer_table");
                                        $selected = mysqli_fetch_array($select);
                                        $num = mysqli_num_rows($select);
                                        
                                        if($num > 0){
                                            foreach($select as $selected){
                                        ?>
                                        <option value='<?php echo $selected['customer_name']?>' class='supplier-select-form'><?php echo $selected['customer_name']?></option>";
                                    <?php
                                            }
                                        }else{
                                            echo "<option value='' class='supplier-select-form'>No record</option>";
                                        }
                                    ?>
                                </select>
                                <span class="fas fa-caret-down"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" name="po_number" placeholder="Purchase Order Number" required class='supplier-input-form'>
                            </div>
                            <div class="form-group">
                                <input type="text" name="project" placeholder="Branch/Project" required class='supplier-input-form'>
                            </div>
                            <div class="form-group form-group-btn">
                                <a href='select_supplier.php?action=delete' class="fgb-red">Cancel Invoice</a>
                            </div>
                            <div class="form-group form-group-btn">
                                <button type="submit" name="generate_invoice" class='supplier-btn-form'>Generate Invoice</button>
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