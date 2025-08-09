<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    // Validate date inputs
    if (!$startDate || !$endDate) {
        $_SESSION['error'] = "Please select both start and end dates.";
        header("Location: sale-report.php");
        exit();
    }

    // Fetch data from tblmaidbooking
    $sqlMaid = "SELECT * FROM tblmaidbooking WHERE BookingDate BETWEEN :startDate AND :endDate";
    $queryMaid = $dbh->prepare($sqlMaid);
    $queryMaid->bindParam(':startDate', $startDate, PDO::PARAM_STR);
    $queryMaid->bindParam(':endDate', $endDate, PDO::PARAM_STR);
    $queryMaid->execute();
    $maidOrders = $queryMaid->fetchAll(PDO::FETCH_ASSOC);

    // Fetch data from tblgrocerybooking
    $sqlGrocery = "SELECT * FROM tblgrocerybooking WHERE CreatedTime BETWEEN :startDate AND :endDate";
    $queryGrocery = $dbh->prepare($sqlGrocery);
    $queryGrocery->bindParam(':startDate', $startDate, PDO::PARAM_STR);
    $queryGrocery->bindParam(':endDate', $endDate, PDO::PARAM_STR);
    $queryGrocery->execute();
    $groceryOrders = $queryGrocery->fetchAll(PDO::FETCH_ASSOC);

    // Prepare CSV data
    $fileName = "sale_report_{$startDate}_to_{$endDate}.csv";
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=\"$fileName\"");

    $output = fopen('php://output', 'w');
    fputcsv($output, ["Order Type", "ID", "Name", "Contact", "Area", "Details", "Date", "Status"]);

    // Add maid orders to CSV
    foreach ($maidOrders as $order) {
        fputcsv($output, [
            "Maid Booking",
            $order['BookingID'],
            $order['Name'],
            $order['ContactNumber'],
            $order['AreaName'],
            $order['Notes'],
            $order['BookingDate'],
            $order['Status']
        ]);
    }

    // Add grocery orders to CSV
    foreach ($groceryOrders as $order) {
        fputcsv($output, [
            "Grocery Booking",
            $order['ID'],
            $order['UserName'],
            $order['PhoneNumber'],
            $order['AreaName'],
            $order['OrderDetails'],
            $order['CreatedTime'],
            $order['Status']
        ]);
    }

    fclose($output);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Generate Sales Report</h2>

        <!-- Error Messages -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="sale-report.php">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" required>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success px-5">Download Report</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
