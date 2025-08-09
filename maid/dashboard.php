<?php
include('includes/dbconnection.php');

// Check if maidId exists in the URL
$maidId = $_GET['maidId'] ?? null;
if (!$maidId) {
    header('location:login.php'); // Redirect to login if maidId is missing
    exit;
}

if (isset($_POST['updateStatus'])) {
    $orderId = $_POST['orderId'];
    $status = $_POST['status'];
    $table = $_POST['table'];

    try {
        if ($table === 'tblgrocerybooking') {
            $sqlUpdate = "UPDATE tblgrocerybooking SET Status = :status WHERE ID = :orderId";
        } elseif ($table === 'tblmaidbooking') {
            $sqlUpdate = "UPDATE tblmaidbooking SET Status = :status WHERE ID = :orderId";
        }

        $queryUpdate = $dbh->prepare($sqlUpdate);
        $queryUpdate->bindParam(':status', $status, PDO::PARAM_STR);
        $queryUpdate->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $queryUpdate->execute();

        echo '<script>alert("Order status updated successfully.")</script>';
    } catch (PDOException $e) {
        echo '<script>alert("Error: ' . $e->getMessage() . '")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Maid Dashboard</title>
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
                                <h2>Dashboard</h2>
                            </div>
                        </div>
                    </div>

                    <!-- Grocery Orders Table -->
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-md-12">
                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <h2>Grocery Orders</h2>
                                    </div>
                                </div>
                                <div class="table_section padding_infor_info">
                                    <div class="table-responsive-lg">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Customer Name</th>
                                                    <th>Phone Number</th>
                                                    <th>Delivery Address</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sqlGrocery = "SELECT * FROM tblgrocerybooking WHERE AssignTo = :maidId AND Status = 'HandOverTo'";
                                                $queryGrocery = $dbh->prepare($sqlGrocery);
                                                $queryGrocery->bindParam(':maidId', $maidId, PDO::PARAM_STR);
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
                                                    <td><?php echo htmlentities($row->Status); ?></td>
                                                    <td>
                                                        <form method="post" class="text-center">
                                                            <input type="hidden" name="orderId" value="<?php echo $row->ID; ?>">
                                                            <input type="hidden" name="table" value="tblgrocerybooking">
                                                            <select name="status" class="form-control form-control-sm">
                                                                <option value="Completed">Completed</option>
                                                                <option value="Cancelled">Cancelled</option>
                                                            </select>
                                                            <button type="submit" name="updateStatus" class="btn btn-primary btn-sm mt-2">Update</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php }
                                                } else {
                                                    echo '<tr><td colspan="6">No Grocery Orders Found</td></tr>';
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Maid Orders Table -->
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
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Booking ID</th>
                                                    <th>Name</th>
                                                    <th>Mobile Number</th>
                                                    <th>Email</th>
                                                    <th>Address</th>
                                                    <th>Category</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sqlMaid = "SELECT m.*, c.CategoryName 
                                                    FROM tblmaidbooking m 
                                                    LEFT JOIN tblcategory c ON m.CatID = c.ID 
                                                    WHERE m.AssignTo = :maidId AND m.Status = 'Approved';
                                                    ";
                                                                                                    $queryMaid = $dbh->prepare($sqlMaid);
                                                $queryMaid->bindParam(':maidId', $maidId, PDO::PARAM_STR);
                                                $queryMaid->execute();
                                                $maidResults = $queryMaid->fetchAll(PDO::FETCH_OBJ);

                                                if ($queryMaid->rowCount() > 0) {
                                                    foreach ($maidResults as $row) {
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlentities($row->BookingID); ?></td>
                                                    <td><?php echo htmlentities($row->Name); ?></td>
                                                    <td><?php echo htmlentities($row->ContactNumber); ?></td>
                                                    <td><?php echo htmlentities($row->Email); ?></td>
                                                    <td><?php echo htmlentities($row->Address); ?></td>
                                                    <td><?php echo htmlentities($row->CategoryName); ?></td>
                                                    <td><?php echo htmlentities($row->Status); ?></td>
                                                    <td>
                                                        <form method="post" class="text-center">
                                                            <input type="hidden" name="orderId" value="<?php echo $row->ID; ?>">
                                                            <input type="hidden" name="table" value="tblmaidbooking">
                                                            <select name="status" class="form-control form-control-sm ">
                                                                <option value="Completed">Completed</option>
                                                                <option value="Cancelled">Cancelled</option>
                                                            </select>
                                                            <button type="submit" name="updateStatus" class="btn btn-primary btn-sm mt-2">Update</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php }
                                                } else {
                                                    echo '<tr><td colspan="7">No Maid Bookings Found</td></tr>';
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
