<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include('includes/dbconnection.php');

if (!isset($_SESSION['mhmsaid']) || strlen(trim($_SESSION['mhmsaid'])) == 0) {
    header('Location: logout.php');
    exit();
} else {
    if (isset($_POST['submit'])) {
        $eid = $_GET['editid'];
        $status = $_POST['status'];
        $maidId = $_POST['assignee'];

        try {
            // Fetch the Maid Name based on the selected MaidId
            $sqlMaid = "SELECT Name FROM tblmaid WHERE MaidId = :maidId";
            $queryMaid = $dbh->prepare($sqlMaid);
            $queryMaid->bindParam(':maidId', $maidId, PDO::PARAM_STR);
            $queryMaid->execute();
            $maid = $queryMaid->fetch(PDO::FETCH_OBJ);

            if ($maid) {
                $maidName = $maid->Name;

                // Update the maid booking with the Status and MaidName
                $sqlUpdate = "UPDATE tblmaidbooking SET Status = :status, AssignTo = :maidName WHERE ID = :eid";
                $queryUpdate = $dbh->prepare($sqlUpdate);
                $queryUpdate->bindParam(':status', $status, PDO::PARAM_STR);
                $queryUpdate->bindParam(':maidName', $maidName, PDO::PARAM_STR);
                $queryUpdate->bindParam(':eid', $eid, PDO::PARAM_STR);
                $queryUpdate->execute();

                echo '<script>alert("Booking status has been updated successfully.")</script>';
                echo "<script>window.location.href ='all-request.php'</script>";
            } else {
                echo '<script>alert("Invalid Maid selected.")</script>';
            }
        } catch (PDOException $e) {
            echo '<script>alert("Error: ' . $e->getMessage() . '")</script>';
        }
    }
}
// Debug output for editid
if (isset($_GET['editid'])) {
    echo '<div style="background: #ffeeba; color: #856404; padding: 10px; margin: 10px 0; border-radius: 6px;">Debug: editid = ' . htmlspecialchars($_GET['editid']) . '</div>';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Grocery Order Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">
    <?php include_once('includes/sidebar.php'); ?>
    <div class="flex-1 flex flex-col min-h-screen" style="min-width:0;">
        <?php include_once('includes/header.php'); ?>
        <main class="flex-1 p-6 md:p-10 mt-4">
            <h2 class="text-3xl font-bold text-green-700 mb-8">View Grocery Order Details</h2>
            <!-- Order Details Section -->
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h3 class="text-xl font-semibold text-green-700 mb-4">Order Details</h3>
                        <div class="overflow-x-auto">
                            <?php
                            $eid = $_GET['editid'];
                            $sql = "SELECT mb.*, c.CategoryName FROM tblmaidbooking mb LEFT JOIN tblcategory c ON mb.CatID = c.ID WHERE mb.ID=:eid";
                            $query = $dbh->prepare($sql);
                            $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                            ?>
                            <table class="min-w-full divide-y divide-green-200 mb-6">
                                <tr>
                                    <th class="px-4 py-2 text-left bg-green-100 text-green-700">Booking ID</th>
                                    <td class="px-4 py-2 text-gray-700"><?php echo htmlentities($row->BookingID); ?></td>
                                    <th class="px-4 py-2 text-left bg-green-100 text-green-700">Service Required</th>
                                    <td class="px-4 py-2 text-gray-700"><?php echo htmlentities($row->CategoryName); ?></td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-2 text-left bg-green-100 text-green-700">Name</th>
                                    <td class="px-4 py-2 text-gray-700"><?php echo htmlentities($row->Name); ?></td>
                                    <th class="px-4 py-2 text-left bg-green-100 text-green-700">Contact Number</th>
                                    <td class="px-4 py-2 text-gray-700"><?php echo htmlentities($row->ContactNumber); ?></td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-2 text-left bg-green-100 text-green-700">Email</th>
                                    <td class="px-4 py-2 text-gray-700"><?php echo htmlentities($row->Email); ?></td>
                                    <th class="px-4 py-2 text-left bg-green-100 text-green-700">Address(to be hired)</th>
                                    <td class="px-4 py-2 text-gray-700"><?php echo htmlentities($row->Address); ?></td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-2 text-left bg-green-100 text-green-700">Gender Required</th>
                                    <td class="px-4 py-2 text-gray-700"><?php echo htmlentities($row->Gender); ?></td>
                                    <th class="px-4 py-2 text-left bg-green-100 text-green-700">Working Shift From</th>
                                    <td class="px-4 py-2 text-gray-700"><?php echo htmlentities($row->WorkingShiftFrom); ?></td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-2 text-left bg-green-100 text-green-700">Working Shift To</th>
                                    <td class="px-4 py-2 text-gray-700"><?php echo htmlentities($row->WorkingShiftTo); ?></td>
                                    <th class="px-4 py-2 text-left bg-green-100 text-green-700">Work Start Date</th>
                                    <td class="px-4 py-2 text-gray-700"><?php echo htmlentities($row->StartDate); ?></td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-2 text-left bg-green-100 text-green-700">Notes(if any)</th>
                                    <td class="px-4 py-2 text-gray-700"><?php echo htmlentities($row->Notes); ?></td>
                                    <th class="px-4 py-2 text-left bg-green-100 text-green-700">Booking Date</th>
                                    <td class="px-4 py-2 text-gray-700"><?php echo htmlentities($row->BookingDate); ?></td>
                                </tr>
                                <tr>
                                    <th class="px-4 py-2 text-left bg-green-100 text-green-700">Booking Status</th>
                                    <td class="px-4 py-2 text-gray-700">
                                        <?php
                                        $status = $row->Status;
                                        if ($status == "Approved") {
                                            echo "Booking Approved";
                                        } elseif ($status == "Cancelled") {
                                            echo "Booking Cancelled";
                                        } else {
                                            echo "Pending";
                                        }
                                        ?>
                                    </td>
                                    <th class="px-4 py-2 text-left bg-green-100 text-green-700">Admin Remark</th>
                                    <td class="px-4 py-2 text-gray-700"><?php echo htmlentities($row->Remark) ?: 'Not Updated Yet'; ?></td>
                                </tr>
                            </table>
                            <?php } } ?>

                            <!-- Update Status Section -->
                            <?php if ($status == "") { ?>
                            <div class="mt-3">
                                <button id="openModalBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">Take Action</button>
                            </div>
                            <?php } ?>

                            <!-- Modal for Updating Status -->
                            <div id="updateStatusModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                                <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
                                    <div class="flex justify-between items-center border-b px-6 py-4">
                                        <h5 class="text-lg font-bold text-green-700">Update Status</h5>
                                        <button id="closeModalBtn" class="text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                                    </div>
                                    <div class="p-6">
                                        <form method="post">
                                            <div class="mb-4">
                                                <label for="status" class="block text-gray-700 font-semibold mb-2">Status</label>
                                                <select name="status" id="status" class="w-full border border-gray-300 rounded-lg px-3 py-2" required>
                                                    <option value="">Select</option>
                                                    <option value="Approved">Approved</option>
                                                    <option value="Cancelled">Cancelled</option>
                                                </select>
                                            </div>
                                            <div class="mb-4" id="assigneeSection" style="display: none;">
                                                <label for="assignee" class="block text-gray-700 font-semibold mb-2">Assign to Maid</label>
                                                <select name="assignee" id="assignee" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                                    <option value="">Select Maid</option>
                                                    <?php
                                                    $sqlMaids = "SELECT * FROM tblmaid";
                                                    $queryMaids = $dbh->prepare($sqlMaids);
                                                    $queryMaids->execute();
                                                    $maids = $queryMaids->fetchAll(PDO::FETCH_OBJ);
                                                    foreach ($maids as $maid) {
                                                    ?>
                                                    <option value="<?php echo htmlentities($maid->MaidId); ?>">
                                                        <?php echo htmlentities($maid->Name); ?> (<?php echo htmlentities($maid->Email); ?>)
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="flex justify-end gap-2 mt-6">
                                                <button type="button" id="closeModalBtn2" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-semibold">Close</button>
                                                <button type="submit" name="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once('includes/footer.php'); ?>
    </div>

<script>
    // Modal open/close logic
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const closeModalBtn2 = document.getElementById('closeModalBtn2');
    const modal = document.getElementById('updateStatusModal');
    if(openModalBtn) openModalBtn.onclick = () => modal.classList.remove('hidden');
    if(closeModalBtn) closeModalBtn.onclick = () => modal.classList.add('hidden');
    if(closeModalBtn2) closeModalBtn2.onclick = () => modal.classList.add('hidden');

    // Show/hide assignee section
    const statusSelect = document.getElementById('status');
    const assigneeSection = document.getElementById('assigneeSection');
    const assignee = document.getElementById('assignee');
    if(statusSelect) {
        statusSelect.addEventListener('change', function() {
            if (this.value === 'Approved') {
                assigneeSection.style.display = '';
                assignee.required = true;
            } else {
                assigneeSection.style.display = 'none';
                assignee.required = false;
            }
        });
    }
</script>
</body>
</html>  