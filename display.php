<?php
    include_once('includes/connection.php');  
    include_once('includes/functions.php');  
    session_start();

    if(!isset($_SESSION['username']) || $_SESSION['username'] == ''){
        header('location:login.php');
    }

    if(isset($_SESSION['item'])){
        unset($_SESSION['item']);
    }

    if(isset($_GET['invoice']) && $_GET['invoice'] != ""){
        $invoice_id = $_GET['invoice'];
    }else{
        header('location:invoice.php');
    }

    $choose = mysqli_query($db, "SELECT * FROM invoice_table WHERE invoice_number = '$invoice_id'");
    $chosen = mysqli_fetch_assoc($choose);
    $num = mysqli_num_rows($choose);

    if($num != 1){
        header('location:invoice.php');
    }
?>

<html lang="en">
<head>
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
                    <a href="invoice.php">Back</a>
                    <a href="print.php?invoice=<?php echo $invoice_id?> " target="_blank">Print Invoice</a>
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
                    //if(isset($_SESSION['print_link'])){
                        //echo $_SESSION['print_link'];
                        //unset($_SESSION['print_link']);
                    //}
                
                ?>
                
                
                <div class="gen-invoice-container">
                    <div class="gen-invoice-container-header">
                        <div class="gich-col">
                            <div class="coy-name">CHIDON GLOBAL - TECH ENTERPRISES</div>
                            <div class="coy-address">Office: 42, Idoluwo Street, Lagos Island</div>
                            <div class="coy-email">Email: uzomaemmanuel29@yahoo.com</div>
                            <div class="coy-tel">Tel: +234, 8023 001 097, +234 8098 380 672</div>
                            
                            <?php
                            
                                $choose = mysqli_query($db, "SELECT * FROM invoice_table WHERE invoice_number = '$invoice_id'");
                                $chosen = mysqli_fetch_assoc($choose);
                                $num = mysqli_num_rows($choose);
                                
                                if($num != 1){
                                    header('location:invoice.php');
                                }
                            
                            
                                $inv_name = $chosen['customer_name'];
                                $inv_project = $chosen['project'];
                                $inv_po_number = $chosen['po_number'];
                                $inv_date = date('D M, Y | h:i:s a', strtotime($chosen['created_at']));
                            ?>
                            
                            <div class="biller">Billed To</div>
                            <div class="inv-coy-name"><?php echo $inv_name; ?></div>
                            <div class="branch"><?php echo $inv_project; ?></div>
                        </div>
                        
                        <div class="gich-col gich-col-2">
                            <div class="inv-date">Date: <?php echo $inv_date; ?></div>
                            <div class="sales-inv-no"><span class="bold-text">SALE INVOICE #: </span><?php echo $invoice_id; ?></div>
                            <div class="sales-inv-no"><span class="bold-text">P.O. #: </span><?php echo $inv_po_number; ?></div>
                        </div>
                    </div>
                    
                    <div class="gen-invoice-table">
                        <table>
                            <tr>
                                <td>CODE</td>
                                <td>DESCRIPTION OF GOODS</td>
                                <td>QTY</td>
                                <td>RATE</td>
                                <td>VAT</td>
                                <td>DISCOUNT</td>
                                <td>AMOUNT</td>
                            </tr>
                            
                            <?php
                                $get_new_inv_table = mysqli_query($db, "SELECT * FROM new_invoice_table WHERE invoice_number = '$invoice_id'");
                                $gotten_new_inv_table = mysqli_fetch_array($get_new_inv_table);
                                $inv_details = $gotten_new_inv_table;
                                $sub_total = 0;
                                $net_total = 0;
                                $inv_vat = 0;
                                $discount_total = 0;
                                $inv_other_charges = 0;
                                $inv_vat_total = 0;
                            
                                foreach($get_new_inv_table as $inv_details){
                                    $inv_code = $inv_details['product_code'];
                                    $inv_description = $inv_details['product_description'];
                                    $inv_qty = $inv_details['product_quantity'];
                                    $inv_price = number_format($inv_details['product_price'], 2);
                                    $inv_discount = $inv_details['discount'] . '%';
                                    $inv_vat = ($inv_details['vat']) . '%';
                                    $total = $inv_details['product_quantity'] * $inv_details['product_price'];
                                    
                                    $discount_total = $discount_total + ($total * $inv_details['discount']/100);
                                    
                                    $inv_vat_total = $inv_vat_total + ($total - ($inv_details['discount_figure'])) * ($inv_details['vat']/100);
                                    
                                    if($inv_details['vat'] == 0){
                                        $inv_other_charges = $inv_other_charges + ($inv_details['product_quantity'] * $inv_details['product_price']);
                                    }else{
                                        $sub_total = $sub_total + ($inv_details['product_quantity'] * $inv_details['product_price']);
                                    }
                                    
                                    $inv_total = number_format($inv_details['total'], 2);
                                    
                                    $net_total = ($sub_total - $discount_total) + $inv_other_charges + $inv_vat_total;
                            ?>
                            
                                <tr>
                                    <td><?php echo $inv_code; ?></td>
                                    <td><?php echo $inv_description; ?></td>
                                    <td><?php echo $inv_qty; ?></td>
                                    <td><?php echo $inv_price; ?></td>
                                    <td><?php echo $inv_vat; ?></td>
                                    <td><?php echo $inv_discount; ?></td>
                                    <td><?php echo $inv_total; ?></td>
                                </tr>
                            
                            <?php
                                }
                            ?>
                            
                        </table>
                    </div>
                    
                    <div class="gen-invoice-container-header">
                        <div class="gich-col">
                            <div class="coy-address">KINDLY MAKE YOUR PAYMENTS INTO:</div>
                            <div class="coy-address">ACCOUNT NAME: CHIDON GLOBAL - TECH ENTERPRISES</div>
                            <div class="coy-email">ACCOUNT NUMBER: 011145XXXX</div>
                            <div class="coy-email">BANK NAME: FIRST BANK NIGERIA PLC</div>
                        </div>
                        
                        <div class="gich-col gich-col-new">
                            <div class="gich-col-flex">
                                <div class="gicf-col">
                                    <div class="gicf-sub-total">SUB-TOTAL</div>
                                    <div class="gicf-sub-total">DISCOUNT</div>
                                    <div class="gicf-sub-total">OTHER CHARGES</div>
                                    <div class="gicf-sub-total">VAT (7.5%)</div>
                                    <div class="gicf-sub-total">TOTAL (NGN)</div>
                                </div>
                                <div class="gicf-col">
                                    <div class="gicf-sub-figure">
                                        <?php echo number_format($sub_total, 2); ?>
                                    </div>
                                    <div class="gicf-sub-figure">
                                        <?php echo number_format($discount_total, 2); ?>
                                    </div>
                                    <div class="gicf-sub-figure">
                                        <?php echo number_format($inv_other_charges, 2); ?>
                                    </div>
                                    <div class="gicf-sub-figure">
                                        <?php echo number_format($inv_vat_total, 2); ?>
                                    </div>
                                    <div class="gicf-sub-figure-last">
                                        <?php echo number_format($net_total, 2); ?>
                                    </div>
                                </div>
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