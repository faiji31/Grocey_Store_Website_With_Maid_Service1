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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="dashboard dashboard_1">
<div class="flex min-h-screen bg-gray-100">
    <?php include_once('includes/sidebar.php'); ?>
    <div class="flex-1 flex flex-col">
        <?php include_once('includes/header.php'); ?>
        <main class="flex-1 p-6 md:p-10">
            <h2 class="text-3xl font-bold text-green-700 mb-8">Completed Orders</h2>
            <div class="mb-10">
                <div class="bg-white rounded-xl shadow p-6 mb-8">
                    <h3 class="text-xl font-semibold text-green-700 mb-4">Grocery Orders</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-green-600">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Order ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Customer Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Phone Number</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Delivery Address</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Order Details</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php
                                $sqlGrocery = "SELECT * FROM tblgrocerybooking WHERE Status = 'Completed'";
                                $queryGrocery = $dbh->prepare($sqlGrocery);
                                $queryGrocery->execute();
                                $groceryResults = $queryGrocery->fetchAll(PDO::FETCH_OBJ);
                                if ($queryGrocery->rowCount() > 0) {
                                    foreach ($groceryResults as $row) {
                                ?>
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->ID); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->UserName); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->PhoneNumber); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->FullArea); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->OrderDetails); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->Status); ?></td>
                                </tr>
                                <?php }
                                } else {
                                    echo '<tr><td colspan="6" class="text-center py-4 text-gray-500">No Completed Grocery Orders Found</td></tr>';
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-xl font-semibold text-green-700 mb-4">Maid Bookings</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-green-600">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Booking ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Mobile Number</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Email</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Address</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php
                                $sqlMaid = "SELECT * FROM tblmaidbooking WHERE Status = 'Completed'";
                                $queryMaid = $dbh->prepare($sqlMaid);
                                $queryMaid->execute();
                                $maidResults = $queryMaid->fetchAll(PDO::FETCH_OBJ);
                                if ($queryMaid->rowCount() > 0) {
                                    foreach ($maidResults as $row) {
                                ?>
                                <tr class="text-green-700 font-semibold">
                                    <td class="px-4 py-2 text-sm"><?php echo htmlentities($row->BookingID); ?></td>
                                    <td class="px-4 py-2 text-sm"><?php echo htmlentities($row->Name); ?></td>
                                    <td class="px-4 py-2 text-sm"><?php echo htmlentities($row->ContactNumber); ?></td>
                                    <td class="px-4 py-2 text-sm"><?php echo htmlentities($row->Email); ?></td>
                                    <td class="px-4 py-2 text-sm"><?php echo htmlentities($row->Address); ?></td>
                                    <td class="px-4 py-2 text-sm"><?php echo htmlentities($row->Status); ?></td>
                                </tr>
                                <?php }
                                } else {
                                    echo '<tr><td colspan="6" class="text-center py-4 text-gray-500">No Completed Maid Bookings Found</td></tr>';
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once('includes/footer.php'); ?>
    </div>
</div>
</body>
</html>
<?php } ?>
