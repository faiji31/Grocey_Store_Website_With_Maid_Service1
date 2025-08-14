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

   <script src="https://cdn.tailwindcss.com"></script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


   </head>
   <body class="dashboard dashboard_1">
      <div class="flex min-h-screen bg-gray-100">
         <?php include_once('includes/sidebar.php');?>
         <div class="flex-1 flex flex-col">
            <?php include_once('includes/header.php');?>
            <main class="flex-1 p-6 md:p-10">
               <h2 class="text-3xl font-bold text-green-700 mb-8">Dashboard</h2>
               <!-- Stats Cards -->
               <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                  <!-- Total Category -->
                  <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                     <div class="text-purple-500 mb-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                     </div>
                     <?php 
                        $sql1 ="SELECT * from tblcategory";
                        $query1 = $dbh -> prepare($sql1);
                        $query1->execute();
                        $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                        $totcat=$query1->rowCount();
                     ?>
                     <p class="text-3xl font-bold text-gray-800"><?php echo htmlentities($totcat);?></p>
                     <p class="text-gray-500">Total Category</p>
                     <a href="manage-category.php" class="mt-2 text-green-700 hover:underline">View Details</a>
                  </div>
                  <!-- Listed Maids -->
                  <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                     <div class="text-yellow-500 mb-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                     </div>
                     <?php 
                        $sql2 ="SELECT * from tblmaid";
                        $query2 = $dbh -> prepare($sql2);
                        $query2->execute();
                        $results2=$query2->fetchAll(PDO::FETCH_OBJ);
                        $totmaid=$query2->rowCount();
                     ?>
                     <p class="text-3xl font-bold text-gray-800"><?php echo htmlentities($totmaid);?></p>
                     <p class="text-gray-500">Listed Maids</p>
                     <a href="manage-maid.php" class="mt-2 text-green-700 hover:underline">View Details</a>
                  </div>
                  <!-- New Request -->
                  <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                     <div class="text-yellow-500 mb-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/></svg>
                     </div>
                     <?php 
                        $sql3 ="SELECT * from tblmaidbooking where Status='' || Status is null";
                        $query3 = $dbh -> prepare($sql3);
                        $query3->execute();
                        $results3=$query3->fetchAll(PDO::FETCH_OBJ);
                        $newreq=$query3->rowCount();
                     ?>
                     <p class="text-3xl font-bold text-gray-800"><?php echo htmlentities($newreq);?></p>
                     <p class="text-gray-500">New Request</p>
                     <a href="new-request.php" class="mt-2 text-green-700 hover:underline">View Details</a>
                  </div>
                  <!-- Assign Request -->
                  <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                     <div class="text-green-500 mb-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                     </div>
                     <?php 
                        $sql4 ="SELECT * from tblmaidbooking where Status='Approved'";
                        $query4 = $dbh -> prepare($sql4);
                        $query4->execute();
                        $results4=$query4->fetchAll(PDO::FETCH_OBJ);
                        $assreq=$query4->rowCount();
                     ?>
                     <p class="text-3xl font-bold text-gray-800"><?php echo htmlentities($assreq);?></p>
                     <p class="text-gray-500">Assign Request</p>
                     <a href="assign-request.php" class="mt-2 text-green-700 hover:underline">View Details</a>
                  </div>
                  <!-- Canceled / Rejected Requests -->
                  <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                     <div class="text-red-500 mb-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                     </div>
                     <?php 
                        $sql3 ="SELECT * from tblmaidbooking where Status='Cancelled'";
                        $query3 = $dbh -> prepare($sql3);
                        $query3->execute();
                        $results3=$query3->fetchAll(PDO::FETCH_OBJ);
                        $canreq=$query3->rowCount();
                     ?>
                     <p class="text-3xl font-bold text-gray-800"><?php echo htmlentities($canreq);?></p>
                     <p class="text-gray-500">Canceled / Rejected Requests</p>
                     <a href="cancel-request.php" class="mt-2 text-green-700 hover:underline">View Details</a>
                  </div>
                  <!-- Total Request -->
                  <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                     <div class="text-purple-500 mb-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                     </div>
                     <?php 
                        $sql4 ="SELECT * from tblmaidbooking ";
                        $query4 = $dbh -> prepare($sql4);
                        $query4->execute();
                        $results4=$query4->fetchAll(PDO::FETCH_OBJ);
                        $totreq=$query4->rowCount();
                     ?>
                     <p class="text-3xl font-bold text-gray-800"><?php echo htmlentities($totreq);?></p>
                     <p class="text-gray-500">Total Request</p>
                     <a href="all-request.php" class="mt-2 text-green-700 hover:underline">View Details</a>
                  </div>
                  <!-- Completed Orders -->
                  <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                     <div class="text-green-700 mb-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                     </div>
                     <p class="text-3xl font-bold text-gray-800"><?php echo htmlentities($totalCompletedOrders); ?></p>
                     <p class="text-gray-500">Completed Orders</p>
                     <a href="completed-orders.php" class="mt-2 text-green-700 hover:underline">View Details</a>
                  </div>
               </div>

               <!-- Daily Orders Line Chart -->
               <div class="bg-white rounded-xl shadow p-6 mb-10">
                  <h3 class="text-xl font-bold text-center mb-4">Daily Orders Chart</h3>
                  <div class="overflow-x-auto">
                     <canvas id="dailyOrdersChart" height="120"></canvas>
                  </div>
               </div>

               <!-- 2 charts in a row Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-white rounded-xl shadow p-6 flex flex-col" style="min-height: 420px;">
                            <h3 class="text-xl font-bold mb-4">Service-Wise Distribution</h3>
                            <div class="flex-1 flex items-center justify-center" style="min-height: 350px;">
                                <canvas id="serviceDistributionChart" style="max-height:350px;" height="350"></canvas>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow p-6 flex flex-col" style="min-height: 420px;">
                            <h3 class="text-xl font-bold mb-4">Orders by Area</h3>
                            <div class="flex-1 flex items-center justify-center" style="min-height: 350px;">
                                <canvas id="ordersByAreaChart" style="max-height:350px;" height="350"></canvas>
                            </div>
                        </div>
                    </div>
            </main>
         </div>
      </div>
      

      <?php include_once('includes/footer.php'); ?>

      <script>
         document.addEventListener("DOMContentLoaded", function () {

            // Service-Wise Distribution Chart (Pie)
            const ctxService = document.getElementById('serviceDistributionChart').getContext('2d');
            new Chart(ctxService, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($categories); ?>,
                    datasets: [{
                        data: <?php echo json_encode($counts); ?>,
                        backgroundColor: [
                            '#22c55e', // green
                            '#3b82f6', // blue
                            '#f59e42', // orange
                            '#f43f5e', // rose
                            '#a21caf', // purple
                            '#facc15', // yellow
                            '#0ea5e9', // sky
                            '#eab308', // amber
                        ],
                        borderColor: '#fff',
                        borderWidth: 3,
                        hoverOffset: 16,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: '#334155',
                                font: { size: 16, weight: 'bold' },
                                padding: 20,
                                boxWidth: 24,
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.parsed || 0;
                                    return `${label}: ${value}`;
                                }
                            }
                        },
                        datalabels: {
                            display: true,
                            color: '#222',
                            font: { weight: 'bold', size: 14 },
                            formatter: function(value, context) {
                                return value;
                            }
                        }
                    },
                    layout: {
                        padding: 20
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true
                    }
                },
                plugins: [
                    {
                        id: 'customBorderRadius',
                        afterUpdate: chart => {
                            chart.data.datasets.forEach(dataset => {
                                dataset.borderRadius = 16;
                            });
                        }
                    }
                ]
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
   <!-- No Bootstrap JS needed, Tailwind handles layout -->
   </body>
</html>
