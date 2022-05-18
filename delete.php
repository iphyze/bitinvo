<?php
include_once('includes/connection.php');
include_once('includes/functions.php');
session_start();

if(!isset($_GET['unique_id']) || !isset($_GET['id']) || !isset($_GET['delete_invoice_id'])){
    header('Location:invoice.php');
}

if(!isset($_GET['product_id'])){
    header('Location:product.php');
}

delete_unique_invoice();

delete_invoice();

delete_product();


?>