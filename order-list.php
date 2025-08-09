<?php
session_start();
include('includes/dbconnection.php');

// Fetch orders from tblmaidbooking
$sqlMaid = "SELECT *, TIMESTAMPDIFF(MINUTE, UpdatedTime, NOW()) AS MessageTime FROM tblmaidbooking WHERE Email = :email ORDER BY BookingDate DESC";
$queryMaid = $dbh->prepare($sqlMaid);
$queryMaid->bindParam(':email', $_SESSION['email'], PDO::PARAM_STR);
$queryMaid->execute();
$maidOrders = $queryMaid->fetchAll(PDO::FETCH_OBJ);

// Fetch orders from tblgrocerybooking
$sqlGrocery = "SELECT *, TIMESTAMPDIFF(MINUTE, UpdatedTime, NOW()) AS MessageTime FROM tblgrocerybooking WHERE Email = :email ORDER BY ID DESC";
$queryGrocery = $dbh->prepare($sqlGrocery);
$queryGrocery->bindParam(':email', $_SESSION['email'], PDO::PARAM_STR);
$queryGrocery->execute();
$groceryOrders = $queryGrocery->fetchAll(PDO::FETCH_OBJ);

function getStatusClass($status) {
    $status = strtolower(trim($status));
    switch ($status) {
        case 'approved':
            return 'status-approved';
        case 'cancelled':
            return 'status-cancelled';
        case 'completed':
            return 'status-completed';
        case 'handedovert':
            return 'status-handedover';
        default:
            return 'status-processing';
    }
}

function getStatusIcon($status) {
    $status = strtolower(trim($status));
    switch ($status) {
        case 'approved':
            return '🚌';
        case 'cancelled':
            return '😢';
        case 'completed':
            return '✅';
        case 'handedovert':
            return '📦';
        default:
            return '⏳';
    }
}

function getStatusMessage($status) {
    $status = strtolower(trim($status));
    switch ($status) {
        case 'approved':
            return 'A Maid is Being Assigned, Please wait 30-45 minutes.';
        case 'cancelled':
            return 'Unfortunately, we had to cancel your request, please contact our customer care for further updates.';
        case 'completed':
            return 'Your request has been completed. We hope you enjoyed our service.';
        case 'handedovert':
            return 'A maid will be reaching your location with the order within 30-45 minutes.';
        default:
            return 'Your request is under process. Please wait for further updates.';
    }
}

// Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_feedback'])) {
    $email = $_SESSION['email'];
    $feedback = $_POST['feedback'];
    $rating = $_POST['rating'];
    $orderId = $_POST['order_id'];

    $sqlFeedback = "INSERT INTO feedback (Email, Feedback, Rating, Created_Time, Updated_Time) 
                    VALUES (:email, :feedback, :rating, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
    $queryFeedback = $dbh->prepare($sqlFeedback);
    $queryFeedback->bindParam(':email', $email, PDO::PARAM_STR);
    $queryFeedback->bindParam(':feedback', $feedback, PDO::PARAM_STR);
    $queryFeedback->bindParam(':rating', $rating, PDO::PARAM_INT);
    $queryFeedback->execute();

    $_SESSION['success_msg'] = 'Feedback submitted successfully!';
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Order Status</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Maid Hiring Management System || Hiring Form</title>
    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .order-status {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            color: #fff;
            transition: transform 0.2s ease;
        }
        .order-status:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .status-approved { background-color: yellow; color: #333; }
        .status-cancelled { background-color: red; }
        .status-completed { background-color: rgba(34, 34, 34, 0.34); }
        .status-handedover { background-color: blue; color: white; }
        .status-processing { background-color: rgba(33, 162, 134, 0.63); }
        .feedback-btn { margin-top: 10px; }
    </style>
</head>
<body>
<?php include_once('includes/header.php'); ?>
<div class="container">
    <h2 class="text-center my-5">Your Orders</h2>

    <?php if (isset($_SESSION['success_msg'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success_msg']) ?></div>
        <?php unset($_SESSION['success_msg']); ?>
    <?php endif; ?>

    <div class="row">
        <!-- Maid Booking Orders -->
        <div class="col-md-6">
            <h4 class="text-primary">Maid Booking Orders</h4>
            <?php if (!empty($maidOrders)): ?>
                <?php foreach ($maidOrders as $order): ?>
                    <div class="order-status <?= getStatusClass($order->Status) ?>">
                        <p><span class="status-icon"> <?= getStatusIcon($order->Status) ?> </span>
                        <strong>Booking ID:</strong> <?= htmlspecialchars($order->BookingID) ?></p>
                        <p><strong>Area:</strong> <?= htmlspecialchars($order->AreaName) ?></p>
                        <p><strong>Status:</strong> <?= htmlspecialchars($order->Status ?? 'On Process') ?></p>
                        <p><strong>Message Time:</strong> <?= htmlspecialchars($order->MessageTime) ?> minutes ago</p>
                        <p><?= getStatusMessage($order->Status) ?></p>
                        <?php if (strtolower($order->Status) === 'completed'): ?>
                            <form method="POST">
                                <textarea name="feedback" class="form-control mb-2" placeholder="Leave your feedback" required></textarea>
                                <select name="rating" class="form-control mb-2" required>
                                    <option value="" disabled selected>Rate the service</option>
                                    <option value="1">1 - Poor</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="3">3 - Good</option>
                                    <option value="4">4 - Very Good</option>
                                    <option value="5">5 - Excellent</option>
                                </select>
                                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order->BookingID) ?>">
                                <button type="submit" name="submit_feedback" class="btn btn-success feedback-btn">Submit Feedback</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No maid booking orders found.</p>
            <?php endif; ?>
        </div>

        <!-- Grocery Orders -->
        <div class="col-md-6">
            <h4 class="text-primary">Grocery Orders</h4>
            <?php if (!empty($groceryOrders)): ?>
                <?php foreach ($groceryOrders as $order): ?>
                    <div class="order-status <?= getStatusClass($order->Status) ?>">
                        <p><span class="status-icon"> <?= getStatusIcon($order->Status) ?> </span>
                        <strong>Order ID:</strong> <?= htmlspecialchars($order->ID) ?></p>
                        <p><strong>Area:</strong> <?= htmlspecialchars($order->AreaName) ?></p>
                        <p><strong>Status:</strong> <?= htmlspecialchars($order->Status ?? 'On Process') ?></p>
                        <p><strong>Message Time:</strong> <?= htmlspecialchars($order->MessageTime) ?> minutes ago</p>
                        <p><?= getStatusMessage($order->Status) ?></p>
                        <?php if (strtolower($order->Status) === 'completed'): ?>
                            <form method="POST">
                                <textarea name="feedback" class="form-control mb-2" placeholder="Leave your feedback" required></textarea>
                                <select name="rating" class="form-control mb-2" required>
                                    <option value="" disabled selected>Rate the service</option>
                                    <option value="1">1 - Poor</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="3">3 - Good</option>
                                    <option value="4">4 - Very Good</option>
                                    <option value="5">5 - Excellent</option>
                                </select>
                                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order->ID) ?>">
                                <button type="submit" name="submit_feedback" class="btn btn-success feedback-btn">Submit Feedback</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No grocery orders found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
