<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Maid Hiring Management System || About Us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    <?php include_once('includes/header.php');?>

    <main>
        <!-- Hero Section -->
        <section class="relative h-80 flex items-center justify-center bg-cover bg-center" style="background-image: url('assets/img/hero/about.jpg');">
            <div class="absolute inset-0 bg-gradient-to-r from-green-700/80 to-green-400/60"></div>
            <div class="relative z-10 text-center px-4">
                <h1 class="text-white text-5xl md:text-6xl font-extrabold drop-shadow mb-4">About GroceryShop & Maid Service</h1>
                <p class="text-white text-lg md:text-2xl font-medium drop-shadow mb-2">Your trusted partner for daily essentials and home help</p>
                <a href="grocery-list.php" class="inline-block mt-4 px-8 py-3 bg-white text-green-700 font-bold rounded-full shadow-lg hover:bg-green-100 transition">Shop Now</a>
            </div>
        </section>

        <!-- About Us Section -->
        <section class="py-16 bg-white">
            <div class="max-w-5xl mx-auto px-4 grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <img src="https://unsplash.com/photos/young-woman-buying-greens-at-local-market-shopping-fresh-local-raw-food-sustainability-and-organic-local-food-concept-ex9Kt8HXWXM" alt="About GroceryShop" class="rounded-2xl shadow-lg w-full object-cover h-72 md:h-96">
                </div>
                <div>
                    <h2 class="text-4xl font-bold text-green-700 mb-4">Who We Are</h2>
                    <p class="text-gray-700 text-lg mb-4">GroceryShop & Maid Service is dedicated to making your life easier. We offer a seamless online platform for ordering fresh groceries and hiring reliable, background-checked maids for your home. Our team is passionate about quality, convenience, and customer satisfaction.</p>
                    <ul class="list-disc pl-6 text-gray-600 space-y-2">
                        <li>Fresh groceries delivered to your doorstep</li>
                        <li>Trusted and verified maid services</li>
                        <li>Easy online ordering and secure payments</li>
                        <li>Friendly customer support</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-6xl mx-auto px-4">
                <h2 class="text-3xl md:text-4xl font-bold text-center text-green-700 mb-10">Why Choose Us?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center text-center hover:shadow-lg transition">
                        <svg class="w-12 h-12 text-green-500 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 7h18M3 12h18M3 17h18"/></svg>
                        <h3 class="font-bold text-xl mb-2">Wide Selection</h3>
                        <p class="text-gray-600">Choose from a variety of fresh groceries and household essentials, all in one place.</p>
                    </div>
                    <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center text-center hover:shadow-lg transition">
                        <svg class="w-12 h-12 text-green-500 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M8 12l2 2 4-4"/></svg>
                        <h3 class="font-bold text-xl mb-2">Trusted Maids</h3>
                        <p class="text-gray-600">All our maids are background-checked, trained, and committed to your satisfaction and safety.</p>
                    </div>
                    <div class="bg-white rounded-xl shadow p-8 flex flex-col items-center text-center hover:shadow-lg transition">
                        <svg class="w-12 h-12 text-green-500 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/></svg>
                        <h3 class="font-bold text-xl mb-2">Fast & Reliable</h3>
                        <p class="text-gray-600">Enjoy quick delivery and responsive support, making your experience smooth and worry-free.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dynamic About Content from DB (if any) -->
        <section class="py-12">
            <div class="max-w-6xl mx-auto px-4">
                <?php
                $sql="SELECT * from tblpage where PageType='aboutus'";
                $query = $dbh -> prepare($sql);
                $query->execute();
                $results=$query->fetchAll(PDO::FETCH_OBJ);
                if($query->rowCount() > 0) {
                    foreach($results as $row) { ?>
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-green-700 mb-2"><?php echo htmlentities($row->PageTitle);?></h2>
                            <p class="text-gray-700"><?php echo $row->PageDescription;?></p>
                        </div>
                <?php }} ?>
            </div>
        </section>
    </main>

    <?php include_once('includes/footer.php');?>

    <!-- Optional JS (keep jQuery if needed) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
