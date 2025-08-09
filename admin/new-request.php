<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['mhmsaid'] == 0)) {
    header('location:logout.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>New Requests</title>
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

            <!-- Main Content -->
            <div class="midde_cont">
                <div class="container-fluid">
                    <div class="row column_title">
                        <div class="col-md-12">
                            <div class="page_title">
                                <h2>New Requests</h2>
                            </div>
                        </div>
                    </div>

                    <!-- New Maid Booking Requests -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <h2>New Maid Booking Requests</h2>
                                    </div>
                                </div>
                                <div class="table_section padding_infor_info">
                                    <div class="table-responsive-sm">
                                        <table class="table table-bordered">
                                            <thead class="table-dark thead-dark thead-sm thead-light thead-default thead-md thead-xs">
                                                
                                                    <strong>
                                                    <th>#</th>
                                                    <th>Booking ID</th>
                                                    <th>Name</th>
                                                    <th>Mobile Number</th>
                                                    <th>Email</th>
                                                    <th>Category</th>
                                                    <th>Booking Date</th>
                                                    <th>Status</th>
                                                    <th>Assign To</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT m.*, c.CategoryName 
                                                FROM tblmaidbooking m 
                                                LEFT JOIN tblcategory c ON m.CatID = c.ID 
                                                WHERE m.Status IS NULL";
                                                
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) {
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($row->BookingID); ?></td>
                                                    <td><?php echo htmlentities($row->Name); ?></td>
                                                    <td><?php echo htmlentities($row->ContactNumber); ?></td>
                                                    <td><?php echo htmlentities($row->Email); ?></td>
                                                    <td><?php echo htmlentities($row->CategoryName); ?></td>
                                                    <td><?php echo htmlentities($row->BookingDate); ?></td>
                                                    <td><?php echo $row->Status ? htmlentities($row->Status) : "Not Updated Yet"; ?></td>
                                                    <td><?php echo $row->AssignTo ? htmlentities($row->AssignTo) : "Not Assigned Yet"; ?></td>
                                                    <td>
                                                        <a href="view-booking-detail.php?editid=<?php echo htmlentities($row->ID); ?>&&bookingid=<?php echo htmlentities($row->BookingID); ?>" class="btn btn-primary btn-sm">View Details</a>
                                                    </td>
                                                </tr>
                                                <?php $cnt++; }} else { ?>
                                                <tr>
                                                    <td colspan="9" class="text-center">No New Maid Booking Requests Found</td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- New Grocery Booking Requests -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <h2>New Grocery Booking Requests</h2>
                                    </div>
                                </div>
                                <div class="table_section padding_infor_info">
                                    <div class="table-responsive-sm">
                                        <table class="table table-bordered">
                                        <thead class="table-dark thead-dark thead-sm thead-light thead-default thead-md thead-xs">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Order ID</th>
                                                    <th>Customer Name</th>
                                                    <th>Phone Number</th>
                                                    <th>Delivery Address</th>
                                                    <th>Order Details</th>
                                                    <th>Delivery Time</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM tblgrocerybooking WHERE Status IS NULL AND AssignTo IS NULL";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) {
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($row->ID); ?></td>
                                                    <td><?php echo htmlentities($row->UserName); ?></td>
                                                    <td><?php echo htmlentities($row->PhoneNumber); ?></td>
                                                    <td><?php echo htmlentities($row->FullArea); ?></td>
                                                    <td><?php echo htmlentities($row->OrderDetails); ?></td>
                                                    <td><?php echo htmlentities($row->DeliveryTime); ?></td>
                                                    <td>
                                                        <a href="view-grocery-order-details.php?editid=<?php echo htmlentities($row->ID); ?>" class="btn btn-primary btn-sm">View Details</a>
                                                    </td>
                                                </tr>
                                                <?php $cnt++; }} else { ?>
                                                <tr>
                                                    <td colspan="8" class="text-center">No New Grocery Booking Requests Found</td>
                                                </tr>
                                                <?php } ?>
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
