<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['mhmsaid'] == 0)) {
    header('location:logout.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>New Grocery Requests</title>
    <link rel="shortcut icon" href="images/logo/logo_icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen">
<div class="flex min-h-screen">
    <?php include_once('includes/sidebar.php'); ?>
    <div class="flex-1 flex flex-col min-h-screen">
        <?php include_once('includes/header.php'); ?>
        <main class="flex-1 p-6 md:p-10">
            <h2 class="text-3xl font-bold text-green-700 mb-8">New Grocery Requests</h2>
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden shadow text-sm">
                        <thead class="bg-green-700 text-white">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Order ID</th>
                                <th class="px-4 py-3">Customer Name</th>
                                <th class="px-4 py-3">Phone Number</th>
                                <th class="px-4 py-3">Delivery Address</th>
                                <th class="px-4 py-3">Order Details</th>
                                <th class="px-4 py-3">Delivery Time</th>
                                <th class="px-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-green-100">
                            <?php
                            $sql = "SELECT * FROM tblgrocerybooking WHERE Status IS NULL AND AssignTo IS NULL";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                            $cnt = 1;
                            if ($query->rowCount() > 0) {
                                foreach ($results as $row) {
                            ?>
                            <tr class="hover:bg-green-50">
                                <td class="px-4 py-2 text-center"><?php echo htmlentities($cnt); ?></td>
                                <td class="px-4 py-2 font-semibold text-green-800"><?php echo htmlentities($row->ID); ?></td>
                                <td class="px-4 py-2"><?php echo htmlentities($row->UserName); ?></td>
                                <td class="px-4 py-2"><?php echo htmlentities($row->PhoneNumber); ?></td>
                                <td class="px-4 py-2"><?php echo htmlentities($row->FullArea); ?></td>
                                <td class="px-4 py-2"><?php echo htmlentities($row->OrderDetails); ?></td>
                                <td class="px-4 py-2"><?php echo htmlentities($row->DeliveryTime); ?></td>
                                <td class="px-4 py-2 text-center">
                                    <a href="view-grocery-order-details.php?editid=<?php echo htmlentities($row->ID); ?>" class="inline-block bg-blue-500 hover:bg-blue-700 text-white px-4 py-1 rounded-full text-xs font-semibold transition">View Details</a>
                                </td>
                            </tr>
                            <?php $cnt++; }} else { ?>
                            <tr>
                                <td colspan="8" class="text-center text-gray-500 py-4">No New Requests Found</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once('includes/footer.php'); ?>
    </div>
</div>
</body>
</html>
<?php } ?>
