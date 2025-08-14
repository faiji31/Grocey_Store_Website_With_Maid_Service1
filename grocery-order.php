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

<body class="bg-gray-50 text-gray-800 min-h-screen">
    <!-- Hero Section -->
    <section class="relative h-56 md:h-72 flex items-center justify-center bg-cover bg-center mb-8" style="background-image: url('assets/img/hero/grocery.jpg');">
        <div class="absolute inset-0 bg-gradient-to-r from-green-800/80 to-green-400/60"></div>
        <div class="relative z-10 text-center px-4">
            <h1 class="text-white text-4xl md:text-5xl font-extrabold drop-shadow mb-2 flex items-center justify-center gap-2">
                <svg class="w-10 h-10 inline-block text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 7h18M3 12h18M3 17h18"/></svg>
                Grocery Order
            </h1>
            <p class="text-white text-lg md:text-xl font-medium drop-shadow">Order fresh groceries delivered to your doorstep</p>
        </div>
    </section>

    <div class="max-w-2xl mx-auto p-6 bg-white shadow-2xl rounded-2xl border border-green-100">
        <h2 class="text-3xl font-bold text-center text-green-700 mb-2">Place Your Grocery Order</h2>
        <p class="text-center text-gray-500 mb-6">Fill in the details below and get your groceries delivered fast and fresh!</p>
        <form method="POST" action="" class="space-y-6">
            <!-- UserName -->
            <div>
                <label for="username" class="block text-green-700 font-semibold mb-1">Full Name</label>
                <div class="relative">
                    <input type="text" id="username" name="username" placeholder="Enter your full name" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
                    <span class="absolute right-3 top-2.5 text-green-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                    </span>
                </div>
            </div>
            <!-- Delivery Time -->
            <div>
                <label for="deliveryTime" class="block text-green-700 font-semibold mb-1">Preferred Delivery Time</label>
                <input type="datetime-local" id="deliveryTime" name="deliveryTime" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
            </div>
            <!-- Order Details -->
            <div>
                <label for="orderDetails" class="block text-green-700 font-semibold mb-1">Order Details</label>
                <textarea id="orderDetails" name="orderDetails" rows="4" placeholder="List the items you want to order (e.g. 2kg rice, 1L milk, 6 apples)" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm"></textarea>
            </div>
            <!-- Full Area -->
            <div>
                <label for="fullArea" class="block text-green-700 font-semibold mb-1">Delivery Address</label>
                <textarea id="fullArea" name="fullArea" rows="3" placeholder="Enter your full delivery address" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm"></textarea>
            </div>
            <!-- Phone Number -->
            <div>
                <label for="phoneNumber" class="block text-green-700 font-semibold mb-1">Phone Number</label>
                <input type="tel" id="phoneNumber" name="phoneNumber" placeholder="Enter your phone number" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm">
            </div>
            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" name="submit"
                    class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-8 py-3 rounded-full shadow-lg hover:from-green-600 hover:to-green-800 transition text-lg flex items-center gap-2 mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                    Submit Order
                </button>
            </div>
        </form>
        <div class="mt-8 text-center text-gray-400 text-xs">
            <span>We value your privacy. Your information is safe with us.</span>
        </div>
    </div>

</body>
</html>
