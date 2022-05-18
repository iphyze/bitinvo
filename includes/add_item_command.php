<?php
if(isset($_POST['add_to_invoice'])){
    if(isset($_SESSION['item'])){
        $item_array_id = array_column($_SESSION['item'], "id");
        if(!in_array($_GET['id'], $item_array_id)){
            $count = count($_SESSION['item']);
            $item_array = array(
                'id' => $_GET['id'],
                'code' => $_POST['item_code'],
                'description' => $_POST['item_description'],
                'quantity' => $_POST['item_quantity'],
                'vat' => $_POST['item_vat'],
                'discount' => $_POST['item_discount'],
                'price' => $_POST['item_price'],
            );
            $_SESSION['item'][$count] = $item_array;
            $success = '<div class="success">Item was successfully added!</div>';
            $_SESSION['success'] = $success;
        }else{
             $error = '<div class="danger">Item is already added!</div>';
            $_SESSION['error'] = $error;
        }
    }else{
        $item_array = array(
                'id' => $_GET['id'],
                'code' => $_POST['item_code'],
                'description' => $_POST['item_description'],
                'quantity' => $_POST['item_quantity'],
                'vat' => $_POST['item_vat'],
                'discount' => $_POST['item_discount'],
                'price' => $_POST['item_price'],
            );
            $_SESSION['item'][0] = $item_array;
    }
}


if(isset($_GET['action'])){
    if($_GET['action'] == 'delete'){
    foreach($_SESSION['item'] as $keys => $value){
        if(isset($_GET['id']) && $value['id'] == $_GET['id']){
            unset($_SESSION['item'][$keys]);
            $error = '<div class="success">Item has been removed!</div>';
            $_SESSION['error'] = $error;
            }
        }
    }
}


if(isset($_GET['action']) && ($_GET['action'] == 'empty') && isset($_SESSION['item'])){
    unset($_SESSION['item']);
    $_SESSION['item_quantity'] = 0;
    $total = 0;
    $_SESSION['error'] = '<div class="success">All items have been removed!</div>';
}
?>