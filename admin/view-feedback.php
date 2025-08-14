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
<title>Maid Hiring Management System || Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="flex min-h-screen bg-gray-100">
    <?php include_once('includes/sidebar.php'); ?>
    <div class="flex-1 flex flex-col">
        <?php include_once('includes/header.php'); ?>
        <main class="flex-1 p-6 md:p-10">
            <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Customer Feedbacks</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <?php if (!empty($feedbackResults)): ?>
                    <?php foreach ($feedbackResults as $feedback): ?>
                        <div class="bg-white rounded-xl shadow-lg p-6 flex flex-col justify-between hover:-translate-y-1 hover:shadow-2xl transition">
                            <div>
                                <h4 class="text-lg font-semibold text-green-700 mb-2"><?= htmlspecialchars($feedback->Email) ?></h4>
                                <p class="text-yellow-500 text-base mb-2">
                                    <?= str_repeat('⭐', (int)$feedback->Rating) ?>
                                    <span class="text-gray-500">(<?= htmlspecialchars($feedback->Rating) ?>/5)</span>
                                </p>
                                <div class="text-gray-700 text-base mb-4">
                                    <?= htmlspecialchars($feedback->Feedback) ?>
                                </div>
                            </div>
                            <div class="text-right text-xs text-gray-400">
                                <?= date("F j, Y, g:i a", strtotime($feedback->Created_Time)) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-full text-center text-lg text-gray-500 py-10">
                        No feedback available yet.
                    </div>
                <?php endif; ?>
            </div>
        </main>
        <?php include_once('includes/footer.php'); ?>
    </div>
</div>
</body>
</html>
