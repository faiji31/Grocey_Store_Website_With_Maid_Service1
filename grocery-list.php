<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Redirect to login page if email is not set in the session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
        // Pass area to login.php
        $areaName = htmlspecialchars($_POST['AreaName'] ?? ''); // Fetch area from the form submission
        header("Location: login.php?area=" . urlencode($areaName));
        exit();
    }

    // Retrieve form data
    $userName = htmlspecialchars($_POST['UserName']);
    $phoneNumber = htmlspecialchars($_POST['PhoneNumber']);
    $fullArea = htmlspecialchars($_POST['FullArea']);
    $areaName = htmlspecialchars($_POST['AreaName']);
    $deliveryTime = htmlspecialchars($_POST['DeliveryTime']);
    $orderDetails = htmlspecialchars($_POST['OrderDetails']);

    try {
        // Insert data into tblgrocerybooking
        $sql = "INSERT INTO tblgrocerybooking (UserName, PhoneNumber, FullArea, AreaName, DeliveryTime, OrderDetails) 
                VALUES (:userName, :phoneNumber, :fullArea, :areaName, :deliveryTime, :orderDetails)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':userName', $userName, PDO::PARAM_STR);
        $query->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
        $query->bindParam(':fullArea', $fullArea, PDO::PARAM_STR);
        $query->bindParam(':areaName', $areaName, PDO::PARAM_STR);
        $query->bindParam(':deliveryTime', $deliveryTime, PDO::PARAM_STR);
        $query->bindParam(':orderDetails', $orderDetails, PDO::PARAM_STR);

        $query->execute();

        // Set success message and order summary in session
        $_SESSION['success'] = "Your order has been placed successfully!";
        $_SESSION['order_summary'] = [
            'UserName' => $userName,
            'PhoneNumber' => $phoneNumber,
            'FullArea' => $fullArea,
            'AreaName' => $areaName,
            'DeliveryTime' => $deliveryTime,
            'OrderDetails' => $orderDetails
        ];
        echo "<script>
            alert('Your order has been placed successfully!');
            setTimeout(() => {
                window.location.href = 'order-list.php';
            }, 2000);
        </script>";
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "There was an error processing your order. Please try again.";
        header("Location: grocery-list.php?area=" . urlencode($areaName));
        exit();
    }
}

// Get AreaName from URL
$areaName = isset($_GET['area']) ? htmlspecialchars($_GET['area']) : '';
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
<title>Maid Hiring Management System || Home Page</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    
    <!-- External Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">

    <!-- External Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .grocery-page {
            display: flex;
            flex-direction: row;
            gap: 20px;
        }
        .grocery-list {
            width: 65%;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
        }
        .order-form {
            width: 35%;
            padding: 20px;
            background: #e9ecef;
            border-radius: 8px;
        }
        .single-product {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 20px;
            background: #fff;
        }
        .single-product img {
            max-height: 150px;
            margin-bottom: 10px;
        }
        .order-summary {
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 15px;
            width: 80%;
            max-width: 600px;
            display: none;
        }
    </style>
</head>
<body>
<?php include_once('includes/header.php'); ?>
<main>
    <div class="container">
        <!-- Display Order Summary -->
        <?php if (isset($_SESSION['success']) && isset($_SESSION['order_summary'])): ?>
            <div class="order-summary" id="order-summary">
                <h4 class="text-center">Order Summary</h4>
                <p><strong>Name:</strong> <?= htmlspecialchars($_SESSION['order_summary']['UserName']) ?></p>
                <p><strong>Phone Number:</strong> <?= htmlspecialchars($_SESSION['order_summary']['PhoneNumber']) ?></p>
                <p><strong>Delivery Address:</strong> <?= htmlspecialchars($_SESSION['order_summary']['FullArea']) ?></p>
                <p><strong>Area Name:</strong> <?= htmlspecialchars($_SESSION['order_summary']['AreaName']) ?></p>
                <p><strong>Preferred Delivery Time:</strong> <?= htmlspecialchars($_SESSION['order_summary']['DeliveryTime']) ?></p>
                <p><strong>Order Details:</strong> <?= nl2br(htmlspecialchars($_SESSION['order_summary']['OrderDetails'])) ?></p>
            </div>
            <?php unset($_SESSION['success'], $_SESSION['order_summary']); ?>
        <?php endif; ?>

        <div class="grocery-page">
            <!-- Grocery Items -->
            <div class="grocery-list">
                <h2 class="text-center" style="color: green;">Available Grocery Items</h2>
                <div class="row">
                    <?php
                    $sql = "SELECT * FROM tblgrocery";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    if ($query->rowCount() > 0):
                        foreach ($results as $row): ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-product">
                                    <img src="<?= htmlspecialchars($row->ImagePath) ?>" alt="<?= htmlspecialchars($row->ProductName) ?>" class="img-fluid">
                                    <div class="product-details">
                                        <h4><?= htmlspecialchars($row->ProductName) ?></h4>
                                        <p><?= htmlspecialchars($row->Description) ?></p>
                                        <p><strong>Price: <?= htmlspecialchars($row->Price) ?> BDT </strong></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center">
                            <p>No grocery items available.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Grocery Order Form -->
            <div class="order-form">
                <h2 class="text-center" style="color: blue;">Place Your Order</h2>
                <form method="POST" action="" id="orderForm">
                    <div class="mb-3">
                        <label for="UserName" class="form-label">Your Name:</label>
                        <input type="text" class="form-control" id="UserName" name="UserName" placeholder="Enter your full name" required>
                    </div>
                    <div class="mb-3">
                        <label for="PhoneNumber" class="form-label">Phone Number:</label>
                        <input type="text" class="form-control" id="PhoneNumber" name="PhoneNumber" placeholder="Enter your phone number" required pattern="[0-9]{11}">
                    </div>
                    <div class="mb-3">
                        <label for="FullArea" class="form-label">Delivery Address:</label>
                        <textarea class="form-control" id="FullArea" name="FullArea" rows="3" required placeholder="Enter your full delivery address"></textarea>
                    </div>
                    <div class="mb-3">
    <label for="AreaName" class="form-label">Area Name:</label>
    <select class="form-control" id="AreaName" name="AreaName" required>
        <option value="">-- Select Area --</option>
        <option value="Basundhara R/A" <?php echo ($areaName == "Basundhara R/A") ? 'selected' : ''; ?>>Basundhara R/A</option>
        <option value="Banani" <?php echo ($areaName == "Banani") ? 'selected' : ''; ?> disabled>Banani</option>
        <option value="Gulshan" <?php echo ($areaName == "Gulshan") ? 'selected' : ''; ?>>Gulshan</option>
        <option value="Badda" <?php echo ($areaName == "Badda") ? 'selected' : ''; ?> disabled>Badda</option>
        <option value="Uttara" <?php echo ($areaName == "Uttara") ? 'selected' : ''; ?>>Uttara</option>
    </select>
</div>

                    <div class="mb-3">
                        <label for="DeliveryTime" class="form-label">Preferred Delivery Time:</label>
                        <input type="time" class="form-control" id="DeliveryTime" name="DeliveryTime" required>
                    </div>
                    <div class="mb-3">
                        <label for="OrderDetails" class="form-label">Order Details:</label>
                        <textarea class="form-control" id="OrderDetails" name="OrderDetails" rows="4" placeholder="Rice - 1kg, Sugar - 1kg, Milk - 1L" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Place Order</button>
                </form>
            </div>
        </div>
    </div>
</main>
<?php include_once('includes/footer.php'); ?>

<script>
    // Validate sessionStorage email key before submitting form
    document.getElementById('orderForm').addEventListener('submit', function (e) {
        if (!sessionStorage.getItem('email')) {
            e.preventDefault();
            const areaName = document.getElementById('AreaName').value;
            window.location.href = `login.php?area=${encodeURIComponent(areaName)}`;
        }

        else{
            alert('Order placed successfully!');
        }
    });
</script>

<script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>
<script src="./assets/js/main.js"></script>
</body>
</html>
