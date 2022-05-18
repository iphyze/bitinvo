<?php

$db = mysqli_connect('127.0.0.1', 'root', 'root', 'invoice_gen_db');

if(!$db){
    die('Sorry we were unable to connect to database!');
}

?>