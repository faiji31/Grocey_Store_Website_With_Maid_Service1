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
    <title>New Requests</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="inner_page tables_page">
<div class="flex min-h-screen bg-gray-100">
    <?php include_once('includes/sidebar.php'); ?>
    <div class="flex-1 flex flex-col">
        <?php include_once('includes/header.php'); ?>
        <main class="flex-1 p-6 md:p-10">
            <h2 class="text-3xl font-bold text-green-700 mb-8">New Requests</h2>
            <div class="mb-10">
                <div class="bg-white rounded-xl shadow p-6 mb-8">
                    <h3 class="text-xl font-semibold text-green-700 mb-4">New Maid Booking Requests</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-green-600">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">#</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Booking ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Mobile Number</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Email</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Category</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Booking Date</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Assign To</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php
                                $sql = "SELECT m.*, c.CategoryName "+
                                    " FROM tblmaidbooking m "+
                                    " LEFT JOIN tblcategory c ON m.CatID = c.ID "+
                                    " WHERE m.Status IS NULL";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $row) {
                                ?>
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($cnt); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->BookingID); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->Name); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->ContactNumber); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->Email); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->CategoryName); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->BookingDate); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo $row->Status ? htmlentities($row->Status) : "Not Updated Yet"; ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo $row->AssignTo ? htmlentities($row->AssignTo) : "Not Assigned Yet"; ?></td>
                                    <td class="px-4 py-2 text-sm">
                                        <a href="view-booking-detail.php?editid=<?php echo htmlentities($row->ID); ?>&&bookingid=<?php echo htmlentities($row->BookingID); ?>" class="inline-block bg-blue-500 hover:bg-blue-700 text-white px-4 py-1 rounded-full text-xs font-semibold transition">View Details</a>
                                    </td>
                                </tr>
                                <?php $cnt++; }} else { ?>
                                <tr>
                                    <td colspan="10" class="text-center py-4 text-gray-500">No New Maid Booking Requests Found</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="text-xl font-semibold text-green-700 mb-4">New Grocery Booking Requests</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-green-600">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">#</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Order ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Customer Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Phone Number</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Delivery Address</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Order Details</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Delivery Time</th>
                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php
                                $sql = "SELECT * FROM tblgrocerybooking WHERE Status IS NULL AND AssignTo IS NULL";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $row) {
                                ?>
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($cnt); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->ID); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->UserName); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->PhoneNumber); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->FullArea); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->OrderDetails); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-900"><?php echo htmlentities($row->DeliveryTime); ?></td>
                                    <td class="px-4 py-2 text-sm">
                                        <a href="view-grocery-order-details.php?editid=<?php echo htmlentities($row->ID); ?>" class="inline-block bg-blue-500 hover:bg-blue-700 text-white px-4 py-1 rounded-full text-xs font-semibold transition">View Details</a>
                                    </td>
                                </tr>
                                <?php $cnt++; }} else { ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-gray-500">No New Grocery Booking Requests Found</td>
                                </tr>
                                <?php } ?>
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
