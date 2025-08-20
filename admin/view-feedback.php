<?php
session_start();
include('includes/dbconnection.php');

// Redirect to login if not logged in
if (strlen($_SESSION['mhmsaid'] == 0)) {
    header('location:logout.php');
} else {
    // Fetch all feedbacks from the database
    $sqlFeedback = "SELECT * FROM feedback ORDER BY Created_Time DESC";
    $queryFeedback = $dbh->prepare($sqlFeedback);
    $queryFeedback->execute();
    $feedbackResults = $queryFeedback->fetchAll(PDO::FETCH_OBJ);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Grocery Store and Maid Service Website || Dashboard</title>
      <link rel="stylesheet" href="css/bootstrap.min.css" />
      <link rel="stylesheet" href="style.css" />
      <link rel="stylesheet" href="css/responsive.css" />
      <link rel="stylesheet" href="css/colors.css" />
      <link rel="stylesheet" href="css/bootstrap-select.css" />
      <link rel="stylesheet" href="css/perfect-scrollbar.css" />
      <link rel="stylesheet" href="css/custom.css" />
      <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <style>
        body {
            background-color: #f9f9f9;
        }
        .feedback-page {
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .feedback-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .feedback-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }
        .feedback-header h4 {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .feedback-rating {
            font-size: 1rem;
            color: #ffc107;
        }
        .feedback-body {
            font-size: 1rem;
            color: #555;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .feedback-footer {
            text-align: right;
            font-size: 0.85rem;
            color: #888;
        }
        .page-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }
        .no-feedback {
            text-align: center;
            font-size: 1.2rem;
            color: #666;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<?php include_once('includes/sidebar.php'); ?>
<div id="content">
    <?php include_once('includes/header.php'); ?>

    <div class="feedback-page">
        <div class="page-title">Customer Feedbacks</div>
        <div class="row">
            <?php if (!empty($feedbackResults)): ?>
                <?php foreach ($feedbackResults as $feedback): ?>
                    <div class="col-md-6 col-lg-4 d-flex justify-content-center mx-auto">
                        <div class="feedback-card">
                            <div class="feedback-header">
                                <h4><?= htmlspecialchars($feedback->Email) ?></h4>
                                <p class="feedback-rating">
                                    <?= str_repeat('⭐', (int)$feedback->Rating) ?>
                                    <span>(<?= htmlspecialchars($feedback->Rating) ?>/5)</span>
                                </p>
                            </div>
                            <div class="feedback-body">
                                <p><?= htmlspecialchars($feedback->Feedback) ?></p>
                            </div>
                            <div class="feedback-footer">
                                <p><?= date("F j, Y, g:i a", strtotime($feedback->Created_Time)) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="no-feedback">No feedback available yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include_once('includes/footer.php'); ?>
</div>

     <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/animate.js"></script>
      <script src="js/bootstrap-select.js"></script>
      <script src="js/perfect-scrollbar.min.js"></script>
      <script src="js/custom.js"></script>
</body>
</html>
