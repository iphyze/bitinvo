<?php
    include_once('includes/connection.php');
    include_once('includes/functions.php');
    session_start();

    if(!isset($_SESSION['username']) || $_SESSION['username'] == ''){
        header('location:login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        
        <!-- Css assets Menu -->
        <?php 
            include_once('includes/head.php');
        ?>
        
        <title>Invoicing</title>
    </head>

<body>
    
    <div class="whole-container">
        
        <div class="container-flex-box">
            
            <!-- Dashboard Menu -->
            <?php 
                include_once('includes/dashboard_menu.php');
            ?>  
            
            <div class="col overview">
                
                <!-- Dashboard Header -->
                <?php 
                    include_once('includes/dashboard_header.php');
                ?>
                
                <div class="area-one">
                        <p class="ao-title">Dashboard</p>
                        <p class="ao-subtitle">Invoice Analytics</p>
                </div>
                
                <div class="area-two">
                    <div class="area-two-menu a-2-m">
                        <a href="./" class="<?php if(!isset($_GET['view'])){echo 'active-home-link'; }?>">Invoices</a>
                        <a href="index.php?view=sales" class="<?php if(isset($_GET['view']) && $_GET['view'] == 'sales'){echo 'active-home-link'; }?>">Sales</a>
                        <a href="index.php?view=products" class="<?php if(isset($_GET['view']) && $_GET['view'] == 'products'){echo 'active-home-link'; }?>">Products</a>
                    </div>
                    
                    
                    <?php
                        if(!isset($_GET['view'])){
                    ?>
                    <div class="area-two-overview">
                        <div class="area-two-overview-col">
                            <p class="atoc-title">Total Invoices</p>
                            <p class="atoc-number"><?php get_total_invoices(); ?></p>
                        </div>
                        <div class="area-two-overview-col">
                            <p class="atoc-title">Cleared Invoices</p>
                            <p class="atoc-number"><?php get_total_cleared_invoices(); ?></p>
                        </div>
                        <div class="area-two-overview-col">
                            <p class="atoc-title">Uncleared Invoices</p>
                            <p class="atoc-number"><?php get_total_uncleared_invoices(); ?></p>
                        </div>
                        <div class="area-two-overview-col">
                            <p class="atoc-title">Total Sales (₦)</p>
                            <p class="atoc-number"><?php get_amount_invoices_sold(); ?></p>
                        </div>
                    </div>
                    <?php
                      }      
                    ?>
                    
                    
                    
                    <?php
                        if(isset($_GET['view']) && $_GET['view'] == 'sales'){
                    ?>
                    <div class="area-two-overview at-customers">
                        <div class="area-two-overview-col">
                            <p class="atoc-title">Today (₦)</p>
                            <p class="atoc-number"><?php get_daily_sales_total(); ?></p>
                        </div>
                        <div class="area-two-overview-col">
                            <p class="atoc-title">This Week (₦)</p>
                            <p class="atoc-number"><?php get_weekly_sales_total(); ?></p>
                        </div>
                        <div class="area-two-overview-col">
                            <p class="atoc-title">This Month (₦)</p>
                            <p class="atoc-number"><?php get_monthly_sales_total(); ?></p>
                        </div>
                        <div class="area-two-overview-col">
                            <p class="atoc-title">This Year (₦)</p>
                            <p class="atoc-number"><?php get_yearly_sales_total(); ?></p>
                        </div>
                    </div>
                    <?php
                      }      
                    ?>
                    
                    
                    <?php
                        if(isset($_GET['view']) && $_GET['view'] == 'products'){
                    ?>
                    <div class="area-two-overview at-products">
                        <div class="area-two-overview-col">
                            <p class="atoc-title">Total Customers</p>
                            <p class="atoc-number">20</p>
                        </div>
                        <div class="area-two-overview-col">
                            <p class="atoc-title">Total Purchase Orders</p>
                            <p class="atoc-number">2,025</p>
                        </div>
                        <div class="area-two-overview-col">
                            <p class="atoc-title">Total Uncleared</p>
                            <p class="atoc-number">8,025</p>
                        </div>
                        <div class="area-two-overview-col">
                            <p class="atoc-title">Total Invoices</p>
                            <p class="atoc-number">5,645</p>
                        </div>
                    </div>
                    <?php
                      }      
                    ?>
                    
                </div>
                
                
                
                <div class="area-one area-one-box">
                    <p class="ao-title">Overview</p>
                    <p class="ao-subtitle">Invoice Analytics</p>
                    
                    <div class="charts-container">
                        <canvas id="myChart">
                            <?php include_once('includes/chart_data.php'); ?>
                        </canvas>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
    </div>
    
</body>

    
    
<script type="text/javascript" src="assets/js/style.js"></script>
<script type="text/javascript" src="assets/js/libraries/wow.min.js"></script>
<!--<script type="text/javascript" src="assets/js/init_chart.js"></script>-->
<script>
const labels = <?php echo json_encode($months); ?>;
const figure = <?php echo json_encode($figure); ?>;
const data = {
labels: labels,
datasets: [{
    type: 'bar',
    label: 'Monthly Invoice Sales',
    data: figure,
    barPercentage: 1,
    barThickness: 50,
    maxBarThickness: 50,
    minBarLength: 2,
    borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(54, 162, 235)',
      'rgb(153, 102, 255)',
      'rgb(201, 203, 207)'
    ],
     backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(201, 203, 207, 0.2)'
    ],
     borderWidth: 1
  }, {
    type: 'line',
    label: 'points',
    data: figure,
    fill: false,
    borderColor: 'rgb(54, 162, 235)'
  }],
};
    

const config = {
  type: 'scatter',
  data: data,
  options: {
    scales: {
      y: {
            beginAtZero: true,
            ticks: {
                display: false,
                min: 0,
                stepSize: 20,
            },
            grid: {
                drawBorder: false,
                color: 'rgba(255,255,255,1)',
                zeroLineColor: 'rgba(235,237,242,1)'
            }
      }
    }
  }
};

const myChart = new Chart(
document.getElementById('myChart'),
    config
);
</script>
<script>
new WOW().init();
</script>
</html>