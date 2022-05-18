<?php
    
$select = mysqli_query($db, "SELECT * FROM products_table");
$selected = mysqli_fetch_array($select);
$num = mysqli_num_rows($select);

if($num > 0){
    foreach($select as $selected){
        $product_code = $selected['product_code'];
        $product_name = $selected['product_name'];
        $product_price = number_format($selected['product_price'], 2);
        $created_at = $selected['created_at'];
        $created_by = $selected['created_by'];

        $table = '<tr>
                    <td>' . $selected["id"]. '</td>
                    <td>' . $product_code . '</td>
                    <td>' . $product_name . '</td>
                    <td>' . $product_price . '</td>
                    <td>
                        <a href="add_items.php?item_id=' . $selected["id"]. '" class="fas fa-plus add-more-items"></a>
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