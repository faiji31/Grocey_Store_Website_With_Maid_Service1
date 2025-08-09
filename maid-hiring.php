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

// Fetch and persist the 'area' parameter
if (isset($_GET['area']) && !empty($_GET['area'])) {
    $_SESSION['areaName'] = htmlspecialchars($_GET['area']);
}

// Retrieve the area name from the session
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

// Form submission logic
if (isset($_POST['submit'])) {
    $catid = $_POST['catid'];
    $name = $user->UserName; // Fetching name from user information
    $contno = $user->UserMobile; // Fetching mobile number from user information
    $email = $user->UserEmail; // Fetching email from user information
    $address = $user->UserAddress; // Fetching address from user information
    $gender = $user->Gender; // Fetching gender from user information
    $wsf = $_POST['wsf'];
    $wst = $_POST['wst'];
    $startdate = $_POST['startdate'];
    $notes = $_POST['notes'];
    $areaname = htmlspecialchars($_POST['areaName']); // Fetch from input field
    $bookingid = mt_rand(100000000, 999999999);

    // Updated SQL Query
    $sql = "INSERT INTO tblmaidbooking (BookingID, CatID, Name, ContactNumber, Email, Address, Gender, WorkingShiftFrom, WorkingShiftTo, StartDate, Notes, AreaName)
            VALUES (:bookingid, :catid, :name, :contno, :email, :address, :gender, :wsf, :wst, :startdate, :notes, :areaname)";

    // Prepare and bind parameters
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

    // Execute and check insertion
    if ($query->execute()) {
        echo '<script>alert("Your Booking Request Has Been Sent. We Will Contact You Soon.");</script>';
        echo "<script>window.location.href='order-list.php';</script>";
    } else {
        echo '<script>alert("Something Went Wrong. Please try again.");</script>';
    }
}
?>

<!doctype html>
<html>

<head>
    <title>Maid Hiring Management System || Hiring Form</title>
    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php include_once('includes/header.php'); ?>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title text-center text-primary display-1 mt-4">Looking To Hire A Maid?</h2>
                    <p class="text-center text-success">Post Your Requirement Below</p>
                </div>
                <div class="col-lg-8 offset-lg-2">
                    <form class="form-contact contact_form" action="" method="post">
                    <div class="row">
    <!-- Left column -->
    <div class="col-sm-6">
        <div class="form-group">
            <label class="text-danger font-weight-bold">Name:</label>
            <input class="form-control" name="name" id="name" type="text" value="<?php echo htmlentities($user->UserName); ?>" readonly>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="text-danger font-weight-bold">Contact Number:</label>
            <input class="form-control" name="contno" id="contno" type="text" value="<?php echo htmlentities($user->UserMobile); ?>" readonly>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="text-danger font-weight-bold">Email:</label>
            <input class="form-control" name="email" id="email" type="email" value="<?php echo htmlentities($user->UserEmail); ?>" readonly>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="text-danger font-weight-bold">Area Name:</label>
            <select class="form-control" name="areaName" id="areaName" required>
                <option value="">-- Select Area --</option>
                <option value="Basundhara R/A" <?php echo ($areaName == "Basundhara R/A") ? 'selected' : ''; ?>>Basundhara R/A</option>
                <option value="Banani" <?php echo ($areaName == "Banani") ? 'selected' : ''; ?> disabled>Banani</option>
                <option value="Gulshan" <?php echo ($areaName == "Gulshan") ? 'selected' : ''; ?>>Gulshan</option>
                <option value="Badda" <?php echo ($areaName == "Badda") ? 'selected' : ''; ?> disabled>Badda</option>
                <option value="Uttara" <?php echo ($areaName == "Uttara") ? 'selected' : ''; ?>>Uttara</option>
            </select>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <label class="text-danger font-weight-bold">Address Details:</label>
            <textarea class="form-control" name="address" id="address" readonly><?php echo htmlentities($user->UserAddress); ?></textarea>
        </div>
    </div>
</div>

<div class="row">
    <!-- Right column -->
    <div class="col-sm-6">
        <div class="form-group">
            <label class="text-danger font-weight-bold">Select Service:</label>
            <select name="catid" class="form-control" required>
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
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="text-danger font-weight-bold">Work Shift From:</label>
            <input class="form-control" name="wsf" id="wsf" type="time" required>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="text-danger font-weight-bold">Work Shift To:</label>
            <input class="form-control" name="wst" id="wst" type="time" required>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="text-danger font-weight-bold">Start Date:</label>
            <input class="form-control" name="startdate" id="startdate" type="date" required>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <label class="text-danger font-weight-bold">Notes:</label>
            <textarea class="form-control" name="notes" id="notes" placeholder="Enter some notes"></textarea>
        </div>
    </div>
</div>

                        <div class="form-group mt-3 text-center">
                            <button type="submit" class="btn btn-primary" name="submit">Send</button>
                        </div>

                        <!-- Visit Grocery Page Button -->
<div class="text-center mt-5">
    <h3 class="text-success">Want to order groceries while hiring a maid?</h3>
    <p>Click below to explore the grocery order page and make your life even easier!</p>
    <a id="groceryOrderButton" 
       href="grocery-list.php" 
       class="btn btn-warning btn-lg" 
       data-default-url="grocery-list.php">
        Visit Grocery Order Page
    </a>
</div>


                    </form>
                </div>
            </div>
        </div>

    <?php include_once('includes/footer.php'); ?>
    <script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
</body>
</html>
