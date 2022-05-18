<?php
$select = mysqli_query($db, "SELECT * FROM products_table");
$selected = mysqli_fetch_array($select);
$num = mysqli_num_rows($select);

if($num > 0){
    foreach($select as $selected){
        $product_code = $selected['product_code'];
        $product_name = $selected['product_name'];
        $product_price = number_format($selected['product_price'], 2);
        $vat_status = $selected['vat_status'];
        $discount_status = $selected['disc_status'];
        $created_at = date('Y-m-d', strtotime($selected['created_at']));
        $updated_at = date('Y-m-d', strtotime($selected['updated_at']));
        $updated_by = $selected['updated_by'];
        $created_by = $selected['created_by'];

        $table = '<tr>
                    <td>' . $selected["id"]. '</td>
                    <td>' . $product_name . '</td>
                    <td>' . $product_price . '</td>
                    <td>' . $vat_status . '</td>
                    <td>' . $discount_status . '</td>
                    <td>' . $created_by . '</td>
                    <td>' . $updated_by . '</td>
                    <td>
                        <a href="edit_product.php?product_id='.$selected['id'].'" class="fas fa-edit action-edit"></a> 
                        <a href="delete.php?product_id='.$selected['id'].'" class="fas fa-trash action-trash" onclick="return confirm(\'Are You Sure?\')"></a>
                    </td>
                </tr>';
        echo $table;
    }
}else{
        $table = '<tr>
                    <td colspan="8">No data found!</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>';
        echo $table;
}
?>