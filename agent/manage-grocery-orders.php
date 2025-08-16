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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">
    <?php include_once('includes/sidebar.php'); ?>
    <div class="flex-1 flex flex-col min-h-screen" style="min-width:0;">
        <?php include_once('includes/header.php'); ?>
        <main class="flex-1 p-6 md:p-10 mt-4">
            <h2 class="text-3xl font-bold text-green-700 mb-8">Manage Grocery Orders</h2>
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h3 class="text-xl font-semibold text-green-700 mb-4">Grocery Orders</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-green-200">
                        <thead class="bg-green-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Order ID</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Customer Name</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Phone Number</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Delivery Address</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Assign To</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-green-100">
                            <?php
                                                $sql = "SELECT * FROM tblgrocerybooking WHERE Status = 'Approved'";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) {
                                                ?>
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-700"><?php echo htmlentities($row->ID); ?></td>
                                    <td class="px-4 py-2 text-gray-600"><?php echo htmlentities($row->UserName); ?></td>
                                    <td class="px-4 py-2 text-gray-600"><?php echo htmlentities($row->PhoneNumber); ?></td>
                                    <td class="px-4 py-2 text-gray-600"><?php echo htmlentities($row->FullArea); ?></td>
                                    <td class="px-4 py-2 text-green-700 font-semibold"><?php echo htmlentities($row->Status); ?></td>
                                    <td class="px-4 py-2 text-gray-600"><?php echo htmlentities($row->AssignTo); ?></td>
                                    <td class="px-4 py-2">
                                        <button class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-4 py-1 rounded-full shadow hover:from-green-600 hover:to-green-800 transition text-sm" data-toggle="modal" data-target="#detailsModal<?php echo $row->ID; ?>">Details</button>
                                    </td>
                                </tr>

                                                <!-- Details Modal -->
                                <div class="fixed z-50 inset-0 overflow-y-auto hidden" id="detailsModal<?php echo $row->ID; ?>-modal">
                                    <div class="flex items-center justify-center min-h-screen px-4">
                                        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6 relative">
                                            <button type="button" class="absolute top-2 right-2 text-gray-400 hover:text-red-600 text-2xl font-bold focus:outline-none close-modal" data-modal="#detailsModal<?php echo $row->ID; ?>-modal">&times;</button>
                                            <h5 class="text-xl font-bold text-green-700 mb-4">Update Order</h5>
                                            <form method="post" class="space-y-4">
                                                <input type="hidden" name="editid" value="<?php echo $row->ID; ?>">
                                                <div>
                                                    <label for="status<?php echo $row->ID; ?>" class="block text-green-700 font-semibold mb-1">Status</label>
                                                    <select name="status" id="status<?php echo $row->ID; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition" required>
                                                        <option value="Approved" selected>Approved</option>
                                                        <option value="HandOverTo">HandOverTo</option>
                                                        <option value="Cancelled">Cancelled</option>
                                                    </select>
                                                </div>
                                                <div id="maidSection<?php echo $row->ID; ?>" style="display: none;">
                                                    <label for="maid<?php echo $row->ID; ?>" class="block text-green-700 font-semibold mb-1">Assign to Maid</label>
                                                    <select name="maid" id="maid<?php echo $row->ID; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition">
                                                        <option value="">Select Maid</option>
                                                        <?php
                                                        $sqlMaid = "SELECT MaidId, Name FROM tblmaid";
                                                        $queryMaid = $dbh->prepare($sqlMaid);
                                                        $queryMaid->execute();
                                                        $maids = $queryMaid->fetchAll(PDO::FETCH_OBJ);
                                                        foreach ($maids as $maid) {
                                                        ?>
                                                        <option value="<?php echo htmlentities($maid->MaidId); ?>"><?php echo htmlentities($maid->Name); ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="flex justify-end space-x-2 pt-2">
                                                    <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-4 py-2 rounded-lg close-modal" data-modal="#detailsModal<?php echo $row->ID; ?>-modal">Close</button>
                                                    <button type="submit" name="submit" class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-6 py-2 rounded-full shadow hover:from-green-600 hover:to-green-800 transition">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                                <!-- End Modal -->
                                                <?php
                                                    }
                                } else {
                                    echo '<tr><td colspan="7" class="px-4 py-2 text-center text-gray-400">No orders found.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once('includes/footer.php'); ?>
    </div>
    <script>
    // Modal open/close logic
    document.querySelectorAll('[data-toggle="modal"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const target = btn.getAttribute('data-target');
            document.querySelector(target + '-modal').classList.remove('hidden');
        });
    });
    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = btn.getAttribute('data-modal');
            document.querySelector(modal).classList.add('hidden');
        });
    });
    // Maid section show/hide
    <?php
    if ($query->rowCount() > 0) {
        foreach ($results as $row) {
    ?>
    document.getElementById('status<?php echo $row->ID; ?>').addEventListener('change', function() {
        if (this.value == 'HandOverTo') {
            document.getElementById('maidSection<?php echo $row->ID; ?>').style.display = '';
            document.getElementById('maid<?php echo $row->ID; ?>').required = true;
        } else {
            document.getElementById('maidSection<?php echo $row->ID; ?>').style.display = 'none';
            document.getElementById('maid<?php echo $row->ID; ?>').required = false;
        }
    });
    <?php
        }
    }
    ?>
    </script>
</body>
</html>
