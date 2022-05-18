<?php
$select = mysqli_query($db, "SELECT * FROM invoice_table");
$selected = mysqli_fetch_array($select);
$num = mysqli_num_rows($select);

if($num > 0){
    foreach($select as $selected){
        $invoice_number = $selected['invoice_number'];
        $customer_name = $selected['customer_name'];
        $created_at = date('Y-m-d', strtotime($selected['created_at']));
        $created_by = $selected['created_by'];

        $table = '<tr>
                    <td>' . $selected["id"]. '</td>
                    <td>' . $invoice_number . '</td>
                    <td>' . $customer_name . '</td>
                    <td>' . $created_at . '</td>
                    <td>' . $created_by . '</td>
                    <td>
                        <a href="show_invoice.php?invoice_id='.$invoice_number.'" class="fas fa-edit action-edit"></a> 
                        <a href="delete.php?delete_invoice_id='.$invoice_number.'" class="fas fa-trash action-trash" onclick="return confirm(\'Are you sure you want to delete this item?\')"></a>
                        <a href="display.php?invoice='.$invoice_number.'" class="fas fa-print action-print"></a>
                    </td>
                </tr>';
        echo $table;
    }
}else{
        $table = '<tr>
                    <td colspan="6">No data found!</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>';
        echo $table;
}
?>