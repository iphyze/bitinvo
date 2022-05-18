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
if(isset($_SESSION['item_not_set'])){
    echo $_SESSION['item_not_set'];
    unset($_SESSION['item_not_set']);
}
if(isset($_SESSION['delete_all'])){
    echo $_SESSION['delete_all'];
    unset($_SESSION['delete_all']);
}

if(isset($_SESSION['duplicate_invoice_err'])){
    echo $_SESSION['duplicate_invoice_err'];
    unset($_SESSION['duplicate_invoice_err']);
}
if(isset($_SESSION['success_invoice_gen'])){
    echo $_SESSION['success_invoice_gen'];
    unset($_SESSION['success_invoice_gen']);
}
if(isset($_SESSION['get_nameErr'])){
    echo $_SESSION['get_nameErr'];
    unset($_SESSION['get_nameErr']);
}
if(isset($_SESSION['get_codeErr'])){
    echo $_SESSION['get_codeErr'];
    unset($_SESSION['get_codeErr']);
}
if(isset($_SESSION['existsErr'])){
    echo $_SESSION['existsErr'];
    unset($_SESSION['existsErr']);
}
if(isset($_SESSION['delete'])){
    echo $_SESSION['delete'];
    unset($_SESSION['delete']);
}
?>