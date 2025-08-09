<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['agentid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $eid = $_POST['editid'] ?? null;
        $status = $_POST['status'];
        $maidId = $_POST['maid'] ?? null;

        try {
            if ($eid) {
                $assignTo = null;

                if ($status == 'HandOverTo' && $maidId) {
                    // Ensure the MaidId exists in the database
                    $sqlMaid = "SELECT MaidId FROM tblmaid WHERE MaidId = :maidId";
                    $queryMaid = $dbh->prepare($sqlMaid);
                    $queryMaid->bindParam(':maidId', $maidId, PDO::PARAM_STR);
                    $queryMaid->execute();
                    $maid = $queryMaid->fetch(PDO::FETCH_OBJ);

                    if ($maid) {
                        $assignTo = $maidId; // Set AssignTo to the MaidId
                    } else {
                        echo '<script>alert("Invalid Maid selected.")</script>';
                        $assignTo = null;
                    }
                }

                // Update the grocery booking with the new Status and AssignTo
                $sqlUpdate = "UPDATE tblgrocerybooking SET Status = :status, AssignTo = :assignTo WHERE ID = :eid";
                $queryUpdate = $dbh->prepare($sqlUpdate);
                $queryUpdate->bindParam(':status', $status, PDO::PARAM_STR);
                $queryUpdate->bindParam(':assignTo', $assignTo, PDO::PARAM_STR);
                $queryUpdate->bindParam(':eid', $eid, PDO::PARAM_STR);
                $queryUpdate->execute();

                echo '<script>alert("Order status has been updated successfully.")</script>';
                echo "<script>window.location.href ='manage-grocery-orders.php'</script>";
            } else {
                echo '<script>alert("Missing order ID.")</script>';
            }
        } catch (PDOException $e) {
            echo '<script>alert("Error: ' . $e->getMessage() . '")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Grocery Orders</title>
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
                                <h2>Manage Grocery Orders</h2>
                            </div>
                        </div>
                    </div>

                    <!-- Grocery Orders Table -->
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
                                                    <th>Status</th>
                                                    <th>Assign To</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM tblgrocerybooking WHERE Status = 'Approved'";
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
                                                    <td><?php echo htmlentities($row->Status); ?></td>
                                                    <td><?php echo htmlentities($row->AssignTo); ?></td>
                                                    <td>
                                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailsModal<?php echo $row->ID; ?>">Details</button>
                                                    </td>
                                                </tr>

                                                <!-- Details Modal -->
                                                <div class="modal fade" id="detailsModal<?php echo $row->ID; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Update Order</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post">
                                                                    <input type="hidden" name="editid" value="<?php echo $row->ID; ?>">
                                                                    <div class="form-group">
                                                                        <label for="status">Status</label>
                                                                        <select name="status" id="status<?php echo $row->ID; ?>" class="form-control" required>
                                                                            <option value="Approved" selected>Approved</option>
                                                                            <option value="HandOverTo">HandOverTo</option>
                                                                            <option value="Cancelled">Cancelled</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group" id="maidSection<?php echo $row->ID; ?>" style="display: none;">
                                                                        <label for="maid">Assign to Maid</label>
                                                                        <select name="maid" id="maid<?php echo $row->ID; ?>" class="form-control">
                                                                            <option value="">Select Maid</option>
                                                                            <?php
                                                                            $sqlMaid = "SELECT MaidId, Name FROM tblmaid";
                                                                            $queryMaid = $dbh->prepare($sqlMaid);
                                                                            $queryMaid->execute();
                                                                            $maids = $queryMaid->fetchAll(PDO::FETCH_OBJ);
                                                                            foreach ($maids as $maid) {
                                                                            ?>
                                                                            <option value="<?php echo htmlentities($maid->MaidId); ?>">
                                                                                <?php echo htmlentities($maid->Name); ?>
                                                                            </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->
                                                <?php
                                                    }
                                                } else {
                                                    echo '<tr><td colspan="7">No orders found.</td></tr>';
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

<script>
    $(document).ready(function () {
        <?php
        if ($query->rowCount() > 0) {
            foreach ($results as $row) {
        ?>
        $('#status<?php echo $row->ID; ?>').change(function () {
            if ($(this).val() == 'HandOverTo') {
                $('#maidSection<?php echo $row->ID; ?>').show();
                $('#maid<?php echo $row->ID; ?>').prop('required', true);
            } else {
                $('#maidSection<?php echo $row->ID; ?>').hide();
                $('#maid<?php echo $row->ID; ?>').prop('required', false);
            }
        });
        <?php
            }
        }
        ?>
    });
</script>
</body>
</html>
