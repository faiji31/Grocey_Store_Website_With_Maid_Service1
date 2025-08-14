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
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery List | GroceryShop</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen">
<?php include_once('includes/header.php'); ?>
<main>
    <!-- Hero Section -->
    <section class="relative h-56 md:h-72 flex items-center justify-center bg-cover bg-center mb-8" style="background-image: url('assets/img/hero/grocery.jpg');">
        <div class="absolute inset-0 bg-gradient-to-r from-green-800/80 to-green-400/60"></div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-white text-4xl md:text-5xl font-extrabold drop-shadow mb-2 flex items-center justify-center gap-2">
                <svg class="w-10 h-10 inline-block text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 7h18M3 12h18M3 17h18"/></svg>
                Grocery List
            </h1>
            <p class="text-white text-lg md:text-xl font-medium drop-shadow">Browse and order fresh groceries delivered to your doorstep</p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Grocery Items -->
        <div class="md:col-span-2">
            <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">Available Grocery Items</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                $sql = "SELECT * FROM tblgrocery";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                if ($query->rowCount() > 0):
                    foreach ($results as $row): ?>
                        <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-4 flex flex-col items-center">
                            <img src="<?= htmlspecialchars($row->ImagePath) ?>" alt="<?= htmlspecialchars($row->ProductName) ?>" class="w-32 h-32 object-cover rounded mb-3 border border-green-100">
                            <h4 class="font-bold text-lg text-green-700 mb-1"><?= htmlspecialchars($row->ProductName) ?></h4>
                            <p class="text-gray-500 text-sm mb-2 text-center"><?= htmlspecialchars($row->Description) ?></p>
                            <span class="font-semibold text-green-600">Price: <?= htmlspecialchars($row->Price) ?> BDT</span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-3 text-center">
                        <p>No grocery items available.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Grocery Order Form -->
        <div class="bg-white rounded-2xl shadow-2xl border border-green-100 p-6 h-fit">
            <h2 class="text-2xl font-bold text-blue-700 mb-2 text-center">Place Your Order</h2>
            <form method="POST" action="" id="orderForm" class="space-y-4">
                <div>
                    <label for="UserName" class="block text-green-700 font-semibold mb-1">Your Name:</label>
                    <input type="text" id="UserName" name="UserName" placeholder="Enter your full name" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                </div>
                <div>
                    <label for="PhoneNumber" class="block text-green-700 font-semibold mb-1">Phone Number:</label>
                    <input type="text" id="PhoneNumber" name="PhoneNumber" placeholder="Enter your phone number" required pattern="[0-9]{11}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                </div>
                <div>
                    <label for="FullArea" class="block text-green-700 font-semibold mb-1">Delivery Address:</label>
                    <textarea id="FullArea" name="FullArea" rows="3" required placeholder="Enter your full delivery address"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm"></textarea>
                </div>
                <div>
                    <label for="AreaName" class="block text-green-700 font-semibold mb-1">Area Name:</label>
                    <select id="AreaName" name="AreaName" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                        <option value="">-- Select Area --</option>
                        <option value="Basundhara R/A" <?php echo ($areaName == "Basundhara R/A") ? 'selected' : ''; ?>>Basundhara R/A</option>
                        <option value="Banani" <?php echo ($areaName == "Banani") ? 'selected' : ''; ?> disabled>Banani</option>
                        <option value="Gulshan" <?php echo ($areaName == "Gulshan") ? 'selected' : ''; ?>>Gulshan</option>
                        <option value="Badda" <?php echo ($areaName == "Badda") ? 'selected' : ''; ?> disabled>Badda</option>
                        <option value="Uttara" <?php echo ($areaName == "Uttara") ? 'selected' : ''; ?>>Uttara</option>
                    </select>
                </div>
                <div>
                    <label for="DeliveryTime" class="block text-green-700 font-semibold mb-1">Preferred Delivery Time:</label>
                    <input type="time" id="DeliveryTime" name="DeliveryTime" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                </div>
                <div>
                    <label for="OrderDetails" class="block text-green-700 font-semibold mb-1">Order Details:</label>
                    <textarea id="OrderDetails" name="OrderDetails" rows="4" placeholder="Rice - 1kg, Sugar - 1kg, Milk - 1L" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm"></textarea>
                </div>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-8 py-3 rounded-full shadow-lg hover:from-green-600 hover:to-green-800 transition text-lg flex items-center gap-2 justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                    Place Order
                </button>
            </form>
        </div>
    </div>

    <!-- Order Summary -->
    <?php if (isset($_SESSION['success']) && isset($_SESSION['order_summary'])): ?>
        <div class="fixed top-6 left-1/2 -translate-x-1/2 z-50 bg-green-100 border border-green-300 text-green-800 rounded-xl shadow-lg px-8 py-6 w-full max-w-lg animate-fade-in">
            <h4 class="text-xl font-bold mb-2 text-center">Order Summary</h4>
            <p><span class="font-semibold">Name:</span> <?= htmlspecialchars($_SESSION['order_summary']['UserName']) ?></p>
            <p><span class="font-semibold">Phone Number:</span> <?= htmlspecialchars($_SESSION['order_summary']['PhoneNumber']) ?></p>
            <p><span class="font-semibold">Delivery Address:</span> <?= htmlspecialchars($_SESSION['order_summary']['FullArea']) ?></p>
            <p><span class="font-semibold">Area Name:</span> <?= htmlspecialchars($_SESSION['order_summary']['AreaName']) ?></p>
            <p><span class="font-semibold">Preferred Delivery Time:</span> <?= htmlspecialchars($_SESSION['order_summary']['DeliveryTime']) ?></p>
            <p><span class="font-semibold">Order Details:</span> <?= nl2br(htmlspecialchars($_SESSION['order_summary']['OrderDetails'])) ?></p>
        </div>
        <?php unset($_SESSION['success'], $_SESSION['order_summary']); ?>
    <?php endif; ?>
</main>
<?php include_once('includes/footer.php'); ?>

<script>
    // Validate sessionStorage email key before submitting form
    document.getElementById('orderForm').addEventListener('submit', function (e) {
        if (!sessionStorage.getItem('email')) {
            e.preventDefault();
            const areaName = document.getElementById('AreaName').value;
            window.location.href = `login.php?area=${encodeURIComponent(areaName)}`;
        } else {
            alert('Order placed successfully!');
        }
    });
</script>
</body>
</html>
