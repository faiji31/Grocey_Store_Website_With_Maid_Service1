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
    <title>Maid Hiring Management System || Agent Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">
    <?php include_once('includes/sidebar.php'); ?>
    <div class="flex-1 flex flex-col min-h-screen" style="min-width:0;">
        <?php include_once('includes/header.php'); ?>
        <main class="flex-1 p-6 md:p-10 mt-4">
            <h2 class="text-3xl font-bold text-green-700 mb-8">Agent Dashboard</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-purple-100 mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 018 0v2M9 17a4 4 0 01-8 0v-2a4 4 0 018 0v2zm0 0v-2a4 4 0 018 0v2m0 0a4 4 0 01-8 0v-2a4 4 0 018 0v2z"/></svg>
                    </div>
                    <?php
                    $sql1 = "SELECT * FROM tblgrocerybooking Where Status='Approved'";
                    $query1 = $dbh->prepare($sql1);
                    $query1->execute();
                    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                    $totBookings = $query1->rowCount();
                    ?>
                    <p class="text-3xl font-bold text-gray-800 mb-2"><?php echo htmlentities($totBookings); ?></p>
                    <p class="text-gray-600 mb-4 text-center">Pending Grocery Orders</p>
                    <a href="manage-grocery-orders.php" class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-6 py-2 rounded-full shadow hover:from-green-600 hover:to-green-800 transition">View Details</a>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100 mb-4">
                        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M17 20a4 4 0 01-8 0M9 20a4 4 0 01-8 0v-2a4 4 0 018 0v2zm8-4V4a4 4 0 00-8 0v12"/></svg>
                    </div>
                    <?php
                    $sql2 = "SELECT * FROM tblmaid";
                    $query2 = $dbh->prepare($sql2);
                    $query2->execute();
                    $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                    $totMaids = $query2->rowCount();
                    ?>
                    <p class="text-3xl font-bold text-gray-800 mb-2"><?php echo htmlentities($totMaids); ?></p>
                    <p class="text-gray-600 mb-4 text-center">Listed Maids</p>
                    <a href="manage-maids.php" class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-6 py-2 rounded-full shadow hover:from-green-600 hover:to-green-800 transition">View Details</a>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 018 0v2M9 17a4 4 0 01-8 0v-2a4 4 0 018 0v2zm0 0v-2a4 4 0 018 0v2m0 0a4 4 0 01-8 0v-2a4 4 0 018 0v2z"/></svg>
                    </div>
                    <?php
                    $sql3 = "SELECT * FROM tblgrocerybooking WHERE Status='HandOverTo'";
                    $query3 = $dbh->prepare($sql3);
                    $query3->execute();
                    $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                    $completedBookings = $query3->rowCount();
                    ?>
                    <p class="text-3xl font-bold text-gray-800 mb-2"><?php echo htmlentities($completedBookings); ?></p>
                    <p class="text-gray-600 mb-4 text-center">Completed Requests</p>
                    <a href="completed-grocery-orders.php" class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-6 py-2 rounded-full shadow hover:from-green-600 hover:to-green-800 transition">View Details</a>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-red-100 mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-1.414 1.414M6.05 17.95l-1.414 1.414M17.95 17.95l-1.414-1.414M6.05 6.05L4.636 4.636"/><circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="2" fill="none"/></svg>
                    </div>
                    <?php
                    $sql4 = "SELECT * FROM tblgrocerybooking WHERE  Status='Cancelled'";
                    $query4 = $dbh->prepare($sql4);
                    $query4->execute();
                    $results4 = $query4->fetchAll(PDO::FETCH_OBJ);
                    $cancelledBookings = $query4->rowCount();
                    ?>
                    <p class="text-3xl font-bold text-gray-800 mb-2"><?php echo htmlentities($cancelledBookings); ?></p>
                    <p class="text-gray-600 mb-4 text-center">Cancelled Requests</p>
                    <a href="cancelled-grocery-orders.php" class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-6 py-2 rounded-full shadow hover:from-green-600 hover:to-green-800 transition">View Details</a>
                </div>
            </div>
        </main>
        <?php include_once('includes/footer.php'); ?>
    </div>
</body>
</html>
<?php } ?>