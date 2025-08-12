<?php
session_start();
include('includes/dbconnection.php');
if (strlen($_SESSION['mhmsaid'] == 0)) {
    header('location:logout.php');
} else {
    // Fetch data for the chart from tblmaidbooking
    $sqlMaid = "SELECT c.CategoryName, COUNT(m.ID) as RequestCount 
                FROM tblmaidbooking m
                JOIN tblcategory c ON m.CatID = c.ID
                GROUP BY c.CategoryName";
    $queryMaid = $dbh->prepare($sqlMaid);
    $queryMaid->execute();
    $maidResults = $queryMaid->fetchAll(PDO::FETCH_OBJ);

    // Fetch data for the chart from tblgrocerybooking
    $sqlGrocery = "SELECT 'Grocery Orders' as CategoryName, COUNT(ID) as RequestCount 
                   FROM tblgrocerybooking 
                   WHERE Status = 'Completed' OR Status = 'Approved' 
                   GROUP BY CategoryName";
    $queryGrocery = $dbh->prepare($sqlGrocery);
    $queryGrocery->execute();
    $groceryResults = $queryGrocery->fetchAll(PDO::FETCH_OBJ);

    $categories = [];
    $counts = [];

    // Combine the results from both tables
    foreach ($maidResults as $row) {
        $categories[] = $row->CategoryName;
        $counts[] = $row->RequestCount;
    }

    foreach ($groceryResults as $row) {
        $categories[] = $row->CategoryName;
        $counts[] = $row->RequestCount;
    }

    // Query for completed orders
    $sqlCompletedMaid = "SELECT * FROM tblmaidbooking WHERE Status = 'Completed'";
    $queryCompletedMaid = $dbh->prepare($sqlCompletedMaid);
    $queryCompletedMaid->execute();
    $completedMaidOrders = $queryCompletedMaid->rowCount();

    $sqlCompletedGrocery = "SELECT * FROM tblgrocerybooking WHERE Status = 'Completed'";
    $queryCompletedGrocery = $dbh->prepare($sqlCompletedGrocery);
    $queryCompletedGrocery->execute();
    $completedGroceryOrders = $queryCompletedGrocery->rowCount();

    $totalCompletedOrders = $completedMaidOrders + $completedGroceryOrders;

    // Fetch orders by area
    $sqlOrdersByArea = "SELECT AreaName, COUNT(*) as TotalOrders
        FROM (
            SELECT AreaName FROM tblmaidbooking
            UNION ALL
            SELECT AreaName FROM tblgrocerybooking
        ) AS CombinedOrders
        GROUP BY AreaName";
    $queryOrdersByArea = $dbh->prepare($sqlOrdersByArea);
    $queryOrdersByArea->execute();
    $areaResults = $queryOrdersByArea->fetchAll(PDO::FETCH_OBJ);

    $areaNames = [];
    $orderCounts = [];

    foreach ($areaResults as $row) {
        $areaNames[] = $row->AreaName;
        $orderCounts[] = $row->TotalOrders;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Grocery Store and Maid Service Website || Dashboard</title>
      <link rel="stylesheet" href="css/bootstrap.min.css" />
      <link rel="stylesheet" href="style.css" />
      <link rel="stylesheet" href="css/responsive.css" />
      <link rel="stylesheet" href="css/colors.css" />
      <link rel="stylesheet" href="css/bootstrap-select.css" />
      <link rel="stylesheet" href="css/perfect-scrollbar.css" />
      <link rel="stylesheet" href="css/custom.css" />
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <style>
    .card3 {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin: 20px 0; /* Center vertically with space at the top and bottom */
        width: 100%; /* Take full width of the container */
        max-width: none; 
        /* Remove any width restrictions */
        background-color: #fff;
    }
    .card3-header {
        font-size: 1.25em;
        font-weight: bold;
        margin-bottom: 10px;
        text-align: center; /* Optional: Center align the header */
    }
    .card3-body {
        position: relative;
    }
</style>


   </head>
   <body class="dashboard dashboard_1">
      <div class="full_container">
         <div class="inner_container">
            <?php include_once('includes/sidebar.php');?>
            <div id="content">
               <?php include_once('includes/header.php');?>
               <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Dashboard</h2>
                           </div>
                        </div>
                     </div>

                     <div class="row column1">
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-file purple_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <?php 
                                    $sql1 ="SELECT * from tblcategory";
                                    $query1 = $dbh -> prepare($sql1);
                                    $query1->execute();
                                    $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                                    $totcat=$query1->rowCount();
                                    ?>
                                    <p class="total_no"><?php echo htmlentities($totcat);?></p>
                                    <p class="head_couter">Total Category<br /><br />
                                       <a href="manage-category.php" class="btn btn-primary btn-sm">View Details</a></p>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-users yellow_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <?php 
                                    $sql2 ="SELECT * from tblmaid";
                                    $query2 = $dbh -> prepare($sql2);
                                    $query2->execute();
                                    $results2=$query2->fetchAll(PDO::FETCH_OBJ);
                                    $totmaid=$query2->rowCount();
                                    ?>
                                   <p class="total_no"><?php echo htmlentities($totmaid);?></p>
                                    <p class="head_couter">Listed Maids<br /><br />
                                       <a href="manage-maid.php" class="btn btn-primary btn-sm">View Details</a></p>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-files-o yellow_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                     <?php 
                                    $sql3 ="SELECT * from tblmaidbooking where Status='' || Status is null";
                                    $query3 = $dbh -> prepare($sql3);
                                    $query3->execute();
                                    $results3=$query3->fetchAll(PDO::FETCH_OBJ);
                                    $newreq=$query3->rowCount();
                                    ?>
                                   <p class="total_no"><?php echo htmlentities($newreq);?></p>
                                    <p class="head_couter">New Request<br /><br />

                                       <a href="new-request.php" class="btn btn-primary btn-sm">View Details</a></p>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-files-o green_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <?php 
                                    $sql4 ="SELECT * from tblmaidbooking where Status='Approved'";
                                    $query4 = $dbh -> prepare($sql4);
                                    $query4->execute();
                                    $results4=$query4->fetchAll(PDO::FETCH_OBJ);
                                    $assreq=$query4->rowCount();
                                    ?>
                                   <p class="total_no"><?php echo htmlentities($assreq);?></p>
                                    <p class="head_couter">Assign Request<br /><br />
                                       <a href="assign-request.php" class="btn btn-primary btn-sm">View Detail</a></p>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-files-o red_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                     <?php 
                                    $sql3 ="SELECT * from tblmaidbooking where Status='Cancelled'";
                                    $query3 = $dbh -> prepare($sql3);
                                    $query3->execute();
                                    $results3=$query3->fetchAll(PDO::FETCH_OBJ);
                                    $canreq=$query3->rowCount();
                                    ?>
                                   <p class="total_no"><?php echo htmlentities($canreq);?></p>
                                    <p class="head_couter">Canceled / Rejected Requests<br /><br />

                                       <a href="cancel-request.php" class="btn btn-primary btn-sm">View Details</a></p>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-files-o purple_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <?php 
                                    $sql4 ="SELECT * from tblmaidbooking ";
                                    $query4 = $dbh -> prepare($sql4);
                                    $query4->execute();
                                    $results4=$query4->fetchAll(PDO::FETCH_OBJ);
                                    $totreq=$query4->rowCount();
                                    ?>
                                   <p class="total_no"><?php echo htmlentities($totreq);?></p>
                                    <p class="head_couter">Total Request<br /><br /><br />
                                       <a href="all-request.php" class="btn btn-primary btn-sm">View Details</a></p>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div>
                                    <i class="fa fa-check-circle green_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?php echo htmlentities($totalCompletedOrders); ?></p>
                                    <p class="head_couter">Completed Orders<br /><br />
                                       <a href="completed-orders.php" class="btn btn-primary btn-sm">View Details</a>
                                    </p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                         <!-- Line Chart -->
                  
                     <div class="card3">
                        <div class="card3-header">
                              Daily Orders Chart
                        </div>
                        <div class="card3-body">
                              <canvas id="dailyOrdersChart" width="600" height="120"></canvas>
                        </div>
                     </div>
                 

 
              



                     <!-- 2 charts in a row Section -->
                     <div class="row column1">
                        <div class="col-md-6"> 
                           <div class="white_shd full margin_bottom_30" style="height: 450px;">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Service-Wise Distribution</h2>
                                 </div>
                              </div>
                              <div style="width: 100%; height: 350px; margin: 0 auto;">
                                 <canvas id="serviceDistributionChart"></canvas>
                              </div>
                           </div>
                        </div>

                        <div class="col-md-6">
                           <div class="white_shd full margin_bottom_30" style="height: 450px;">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Orders by Area</h2>
                                 </div>
                              </div>
                              <div style="width: 100%; height: 350px; margin: 0 auto;">
                                 <canvas id="ordersByAreaChart"></canvas>
                              </div>
                           </div>
                        </div>
                     </div>
                 
                  </div>
               </div>
            </div>
         </div>
      </div>
      

      <?php include_once('includes/footer.php'); ?>

      <script>
         document.addEventListener("DOMContentLoaded", function () {
             // Service-Wise Distribution Chart
             const ctxService = document.getElementById('serviceDistributionChart').getContext('2d');
             new Chart(ctxService, {
                 type: 'pie',
                 data: {
                     labels: <?php echo json_encode($categories); ?>,
                     datasets: [{
                         data: <?php echo json_encode($counts); ?>,
                         backgroundColor: [
                             'rgba(255, 99, 132, 0.2)',
                             'rgba(54, 162, 235, 0.2)',
                             'rgba(255, 206, 86, 0.2)',
                             'rgba(75, 192, 192, 0.2)',
                             'rgba(153, 102, 255, 0.2)',
                             'rgba(255, 159, 64, 0.2)'
                         ],
                         borderColor: [
                             'rgba(255, 99, 132, 1)',
                             'rgba(54, 162, 235, 1)',
                             'rgba(255, 206, 86, 1)',
                             'rgba(75, 192, 192, 1)',
                             'rgba(153, 102, 255, 1)',
                             'rgba(255, 159, 64, 1)'
                         ],
                         borderWidth: 1
                     }]
                 },
                 options: {
                     responsive: true,
                     maintainAspectRatio: false,
                     plugins: {
                         legend: {
                             display: true,
                             position: 'top'
                         }
                     }
                 }
             });

             // Orders by Area Chart
             const ctxArea = document.getElementById('ordersByAreaChart').getContext('2d');
             new Chart(ctxArea, {
                 type: 'bar',
                 data: {
                     labels: <?php echo json_encode($areaNames); ?>,
                     datasets: [{
                         label: 'Total Orders',
                         data: <?php echo json_encode($orderCounts); ?>,
                         backgroundColor: 'rgba(192, 128, 75, 0.6)',
                         borderColor: 'rgb(224, 93, 60)',
                         borderWidth: 1
                     }]
                 },
                 options: {
                     responsive: true,
                     plugins: {
                         legend: {
                             display: true
                         }
                     },
                     scales: {
                         x: {
                             title: {
                                 display: true,
                                 text: 'Area Name'
                             }
                         },
                         y: {
                             title: {
                                 display: true,
                                 text: 'Number of Orders'
                             },
                             beginAtZero: true
                         }
                     }
                 }
             });

          // Line chart 
const ctxDaily = document.getElementById('dailyOrdersChart').getContext('2d');
new Chart(ctxDaily, {
    type: 'line',
    data: {
        labels: [
            '2025-08-01', '2025-08-02', '2025-08-03', '2025-08-04', '2025-08-05',
            '2025-08-06', '2025-08-07', '2025-08-08', '2025-08-09', '2025-08-10',
            '2025-08-11', '2025-08-12', '2025-08-13', '2025-08-14', '2025-08-15'
        ], // 15 days
        datasets: [{
            label: 'Daily Orders',
            data: [5, 8, 4, 10, 7, 9, 6, 12, 5, 14, 8, 11, 6, 13, 7], // Data with ups and downs
            backgroundColor: 'rgba(224, 27, 27, 0.57)',
            borderColor: 'rgba(192, 43, 26, 0.77)',
            borderWidth: 2,
            fill: false
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Day of Month'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Number of Orders'
                },
                beginAtZero: true
            }
        }
    }
});


        
           
            

         });
      </script>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/animate.js"></script>
      <script src="js/bootstrap-select.js"></script>
      <script src="js/perfect-scrollbar.min.js"></script>
      <script src="js/custom.js"></script>
   </body>
</html>
