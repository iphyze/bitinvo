<?php
$select = mysqli_query($db, "SELECT * FROM new_invoice_table WHERE invoice_number = '$invoice_id'");
$selected = mysqli_fetch_array($select);
$num = mysqli_num_rows($select);
$number = 1;

if($num > 0){
    foreach($select as $selected){
        $invoice_number = $selected['invoice_number'];
        $total = number_format($selected['total'], 2);
        $price = number_format($selected['product_price'], 2);
        $discount = number_format($selected['discount_figure'], 2);
        $vat = number_format($selected['vat_figure'], 2);
        $quantity = $selected['product_quantity'];
        $customer = $selected['customer'];
        $created_at = date('Y-m-d', strtotime($selected['created_at']));
        $created_by = $selected['created_by'];
        $updated_by = $selected['updated_by'];
        $updated_at = date('Y-m-d h:i:s', time()-3600);
        $id = $selected['id'];

        $table = '<tr>
                    <td>' . $number++ . '</td>
                    <td>' . $price . '</td>
                    <td>' . $quantity . '</td>
                    <td>' . $total . '</td>
                    <td>' . $discount . '</td>
                    <td>' . $vat . '</td>
                    <td>' . $updated_by . '</td>
                    <td>' . $updated_at . '</td>
                    <td>
                        <a href="edit_invoice.php?id='.$id.'" class="fas fa-edit action-edit"></a> 
                        <a href="delete.php?id='.$id.'&unique_id='.$invoice_number.'" class="fas fa-trash action-trash" onclick="return confirm(\'Are you sure you want to delete this item?\')"></a>
                    </td>
                </tr>';
        echo $table;
    }
}else{
        $table = '<tr>
                    <td colspan="7">No data found!</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>';
        echo $table;
}
?>