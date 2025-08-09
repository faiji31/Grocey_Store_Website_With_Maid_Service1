<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['mhmsaid'] == 0)) {
    header('location:logout.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Completed Orders</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
</head>
<body class="dashboard dashboard_1">
<div class="full_container">
    <div class="inner_container">
        <?php include_once('includes/sidebar.php'); ?>
        <div id="content">
            <?php include_once('includes/header.php'); ?>
            <div class="midde_cont">
                <div class="container-fluid">
                    <div class="row column_title">
                        <div class="col-md-12">
                            <div class="page_title">
                                <h2>Completed Orders</h2>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Orders from tblgrocerybooking -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <h2>Grocery Orders</h2>
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
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sqlGrocery = "SELECT * FROM tblgrocerybooking WHERE Status = 'Completed'";
                                                $queryGrocery = $dbh->prepare($sqlGrocery);
                                                $queryGrocery->execute();
                                                $groceryResults = $queryGrocery->fetchAll(PDO::FETCH_OBJ);

                                                if ($queryGrocery->rowCount() > 0) {
                                                    foreach ($groceryResults as $row) {
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlentities($row->ID); ?></td>
                                                    <td><?php echo htmlentities($row->UserName); ?></td>
                                                    <td><?php echo htmlentities($row->PhoneNumber); ?></td>
                                                    <td><?php echo htmlentities($row->FullArea); ?></td>
                                                    <td><?php echo htmlentities($row->OrderDetails); ?></td>
                                                    <td><?php echo htmlentities($row->Status); ?></td>
                                                </tr>
                                                <?php }
                                                } else {
                                                    echo '<tr><td colspan="6">No Completed Grocery Orders Found</td></tr>';
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Orders from tblmaidbooking -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <h2>Maid Bookings</h2>
                                    </div>
                                </div>
                                <div class="table_section padding_infor_info">
                                    <div class="table-responsive-sm">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Booking ID</th>
                                                    <th>Name</th>
                                                    <th>Mobile Number</th>
                                                    <th>Email</th>
                                                    <th>Address</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sqlMaid = "SELECT * FROM tblmaidbooking WHERE Status = 'Completed'";
                                                $queryMaid = $dbh->prepare($sqlMaid);
                                                $queryMaid->execute();
                                                $maidResults = $queryMaid->fetchAll(PDO::FETCH_OBJ);

                                                if ($queryMaid->rowCount() > 0) {
                                                    foreach ($maidResults as $row) {
                                                ?>
                                                <tr class="text-success">
                                                    <td><b><?php echo htmlentities($row->BookingID); ?></b></td>
                                                    <td><b><?php echo htmlentities($row->Name); ?></b></td>
                                                    <td><b><?php echo htmlentities($row->ContactNumber); ?></b></td>
                                                    <td><b><?php echo htmlentities($row->Email); ?></b></td>
                                                    <td><b><?php echo htmlentities($row->Address); ?></b></td>
                                                    <td><b><?php echo htmlentities($row->Status); ?></b></td>
                                                </tr>
                                                <?php }
                                                } else {
                                                    echo '<tr><td colspan="6">No Completed Maid Bookings Found</td></tr>';
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>
