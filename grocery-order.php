<?php
// Include database connection
include('includes/dbconnection.php');

try {
    // Create the table if it does not exist
    

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

        echo "Order placed successfully!";
        echo "<script>window.location.href='index.php';</script>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
;?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Order Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Grocery Order Form</h2>
        <form method="POST" action="">
            <!-- UserName -->
            <div class="mb-3">
                <label for="username" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your full name" required>
            </div>

            <!-- Delivery Time -->
            <div class="mb-3">
                <label for="deliveryTime" class="form-label">Preferred Delivery Time</label>
                <input type="datetime-local" class="form-control" id="deliveryTime" name="deliveryTime" required>
            </div>

            <!-- Order Details -->
            <div class="mb-3">
                <label for="orderDetails" class="form-label">Order Details</label>
                <textarea class="form-control" id="orderDetails" name="orderDetails" rows="4" placeholder="List the items you want to order" required></textarea>
            </div>

            <!-- Full Area -->
            <div class="mb-3">
                <label for="fullArea" class="form-label">Delivery Address</label>
                <textarea class="form-control" id="fullArea" name="fullArea" rows="3" placeholder="Enter your full delivery address" required></textarea>
            </div>

            <!-- Phone Number -->
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter your phone number" required>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary" name="submit">Submit Order</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
