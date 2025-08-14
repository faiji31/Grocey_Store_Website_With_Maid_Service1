<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please login to access this page.');</script>";
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

error_reporting(0);
include('includes/dbconnection.php');

// Persist 'area' parameter
if (isset($_GET['area']) && !empty($_GET['area'])) {
    $_SESSION['areaName'] = htmlspecialchars($_GET['area']);
}

$areaName = isset($_SESSION['areaName']) ? $_SESSION['areaName'] : '';
$userid = $_SESSION['userid'];
$sql = "SELECT * FROM tbluser WHERE ID = :userid";
$query = $dbh->prepare($sql);
$query->bindParam(':userid', $userid, PDO::PARAM_INT);
$query->execute();
$user = $query->fetch(PDO::FETCH_OBJ);

if (!$user) {
    echo "<script>alert('Unable to fetch user information. Please try again later.');</script>";
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

// Form submission
if (isset($_POST['submit'])) {
    $catid = $_POST['catid'];
    $name = $user->UserName;
    $contno = $user->UserMobile;
    $email = $user->UserEmail;
    $address = $user->UserAddress;
    $gender = $user->Gender;
    $wsf = $_POST['wsf'];
    $wst = $_POST['wst'];
    $startdate = $_POST['startdate'];
    $notes = $_POST['notes'];
    $areaname = htmlspecialchars($_POST['areaName']);
    $bookingid = mt_rand(100000000, 999999999);

    $sql = "INSERT INTO tblmaidbooking (BookingID, CatID, Name, ContactNumber, Email, Address, Gender, WorkingShiftFrom, WorkingShiftTo, StartDate, Notes, AreaName)
            VALUES (:bookingid, :catid, :name, :contno, :email, :address, :gender, :wsf, :wst, :startdate, :notes, :areaname)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':bookingid', $bookingid, PDO::PARAM_STR);
    $query->bindParam(':catid', $catid, PDO::PARAM_STR);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':contno', $contno, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':wsf', $wsf, PDO::PARAM_STR);
    $query->bindParam(':wst', $wst, PDO::PARAM_STR);
    $query->bindParam(':startdate', $startdate, PDO::PARAM_STR);
    $query->bindParam(':notes', $notes, PDO::PARAM_STR);
    $query->bindParam(':areaname', $areaname, PDO::PARAM_STR);

    if ($query->execute()) {
        echo '<script>alert("Your Booking Request Has Been Sent. We Will Contact You Soon.");</script>';
        echo "<script>window.location.href='order-list.php';</script>";
    } else {
        echo '<script>alert("Something Went Wrong. Please try again.");</script>';
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Grocery Store and Maid Service System || Hiring Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-50 text-gray-800">
    <?php include_once('includes/header.php'); ?>

    <div class="max-w-6xl mx-auto px-4 py-12">
        <h2 class="text-4xl font-bold text-center text-green-600 mb-2">Looking To Hire A Maid?</h2>
        <p class="text-center text-green-500 mb-8">Post Your Requirement Below</p>

        <form action="" method="post" class="bg-white shadow-lg rounded-lg p-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label class="block font-semibold text-red-600 mb-1">Name:</label>
                    <input type="text" name="name" id="name" readonly
                        value="<?php echo htmlentities($user->UserName); ?>"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Contact Number -->
                <div>
                    <label class="block font-semibold text-red-600 mb-1">Contact Number:</label>
                    <input type="text" name="contno" id="contno" readonly
                        value="<?php echo htmlentities($user->UserMobile); ?>"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Email -->
                <div>
                    <label class="block font-semibold text-red-600 mb-1">Email:</label>
                    <input type="email" name="email" id="email" readonly
                        value="<?php echo htmlentities($user->UserEmail); ?>"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Area Name -->
                <div>
                    <label class="block font-semibold text-red-600 mb-1">Area Name:</label>
                    <select name="areaName" id="areaName" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                        <option value="">-- Select Area --</option>
                        <option value="Basundhara R/A" <?php echo ($areaName == "Basundhara R/A") ? 'selected' : ''; ?>>Basundhara R/A</option>
                        <option value="Banani" <?php echo ($areaName == "Banani") ? 'selected' : ''; ?> disabled>Banani</option>
                        <option value="Gulshan" <?php echo ($areaName == "Gulshan") ? 'selected' : ''; ?>>Gulshan</option>
                        <option value="Badda" <?php echo ($areaName == "Badda") ? 'selected' : ''; ?> disabled>Badda</option>
                        <option value="Uttara" <?php echo ($areaName == "Uttara") ? 'selected' : ''; ?>>Uttara</option>
                    </select>
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label class="block font-semibold text-red-600 mb-1">Address Details:</label>
                    <textarea name="address" id="address" readonly
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500"><?php echo htmlentities($user->UserAddress); ?></textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Service -->
                <div>
                    <label class="block font-semibold text-red-600 mb-1">Select Service:</label>
                    <select name="catid" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                        <option value="">Select Service</option>
                        <?php
                        $sql2 = "SELECT * FROM tblcategory";
                        $query2 = $dbh->prepare($sql2);
                        $query2->execute();
                        $result2 = $query2->fetchAll(PDO::FETCH_OBJ);
                        foreach ($result2 as $row2) {
                            echo '<option value="' . htmlentities($row2->ID) . '">' . htmlentities($row2->CategoryName) . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <!-- Work Shift From -->
                <div>
                    <label class="block font-semibold text-red-600 mb-1">Work Shift From:</label>
                    <input type="time" name="wsf" id="wsf" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Work Shift To -->
                <div>
                    <label class="block font-semibold text-red-600 mb-1">Work Shift To:</label>
                    <input type="time" name="wst" id="wst" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Start Date -->
                <div>
                    <label class="block font-semibold text-red-600 mb-1">Start Date:</label>
                    <input type="date" name="startdate" id="startdate" required
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label class="block font-semibold text-red-600 mb-1">Notes:</label>
                    <textarea name="notes" id="notes" placeholder="Enter some notes"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500"></textarea>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" name="submit"
                    class="bg-green-500 text-white font-semibold px-6 py-2 rounded hover:bg-green-600 transition">Send</button>
            </div>

            <div class="text-center mt-8">
                <h3 class="text-green-600 font-semibold text-lg">Want to order groceries while hiring a maid?</h3>
                <p>Click below to explore the grocery order page and make your life even easier!</p>
                <a href="grocery-list.php"
                    class="inline-block mt-2 bg-yellow-500 text-white font-semibold px-6 py-2 rounded hover:bg-yellow-600 transition">
                    Visit Grocery Order Page
                </a>
            </div>

        </form>
    </div>

    <?php include_once('includes/footer.php'); ?>
</body>

</html>
