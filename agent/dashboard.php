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
    <title>Maid Hiring Management System || Agent Dashboard</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/colors.css" />
    <link rel="stylesheet" href="css/bootstrap-select.css" />
    <link rel="stylesheet" href="css/perfect-scrollbar.css" />
    <link rel="stylesheet" href="css/custom.css" />
</head>
<body class="dashboard dashboard_1">
<div class="full_container">
    <div class="inner_container">
        <!-- Sidebar  -->
        <?php include_once('includes/sidebar.php'); ?>
        <!-- end sidebar -->
        <!-- right content -->
        <div id="content">
            <!-- topbar -->
            <?php include_once('includes/header.php'); ?>
            <!-- end topbar -->
            <!-- dashboard inner -->
            <div class="midde_cont">
                <div class="container-fluid">
                    <div class="row column_title">
                        <div class="col-md-12">
                            <div class="page_title">
                                <h2>Agent Dashboard</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row column1 mx-5">
                        <div class="col-md-6 col-lg-6">
                            <div class="full counter_section margin_bottom_30">
                                <div class="couter_icon">
                                    <div>
                                        <i class="fa fa-files-o purple_color"></i>
                                    </div>
                                </div>
                                <div class="counter_no d-flex align-items-center justify-content-center">
                                    <div>
                                        <?php
                                        $sql1 = "SELECT * FROM tblgrocerybooking Where Status='Approved'";
                                        $query1 = $dbh->prepare($sql1);
                                        $query1->execute();
                                        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                        $totBookings = $query1->rowCount();
                                        ?>
                                        <p class="total_no"><?php echo htmlentities($totBookings); ?></p>
                                        <p class="head_couter">Pending Grocery Orders<br /><br />
                                            <a href="manage-grocery-orders.php" class="btn btn-primary btn-sm">View Details</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="full counter_section margin_bottom_30">
                                <div class="couter_icon">
                                    <div>
                                        <i class="fa fa-users yellow_color"></i>
                                    </div>
                                </div>
                                <div class="counter_no d-flex align-items-center justify-content-center">
                                    <div>
                                        <?php
                                        $sql2 = "SELECT * FROM tblmaid";
                                        $query2 = $dbh->prepare($sql2);
                                        $query2->execute();
                                        $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                                        $totMaids = $query2->rowCount();
                                        ?>
                                        <p class="total_no"><?php echo htmlentities($totMaids); ?></p>
                                        <p class="head_couter">Listed Maids<br /><br />
                                            <a href="manage-maids.php" class="btn btn-primary btn-sm">View Details</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row column2 mx-5">
                        <div class="col-md-6 col-lg-6">
                            <div class="full counter_section margin_bottom_30">
                                <div class="couter_icon">
                                    <div>
                                        <i class="fa fa-files-o green_color"></i>
                                    </div>
                                </div>
                                <div class="counter_no d-flex align-items-center justify-content-center">
                                    <div>
                                        <?php
                                        $sql3 = "SELECT * FROM tblgrocerybooking WHERE Status='HandOverTo'";
                                        $query3 = $dbh->prepare($sql3);
                                        $query3->execute();
                                        $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                                        $completedBookings = $query3->rowCount();
                                        ?>
                                        <p class="total_no"><?php echo htmlentities($completedBookings); ?></p>
                                        <p class="head_couter">Completed Requests<br /><br />
                                            <a href="completed-grocery-orders.php" class="btn btn-primary btn-sm">View Details</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="full counter_section margin_bottom_30">
                                <div class="couter_icon">
                                    <div>
                                        <i class="fa fa-files-o red_color"></i>
                                    </div>
                                </div>
                                <div class="counter_no d-flex align-items-center justify-content-center">
                                    <div>
                                        <?php
                                        $sql4 = "SELECT * FROM tblgrocerybooking WHERE  Status='Cancelled'";
                                        $query4 = $dbh->prepare($sql4);
                        
                                        $query4->execute();
                                        $results4 = $query4->fetchAll(PDO::FETCH_OBJ);
                                        $cancelledBookings = $query4->rowCount();
                                        ?>
                                        <p class="total_no"><?php echo htmlentities($cancelledBookings); ?></p>
                                        <p class="head_couter">Cancelled Requests<br /><br />
                                            <a href="cancelled-grocery-orders.php" class="btn btn-primary btn-sm">View Details</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- footer -->
                <?php include_once('includes/footer.php'); ?>
            </div>
            <!-- end dashboard inner -->
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/animate.js"></script>
<script src="js/bootstrap-select.js"></script>
<script src="js/perfect-scrollbar.min.js"></script>
<script>
    var ps = new PerfectScrollbar('#sidebar');
</script>
<script src="js/custom.js"></script>
</body>
</html>
<?php } ?>