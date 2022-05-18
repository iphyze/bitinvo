<?php
    include_once('includes/connection.php');  
    include_once('includes/functions.php');  
    session_start();

    if(!isset($_SESSION['username']) || $_SESSION['username'] == ''){
        header('location:login.php');
    }
    
    include_once('includes/add_item_command.php');
?>

<!DOCTYPE html>
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
                    <a href="add_items.php">Back</a>
                </div>
                
                <div class="area-one right-align pad-20">
                        <p class="ao-title ao-subtitle">INVOICE #: XXXXXX</p>
                </div>
                
                <?php include_once('includes/messages.php'); ?>
        
                
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
                            <td>Remove</td>
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
                    <tbody>    
                        <tr>
                            <td><?php echo $id_num+=1; ?></td>
                            <td><?php echo $value['code']; ?></td>
                            <td><?php echo $value['description']; ?></td>
                            <td><?php echo $value['quantity']; ?></td>
                            <td><?php echo number_format($value['price'], 2); ?></td>
                            <td><?php echo $value['discount'] . '%'; ?></td>
                            <td><?php echo $value['vat'] . '%'; ?></td>
                            <td><?php echo number_format($value['quantity'] * $value['price'], 2); ?></td>
                            <td><a href="generate.php?action=delete&id=<?php echo $value['id']; ?>" class="fas fa-trash action-trash"></a></td>
                        </tr>
                    </tbody>
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
                        <tbody>
                        <tr>
                            <td colspan="9" style="text-align: center">No items added yet</td>
                        </tr>
                        </tbody>
                        <?php
                        }
                        ?>

                        <tr class="total-row">
                            <td colspan="7"></td>
                            <td class="total-col">SUB-TOTAL</td>
                            <td class="total-col tc-col">
                                <?php if(!empty($total)){echo number_format($total, 2);}else{echo "0.00";} ?>
                            </td>
                        </tr>
                        
                        
                        <tr class="total-row">
                            <td colspan="7"></td>
                            <td class="total-col">DISCOUNT</td>
                            <td class="total-col tc-col">
                                <?php if(!empty($total_discount)){echo number_format($total_discount, 2);}else{echo "0.00";} ?>
                            </td>
                        </tr>
                        
                        <tr class="total-row">
                            <td colspan="7"></td>
                            <td class="total-col">OTHER CHARGES</td>
                            <td class="total-col tc-col">
                                <?php if(!empty($others)){echo number_format($others, 2);}else{echo "0.00";} ?>
                            </td>
                        </tr>
                        
                        <tr class="total-row">
                            <td colspan="7"></td>
                            <td class="total-col">VAT (7.5%)</td>
                            <td class="total-col tc-col">
                                <?php if(!empty($total_vat)){echo number_format($total_vat, 2);}else{echo "0.00";} ?>
                            </td>
                        </tr>
                        
                        <tr class="total-row">
                            <td colspan="7"></td>
                            <td class="total-col">TOTAL (NGN)</td>
                            <td class="total-col tc-col">
                                <?php if(!empty($net_total)){echo number_format($net_total, 2);}else{echo "0.00";} ?>
                            </td>
                        </tr>
                        
                    </table>
                </div>
                
                <div class="action-container">
                    <a class='empty-list' href="generate.php?action=empty">Empty List</a>
                    <a class='add-more-items' href="add_items.php">Add More Items</a>
                    <a class='generate-invoice' href="select_supplier.php">Generate Invoice</a>
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