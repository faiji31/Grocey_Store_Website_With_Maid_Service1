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
    <link rel="shortcut icon" href="images/logo/logo_icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    <?php include_once('includes/sidebar.php'); ?>
    <div class="flex-1 flex flex-col min-h-screen">
        <?php include_once('includes/header.php'); ?>
        <main class="flex-1 p-6 md:p-10">
            <h2 class="text-3xl font-bold text-green-700 mb-8">View Grocery Order Details</h2>
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                    <h3 class="text-xl font-semibold text-green-700 mb-4">Order Details</h3>
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

                                        <table class="min-w-full bg-white rounded-lg overflow-hidden shadow text-sm mb-6">
                                            <tbody>
                                                <tr>
                                                    <th class="px-4 py-2 bg-green-50 text-left w-1/3">Order ID</th>
                                                    <td class="px-4 py-2"><?php echo htmlentities($row->ID); ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="px-4 py-2 bg-green-50 text-left">Customer Name</th>
                                                    <td class="px-4 py-2"><?php echo htmlentities($row->UserName); ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="px-4 py-2 bg-green-50 text-left">Phone Number</th>
                                                    <td class="px-4 py-2"><?php echo htmlentities($row->PhoneNumber); ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="px-4 py-2 bg-green-50 text-left">Delivery Address</th>
                                                    <td class="px-4 py-2"><?php echo htmlentities($row->FullArea); ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="px-4 py-2 bg-green-50 text-left">Order Details</th>
                                                    <td class="px-4 py-2"><?php echo htmlentities($row->OrderDetails); ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="px-4 py-2 bg-green-50 text-left">Delivery Time</th>
                                                    <td class="px-4 py-2"><?php echo htmlentities($row->DeliveryTime); ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="px-4 py-2 bg-green-50 text-left">Status</th>
                                                    <td class="px-4 py-2">
                                                        <?php
                                                        $status = $row->Status;
                                                        if ($status == "Approved") {
                                                            echo "<span class='inline-block bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium'>Order Approved</span>";
                                                        } elseif ($status == "Cancelled") {
                                                            echo "<span class='inline-block bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium'>Order Cancelled</span>";
                                                        } else {
                                                            echo "<span class='inline-block bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-medium'>Pending</span>";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?php } } ?>

                                        <!-- Update Status Section -->
                                        <?php if ($status == "") { ?>
                                        <div x-data="{ open: false, showAssignee: false }">
                                            <div class="mt-3">
                                                <button @click="open = true" class="px-6 py-2 bg-green-700 text-white rounded-lg font-semibold hover:bg-green-800 transition">Take Action</button>
                                            </div>
                                            <!-- Modal for Updating Status (Tailwind/Alpine) -->
                                            <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40" style="display: none;">
                                                <div @click.away="open = false" class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                                                    <h3 class="text-lg font-semibold mb-4">Update Status</h3>
                                                    <form method="post">
                                                        <div class="mb-4">
                                                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                                            <select name="status" id="status" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500" required @change="showAssignee = $event.target.value === 'Approved'">
                                                                <option value="">Select</option>
                                                                <option value="Approved">Approved</option>
                                                                <option value="Cancelled">Cancelled</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-4" x-show="showAssignee">
                                                            <label for="assignee" class="block text-sm font-medium text-gray-700 mb-1">Assign to Agent</label>
                                                            <select name="assignee" id="assignee" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
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
                                                        <div class="flex justify-end gap-2 mt-6">
                                                            <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Close</button>
                                                            <button type="submit" name="submit" class="px-4 py-2 bg-green-700 text-white rounded hover:bg-green-800">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- End Modal -->
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once('includes/footer.php'); ?>
    </div>
</div>
</body>
</html>
