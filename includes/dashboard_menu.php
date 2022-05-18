<?php




function active_invoice(){
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    if(strpos($url, 'invoice') !== false || strpos($url, 'generate.php') !== false || strpos($url, 'add_items.php') !== false){ 
        echo 'a-active'; 
    }
}

function active_dash(){
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    if(strpos($url, 'index.php') !== false){ 
        echo 'a-active'; 
    }
}

function active_product(){
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    if(strpos($url, 'product.php') !== false){ 
        echo 'a-active'; 
    }
}



?>
<div class="col menu">
    <div class="logo-container"><i class="fas fa-times menu-close-icon"></i> Bit<span class="blue-color">Invo</span></div>
    <div class="menu-container">
        <ul>
            <li><a href="index.php" class="<?php active_dash(); ?>"><i class="fas fa-palette"></i> Dashboard</a></li>
            <li><a href="invoice.php" class="<?php active_invoice(); ?>"><i class="fas fa-print"></i> Invoice</a></li>
            <li><a href="product.php" class="<?php active_product(); ?>"><i class="fas fa-weight-hanging"></i> Product</a></li>
            <li><a href="customers.php"><i class="fas fa-portrait"></i> Customers</a></li>
            <li><a href="user.php"><i class="fas fa-user"></i> Account</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
        </ul>
    </div>
</div>