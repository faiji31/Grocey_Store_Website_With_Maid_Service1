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
    <title>Handed Over Grocery Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">
    <?php include_once('includes/sidebar.php'); ?>
    <div class="flex-1 flex flex-col min-h-screen" style="min-width:0;">
        <?php include_once('includes/header.php'); ?>
        <main class="flex-1 p-6 md:p-10 mt-4">
            <h2 class="text-3xl font-bold text-green-700 mb-8">Handed Over Grocery Orders</h2>
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h3 class="text-xl font-semibold text-green-700 mb-4">Orders Handed Over</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-green-200">
                        <thead class="bg-green-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Order ID</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Customer Name</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Phone Number</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Delivery Address</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Order Details</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Delivery Time</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-green-700 uppercase">Assign To</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-green-100">
                            <?php
                            $sql = "SELECT * FROM tblgrocerybooking WHERE Status = 'HandOverTo'";
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
                                <td class="px-4 py-2 text-gray-600"><?php echo htmlentities($row->OrderDetails); ?></td>
                                <td class="px-4 py-2 text-gray-600"><?php echo htmlentities($row->DeliveryTime); ?></td>
                                <td class="px-4 py-2 text-gray-600"><?php echo htmlentities($row->Status); ?></td>
                                <td class="px-4 py-2 text-gray-600"><?php echo htmlentities($row->AssignTo); ?></td>
                            </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="8" class="px-4 py-2 text-center text-gray-400">No records found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once('includes/footer.php'); ?>
    </div>
</body>
</html>
<?php } ?>
