<?php
//Left Angle
if(isset($_GET['page']) && $_GET['page'] != 1){
    $prev_page = $_GET['page'] - 1;
?>
    <a href="add_items?page=<?php echo $prev_page ?>">Prev</a>

<?php
}
?>

<?php
//Page Numbers
for($page = 1; $page <= $total_page_num; $page++){
    if($num > 0){
?>
    <a href="add_items?page=<?php echo $page ?>" class="<?php if($_GET['page'] == $page){ echo 'active'; }?>"><?php echo $page ?></a>
<?php    
    }
}
?>

<?php
if(isset($_GET['page']) && $_GET['page'] != $total_page_num){
    $next_page = $_GET['page'] + 1;
?>
    <a href="add_items?page=<?php echo $next_page ?>">Next</a>
<?php
}
?>