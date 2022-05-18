<?php
    
$select = mysqli_query($db, "SELECT * FROM invoice_table");
$selected = mysqli_fetch_array($select);
$num = mysqli_num_rows($select);

if($num > 0){
    foreach($select as $selected){
        $invoice_number = $selected['invoice_number'];
        $status = $selected['status'];
        $customer_name = $selected['customer_name'];
        $created_at = $selected['created_at'];
        $created_by = $selected['created_by'];

        $table = '<tr>
                    <td>' . $selected["id"]. '</td>
                    <td>' . $invoice_number . '</td>
                    <td>' . $customer_name . '</td>
                    <td>' . $status . '</td>
                    <td>
                        <a href="invoice_status.php?id=' . $selected["invoice_number"]. '" class="fas fa-edit add-more-items"></a>
                    </td>
                </tr>';
        echo $table;
    }
}else{
        $table = '<tr>
                    <td colspan="5">No data found!</td>
                </tr>';
        echo $table;
}

?>