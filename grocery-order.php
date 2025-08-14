<?php
// Include database connection
include('includes/dbconnection.php');

try {
    if(isset($_POST['submit'])) {
        // Get form data
        $username = htmlspecialchars($_POST['username']);
        $deliveryTime = htmlspecialchars($_POST['deliveryTime']);
        $orderDetails = htmlspecialchars($_POST['orderDetails']);
        $fullArea = htmlspecialchars($_POST['fullArea']);
        $phoneNumber = htmlspecialchars($_POST['phoneNumber']);

        // Insert form data into the table
        $insertSQL = "
            INSERT INTO tblgrocerybooking (UserName, DeliveryTime, OrderDetails, FullArea, PhoneNumber)
            VALUES (:username, :deliveryTime, :orderDetails, :fullArea, :phoneNumber)
        ";
        $stmt = $dbh->prepare($insertSQL);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':deliveryTime', $deliveryTime, PDO::PARAM_STR);
        $stmt->bindParam(':orderDetails', $orderDetails, PDO::PARAM_STR);
        $stmt->bindParam(':fullArea', $fullArea, PDO::PARAM_STR);
        $stmt->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
        $stmt->execute();

        echo '<script>alert("Order placed successfully!"); window.location.href="index.php";</script>';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Order Form</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-3xl font-bold text-center text-green-600 mb-6">Grocery Order Form</h2>
        <form method="POST" action="" class="space-y-5">

            <!-- UserName -->
            <div>
                <label for="username" class="block text-red-600 font-semibold mb-1">Full Name</label>
                <input type="text" id="username" name="username" placeholder="Enter your full name" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Delivery Time -->
            <div>
                <label for="deliveryTime" class="block text-red-600 font-semibold mb-1">Preferred Delivery Time</label>
                <input type="datetime-local" id="deliveryTime" name="deliveryTime" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Order Details -->
            <div>
                <label for="orderDetails" class="block text-red-600 font-semibold mb-1">Order Details</label>
                <textarea id="orderDetails" name="orderDetails" rows="4" placeholder="List the items you want to order" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500"></textarea>
            </div>

            <!-- Full Area -->
            <div>
                <label for="fullArea" class="block text-red-600 font-semibold mb-1">Delivery Address</label>
                <textarea id="fullArea" name="fullArea" rows="3" placeholder="Enter your full delivery address" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500"></textarea>
            </div>

            <!-- Phone Number -->
            <div>
                <label for="phoneNumber" class="block text-red-600 font-semibold mb-1">Phone Number</label>
                <input type="tel" id="phoneNumber" name="phoneNumber" placeholder="Enter your phone number" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" name="submit"
                    class="bg-green-500 text-white font-semibold px-6 py-2 rounded hover:bg-green-600 transition">
                    Submit Order
                </button>
            </div>
        </form>
    </div>

</body>
</html>
