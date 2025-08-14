<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grocery Store and Maid Service Management System || Home Page</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen">
    <?php include_once('includes/header.php'); ?>
    <main>
<!-- Hero Section -->
<section class="relative h-80 md:h-[28rem] flex items-center justify-center bg-cover bg-center mb-10" style="background-image: url('assets/img/hero/home-hero.jpg');">
    <div class="absolute inset-0 bg-gradient-to-r from-green-800/80 to-green-400/60"></div>
    <div class="relative z-10 text-center px-4">
        <h1 class="text-white text-4xl md:text-5xl font-extrabold drop-shadow mb-4 uppercase flex items-center justify-center gap-2">
            <svg class="w-10 h-10 inline-block text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 7h18M3 12h18M3 17h18"/></svg>
            Smart Grocery Store & Maid Services
        </h1>
        <p class="text-white text-lg md:text-2xl font-medium drop-shadow mb-4">Experience a wide range of grocery and household solutions tailored to your needs!</p>
        <a href="javascript:void(0);" id="sliderOrderServiceButton" class="inline-block bg-black text-white font-bold px-8 py-3 rounded-full shadow-lg hover:bg-green-700 transition text-lg">Order Grocery & Maid Service</a>
    </div>
</section>

<!-- Service Search Section -->
<section class="py-12">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">Available Grocery & Maid Services</h2>
        <form method="GET" action="" class="bg-white rounded-xl shadow-lg p-6 mb-8 flex flex-col md:flex-row items-center gap-4">
            <label for="area" class="block text-green-700 font-semibold mb-1 md:mb-0">Select Preferred Area:</label>
            <select name="area" id="area" class="w-full md:w-64 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition shadow-sm" required>
                <option value="" <?= empty($_GET['area']) ? 'selected' : '' ?>>-- Select Area --</option>
                <option value="Basundhara R/A" <?= (isset($_GET['area']) && $_GET['area'] == 'Basundhara R/A') ? 'selected' : '' ?>>Basundhara R/A</option>
                <option value="Banani" <?= (isset($_GET['area']) && $_GET['area'] == 'Banani') ? 'selected' : '' ?>>Banani</option>
                <option value="Gulshan" <?= (isset($_GET['area']) && $_GET['area'] == 'Gulshan') ? 'selected' : '' ?>>Gulshan</option>
                <option value="Uttara" <?= (isset($_GET['area']) && $_GET['area'] == 'Uttara') ? 'selected' : '' ?>>Uttara</option>
                <option value="Badda" <?= (isset($_GET['area']) && $_GET['area'] == 'Badda') ? 'selected' : '' ?>>Badda</option>
            </select>
            <button type="submit" class="bg-gradient-to-r from-green-500 to-green-700 text-white font-bold px-8 py-2 rounded-full shadow-lg hover:from-green-600 hover:to-green-800 transition text-lg">Search</button>
        </form>
        <div>
            <?php
            if (isset($_GET['area']) && !empty($_GET['area'])) {
                $area = htmlspecialchars($_GET['area']);
                $sql = "SELECT COUNT(*) AS MaidCount FROM tblmaid WHERE Area = :area";
                $query = $dbh->prepare($sql);
                $query->bindValue(':area', $area, PDO::PARAM_STR);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_OBJ);
                $maidCount = $result->MaidCount;
                if ($maidCount > 0): ?>
                    <div class="text-center bg-green-50 border border-green-200 rounded-xl p-6 mb-4">
                        <p class="text-green-700 text-lg mb-2">
                            Grocery Store and Maid Service is available in <span class="font-bold"><?= $area ?></span>.<br>
                            <span class="font-bold text-green-900 text-xl"><?= $maidCount ?></span> maid(s) work in this area.
                        </p>
                        <a href="javascript:void(0);" id="searchOrderServiceButton" class="inline-block bg-green-600 text-white font-bold px-6 py-2 rounded-full shadow hover:bg-green-800 transition mr-2">Order Grocery & Maid Service</a>
                        <a href="grocery-list.php?area=<?= urlencode($area) ?>" class="inline-block bg-blue-600 text-white font-bold px-6 py-2 rounded-full shadow hover:bg-blue-800 transition">Visit Grocery Page</a>
                    </div>
                <?php else: ?>
                    <div class="text-center bg-red-50 border border-red-200 rounded-xl p-6 mb-4">
                        <p class="text-red-700 text-lg">Grocery Store and Maid Service is not available in <span class="font-bold"><?= $area ?></span>.</p>
                    </div>
                <?php endif;
            } else { ?>
                <div class="text-center bg-gray-50 border border-gray-200 rounded-xl p-6 mb-4">
                    <p class="text-gray-500 text-lg">Please select an area to see available grocery store and maid services.</p>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

    </main>
    <?php include_once('includes/footer.php'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const area = new URLSearchParams(window.location.search).get('area'); // Get area from the URL

            // Slider Order Service Button
            const sliderOrderServiceButton = document.getElementById('sliderOrderServiceButton');
            sliderOrderServiceButton.addEventListener('click', function () {
                handleOrderService(area);
            });

            // Search Results Order Service Button
            const searchOrderServiceButton = document.getElementById('searchOrderServiceButton');
            if (searchOrderServiceButton) {
                searchOrderServiceButton.addEventListener('click', function () {
                    handleOrderService(area);
                });
            }

            // Function to handle redirection based on sessionStorage
            function handleOrderService(area) {
                const email = sessionStorage.getItem('email');
                if (email) {
                    // Redirect to maid-hiring.php with the area parameter
                    window.location.href = `maid-hiring.php?area=${encodeURIComponent(area)}`;
                } else {
                    // Redirect to login.php with the area parameter
                    alert('Please login to continue.');
                    window.location.href = `login.php?area=${encodeURIComponent(area)}`;
                }
            }
        });
    </script>
</body>
</html>
