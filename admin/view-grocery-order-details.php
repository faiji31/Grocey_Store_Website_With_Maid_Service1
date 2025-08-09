<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['mhmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $eid = $_GET['editid'];
        $status = $_POST['status'];
        $agentId = $_POST['assignee'];

        try {
            // Fetch the AgentName based on the selected AgentId
            $sqlAgent = "SELECT AgentName FROM tblagent WHERE ID = :agentId";
            $queryAgent = $dbh->prepare($sqlAgent);
            $queryAgent->bindParam(':agentId', $agentId, PDO::PARAM_STR);
            $queryAgent->execute();
            $agent = $queryAgent->fetch(PDO::FETCH_OBJ);

            if ($agent) {
                $agentName = $agent->AgentName;

                // Update the grocery booking with the Status and AgentName
                $sqlUpdate = "UPDATE tblgrocerybooking SET Status = :status, AssignTo = :agentName WHERE ID = :eid";
                $queryUpdate = $dbh->prepare($sqlUpdate);
                $queryUpdate->bindParam(':status', $status, PDO::PARAM_STR);
                $queryUpdate->bindParam(':agentName', $agentName, PDO::PARAM_STR);
                $queryUpdate->bindParam(':eid', $eid, PDO::PARAM_STR);
                $queryUpdate->execute();

                echo '<script>alert("Order status has been updated successfully.")</script>';
                echo "<script>window.location.href ='new-grocery-requests.php'</script>";
            } else {
                echo '<script>alert("Invalid Agent selected.")</script>';
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
    <title>Grocery Order Details</title>
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
                                <h2>View Grocery Order Details</h2>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details Section -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <h2>Order Details</h2>
                                    </div>
                                </div>
                                <div class="table_section padding_infor_info">
                                    <div class="table-responsive-sm">
                                        <?php
                                        $eid = $_GET['editid'];
                                        $sql = "SELECT * FROM tblgrocerybooking WHERE ID=:eid";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $row) {
                                        ?>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Order ID</th>
                                                <td><?php echo htmlentities($row->ID); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Customer Name</th>
                                                <td><?php echo htmlentities($row->UserName); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Phone Number</th>
                                                <td><?php echo htmlentities($row->PhoneNumber); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Delivery Address</th>
                                                <td><?php echo htmlentities($row->FullArea); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Order Details</th>
                                                <td><?php echo htmlentities($row->OrderDetails); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Delivery Time</th>
                                                <td><?php echo htmlentities($row->DeliveryTime); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    <?php
                                                    $status = $row->Status;
                                                    if ($status == "Approved") {
                                                        echo "Order Approved";
                                                    } elseif ($status == "Cancelled") {
                                                        echo "Order Cancelled";
                                                    } else {
                                                        echo "Pending";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <!-- <tr> 
                                                <th>Order Date</th> 
                                                <td><?php echo htmlentities($row->OrderDate); ?></td>
                                            </tr> -->
                                        </table>
                                        <?php } } ?>

                                        <!-- Update Status Section -->
                                        <?php if ($status == "") { ?>
                                        <div class="mt-3">
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#updateStatusModal">Take Action</button>
                                        </div>
                                        <?php } ?>

                                        <!-- Modal for Updating Status -->
                                        <div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post">
                                                            <div class="form-group">
                                                                <label for="status">Status</label>
                                                                <select name="status" id="status" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option value="Approved">Approved</option>
                                                                    <option value="Cancelled">Cancelled</option>
                                                                </select>
                                                            </div>
                                                            <!-- <div class="form-group">
                                                                <label for="remark">Remark</label>
                                                                <textarea name="remark" id="remark" class="form-control" rows="4" required></textarea>
                                                            </div> -->
                                                            <div class="form-group" id="assigneeSection" style="display: none;">
                                                                <label for="assignee">Assign to Agent</label>
                                                                <select name="assignee" id="assignee" class="form-control">
                                                                    <option value="">Select Agent</option>
                                                                    <?php
                                                                    $sqlAgents = "SELECT * FROM tblagent";
                                                                    $queryAgents = $dbh->prepare($sqlAgents);
                                                                    $queryAgents->execute();
                                                                    $agents = $queryAgents->fetchAll(PDO::FETCH_OBJ);
                                                                    foreach ($agents as $agent) {
                                                                    ?>
                                                                   <option value="<?php echo htmlentities($agent->ID); ?>">
    <?php echo htmlentities($agent->AgentName); ?> (<?php echo htmlentities($agent->AgentEmail); ?>)
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
        $('#status').change(function () {
            if ($(this).val() == 'Approved') {
                $('#assigneeSection').show();
                $('#assignee').prop('required', true);
            } else {
                $('#assigneeSection').hide();
                $('#assignee').prop('required', false);
            }
        });
    });
</script>
</body>
</html>
