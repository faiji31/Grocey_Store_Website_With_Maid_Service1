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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">
    <?php include_once('includes/sidebar.php'); ?>
    <div class="flex-1 flex flex-col min-h-screen" style="min-width:0;">
        <?php include_once('includes/header.php'); ?>
        <main class="flex-1 p-6 md:p-10 mt-4">
            <h2 class="text-3xl font-bold text-green-700 mb-8">Dashboard</h2>
            <!-- Grocery Orders Table -->
            <div class="mb-10">
                <div class="bg-white rounded-xl shadow-lg p-6">
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
                                    <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-green-100">
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
                                        <td class="px-4 py-2 font-medium text-gray-700"><?php echo htmlentities($row->ID); ?></td>
                                        <td class="px-4 py-2 text-gray-600"><?php echo htmlentities($row->UserName); ?></td>
                                        <td class="px-4 py-2 text-gray-600"><?php echo htmlentities($row->PhoneNumber); ?></td>
                                        <td class="px-4 py-2 text-gray-600"><?php echo htmlentities($row->FullArea); ?></td>
                                        <td class="px-4 py-2 text-green-700 font-semibold"><?php echo htmlentities($row->Status); ?></td>
                                        <td class="px-4 py-2">
                                            <form method="post" class="flex flex-col items-center space-y-2">
                                                <input type="hidden" name="orderId" value="<?php echo $row->ID; ?>">
                                                <input type="hidden" name="table" value="tblgrocerybooking">
                                                <select name="status" class="w-32 px-2 py-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition">
                                                    <option value="Completed">Completed</option>
                                                    <option value="Cancelled">Cancelled</option>
                                                </select>
                                                <button type="submit" name="updateStatus" class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-4 py-1 rounded-full shadow hover:from-green-600 hover:to-green-800 transition text-sm">Update</button>
                                            </form>
                                        </td>
                                    </tr>
                                                <?php }
                                } else {
                                    echo '<tr><td colspan="6" class="px-4 py-2 text-center text-gray-400">No Grocery Orders Found</td></tr>';
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Maid Orders Table -->
            <div class="bg-white rounded-xl shadow-lg p-6 mt-10">
                <h3 class="text-xl font-semibold text-green-700 mb-4">Maid Bookings</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-green-200">
                        <thead class="bg-green-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Booking ID</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Mobile Number</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Address</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Category</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-green-100">
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
                                <td class="px-4 py-2 font-medium text-gray-700"><?php echo htmlentities($row->BookingID); ?></td>
                                <td class="px-4 py-2 text-gray-600"><?php echo htmlentities($row->Name); ?></td>
                                <td class="px-4 py-2 text-gray-600"><?php echo htmlentities($row->ContactNumber); ?></td>
                                <td class="px-4 py-2 text-gray-600"><?php echo htmlentities($row->Email); ?></td>
                                <td class="px-4 py-2 text-gray-600"><?php echo htmlentities($row->Address); ?></td>
                                <td class="px-4 py-2 text-gray-600"><?php echo htmlentities($row->CategoryName); ?></td>
                                <td class="px-4 py-2 text-green-700 font-semibold"><?php echo htmlentities($row->Status); ?></td>
                                <td class="px-4 py-2">
                                    <form method="post" class="flex flex-col items-center space-y-2">
                                        <input type="hidden" name="orderId" value="<?php echo $row->ID; ?>">
                                        <input type="hidden" name="table" value="tblmaidbooking">
                                        <select name="status" class="w-32 px-2 py-1 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition">
                                            <option value="Completed">Completed</option>
                                            <option value="Cancelled">Cancelled</option>
                                        </select>
                                        <button type="submit" name="updateStatus" class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-4 py-1 rounded-full shadow hover:from-green-600 hover:to-green-800 transition text-sm">Update</button>
                                    </form>
                                </td>
                            </tr>
                            <?php }
                                } else {
                                    echo '<tr><td colspan="8" class="px-4 py-2 text-center text-gray-400">No Maid Bookings Found</td></tr>';
                                } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once('includes/footer.php'); ?>
    </div>
</body>
</html>
