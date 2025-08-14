<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Grocery Store And Maid Service System || Contact Us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .whatsapp-chat img {
            animation: bounce 2s infinite;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <?php include_once('includes/header.php'); ?>

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-64 flex items-center justify-center" style="background-image: url('assets/img/hero/contact.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative z-10 text-center">
            <h2 class="text-white text-4xl font-bold">Contact Us</h2>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-12">
        <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-8">

            <!-- Contact Info -->
            <div class="space-y-6">
                <?php
                $sql = "SELECT * from tblpage where PageType='contactus'";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);

                if ($query->rowCount() > 0) {
                    foreach ($results as $row) { ?>
                        <div class="flex space-x-4 items-start bg-white p-6 rounded-lg shadow">
                            <!-- SVG Icon for Address -->
                            <svg class="w-8 h-8 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                <circle cx="12" cy="9" r="2" stroke="none" fill="currentColor"/>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-lg">Address</h3>
                                <p class="text-gray-600"><?php echo htmlentities($row->PageDescription); ?></p>
                            </div>
                        </div>

                        <div class="flex space-x-4 items-start bg-white p-6 rounded-lg shadow">
                            <!-- SVG Icon for Phone -->
                            <svg class="w-8 h-8 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h2l3 7-3 7H3l3-7-3-7z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 5h10M7 19h10M10 9h4"/>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-lg">Contact Number</h3>
                                <p class="text-gray-600"><?php echo htmlentities($row->MobileNumber); ?></p>
                            </div>
                        </div>

                        <div class="flex space-x-4 items-start bg-white p-6 rounded-lg shadow">
                            <!-- SVG Icon for Email -->
                            <svg class="w-8 h-8 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12l-4 4-4-4m0 0l4-4 4 4M4 4h16v16H4V4z"/>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-lg">Email</h3>
                                <p class="text-gray-600"><?php echo htmlentities($row->Email); ?></p>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>

            <!-- Complaint Form -->
            <div class="bg-white p-8 rounded-lg shadow space-y-6">
                <h3 class="text-2xl font-semibold text-gray-900">Submit Your Complaint</h3>
                <form action="complain-process.php" method="post" class="space-y-4">
                    <div>
                        <label for="name" class="block mb-1 font-medium">Your Name</label>
                        <input type="text" id="name" name="name" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="email" class="block mb-1 font-medium">Your Email</label>
                        <input type="email" id="email" name="email" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="complaint" class="block mb-1 font-medium">Your Complaint</label>
                        <textarea id="complaint" name="complaint" rows="4" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-green-500 text-white font-semibold py-2 rounded hover:bg-green-600 transition">Submit Complaint</button>
                </form>
            </div>

        </div>
    </section>

    <!-- WhatsApp Chat Button -->
    <div class="whatsapp-chat fixed bottom-5 right-5 z-50">
        <a href="https://wa.me/8801790528911" target="_blank">
            <img src="assets/img/logo/whatsapp-icon.png" alt="WhatsApp Chat" class="w-24 h-24 rounded-full shadow-lg hover:scale-110 transition-transform">
        </a>
    </div>

   <?php include_once('includes/footer.php'); ?>
</body>

</html>
