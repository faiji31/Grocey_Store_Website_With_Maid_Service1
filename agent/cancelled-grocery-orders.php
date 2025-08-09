<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['agentid'] == 0)) {
    header('location:logout.php');
} else {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cancelled Grocery Orders</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/colors.css" />
    <link rel="stylesheet" href="css/bootstrap-select.css" />
    <link rel="stylesheet" href="css/perfect-scrollbar.css" />
    <link rel="stylesheet" href="css/custom.css" />
</head>
<body class="inner_page tables_page">
<div class="full_container">
    <div class="inner_container">
        <!-- Sidebar -->
        <?php include_once('includes/sidebar.php'); ?>
        <!-- End Sidebar -->

        <div id="content">
            <!-- Topbar -->
            <?php include_once('includes/header.php'); ?>
            <!-- End Topbar -->

            <!-- Dashboard Content -->
            <div class="midde_cont">
                <div class="container-fluid">
                    <div class="row column_title">
                        <div class="col-md-12">
                            <div class="page_title">
                                <h2>Cancelled Grocery Orders</h2>
                            </div>
                        </div>
                    </div>

                    <!-- Cancelled Orders Table -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <h2>Orders Cancelled</h2>
                                    </div>
                                </div>
                                <div class="table_section padding_infor_info">
                                    <div class="table-responsive-sm">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Customer Name</th>
                                                    <th>Phone Number</th>
                                                    <th>Delivery Address</th>
                                                    <th>Order Details</th>
                                                    <th>Delivery Time</th>
                                                    <th>Status</th>
                                                    <th>Assign To</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM tblgrocerybooking WHERE Status = 'Cancelled'";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) {
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlentities($row->ID); ?></td>
                                                    <td><?php echo htmlentities($row->UserName); ?></td>
                                                    <td><?php echo htmlentities($row->PhoneNumber); ?></td>
                                                    <td><?php echo htmlentities($row->FullArea); ?></td>
                                                    <td><?php echo htmlentities($row->OrderDetails); ?></td>
                                                    <td><?php echo htmlentities($row->DeliveryTime); ?></td>
                                                    <td><?php echo htmlentities($row->Status); ?></td>
                                                    <td><?php echo htmlentities($row->AssignTo); ?></td>
                                                </tr>
                                                <?php
                                                    }
                                                } else {
                                                    echo '<tr><td colspan="8">No cancelled orders found.</td></tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
<?php } ?>
