<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Maid & Grocery Services</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-900">

<!-- Hero -->
<section class="bg-green-600 text-white text-center py-16">
  <h1 class="text-5xl font-bold">Maid & Grocery Delivery Services</h1>
  <p class="mt-4 text-lg">Professional maids and fresh groceries, all in one place</p>
</section>

<!-- Maid Services -->
<section class="max-w-7xl mx-auto py-16 px-6">
  <div class="text-center mb-12">
    <h2 class="text-3xl font-bold text-green-700">Maid Services</h2>
    <p class="mt-2 text-gray-600">Skilled maids for your home cleaning & chores</p>
  </div>
  <div class="grid md:grid-cols-3 gap-8">
    <div class="bg-white shadow-lg rounded-xl p-6 text-center hover:scale-105 transition">
      <i class="fas fa-broom text-green-600 text-5xl mb-4"></i>
      <h3 class="font-bold text-lg mb-2">Home Cleaning</h3>
      <p class="text-gray-500">Full house cleaning including dusting and mopping.</p>
    </div>
    <div class="bg-white shadow-lg rounded-xl p-6 text-center hover:scale-105 transition">
      <i class="fas fa-utensils text-green-600 text-5xl mb-4"></i>
      <h3 class="font-bold text-lg mb-2">Cooking Assistance</h3>
      <p class="text-gray-500">Skilled maids to prepare fresh home-cooked meals.</p>
    </div>
    <div class="bg-white shadow-lg rounded-xl p-6 text-center hover:scale-105 transition">
      <i class="fas fa-tshirt text-green-600 text-5xl mb-4"></i>
      <h3 class="font-bold text-lg mb-2">Laundry Service</h3>
      <p class="text-gray-500">Washing, drying, and folding clothes with care.</p>
    </div>
  </div>
</section>

<!-- Grocery Services -->
<section class="max-w-7xl mx-auto py-16 px-6 bg-green-50 rounded-xl">
  <div class="text-center mb-12">
    <h2 class="text-3xl font-bold text-green-700">Grocery Delivery</h2>
    <p class="mt-2 text-gray-600">Fresh groceries and essentials delivered to your door</p>
  </div>
  <div class="grid md:grid-cols-3 gap-8">
    <div class="bg-white shadow-lg rounded-xl p-6 text-center hover:scale-105 transition">
      <i class="fas fa-carrot text-green-600 text-5xl mb-4"></i>
      <h3 class="font-bold text-lg mb-2">Fresh Vegetables</h3>
      <p class="text-gray-500">Locally sourced vegetables for a healthy lifestyle.</p>
    </div>
    <div class="bg-white shadow-lg rounded-xl p-6 text-center hover:scale-105 transition">
      <i class="fas fa-apple-alt text-green-600 text-5xl mb-4"></i>
      <h3 class="font-bold text-lg mb-2">Fruits & Juices</h3>
      <p class="text-gray-500">Seasonal fruits and natural juices delivered daily.</p>
    </div>
    <div class="bg-white shadow-lg rounded-xl p-6 text-center hover:scale-105 transition">
      <i class="fas fa-cheese text-green-600 text-5xl mb-4"></i>
      <h3 class="font-bold text-lg mb-2">Dairy & Eggs</h3>
      <p class="text-gray-500">Fresh milk, cheese, and eggs for your daily needs.</p>
    </div>
  </div>
</section>

<!-- Special Offer -->
<section class="bg-green-100 py-12 px-6 text-center mt-12">
  <h3 class="text-2xl font-bold text-green-700 mb-2">Special Combo Offer!</h3>
  <p class="text-gray-700">
    Book any maid service and get <strong>free grocery delivery</strong> for the first 3 orders.
  </p>
</section>

<!-- Subscription Packages -->
<section class="max-w-7xl mx-auto py-16 px-6">
  <div class="text-center mb-12">
    <h2 class="text-3xl font-bold text-green-700">Subscription Packages</h2>
    <p class="text-gray-600">Save more with our service plans</p>
  </div>
  <div class="grid md:grid-cols-3 gap-8">
    <div class="bg-white shadow-xl rounded-xl p-6 text-center hover:scale-105 transition">
      <h4 class="text-xl font-bold mb-2">Maid Weekly</h4>
      <p class="text-2xl font-bold text-green-600">999 BDT</p>
      <ul class="mt-4 text-gray-500">
        <li>3 cleaning visits/week</li>
        <li>Flexible schedule</li>
      </ul>
      <a href="subscribe.php?plan=maid_weekly" class="mt-6 inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Subscribe</a>
    </div>
    <div class="bg-white shadow-xl rounded-xl p-6 text-center hover:scale-105 transition">
      <h4 class="text-xl font-bold mb-2">Grocery Monthly</h4>
      <p class="text-2xl font-bold text-green-600">2,799 BDT</p>
      <ul class="mt-4 text-gray-500">
        <li>Weekly grocery basket</li>
        <li>Free delivery</li>
      </ul>
      <a href="subscribe.php?plan=grocery_monthly" class="mt-6 inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Subscribe</a>
    </div>
    <div class="bg-white shadow-xl rounded-xl p-6 text-center hover:scale-105 transition">
      <h4 class="text-xl font-bold mb-2">Full Combo Annual</h4>
      <p class="text-2xl font-bold text-green-600">9,999 BDT</p>
      <ul class="mt-4 text-gray-500">
        <li>Weekly groceries + maid visits</li>
        <li>Best value plan</li>
      </ul>
      <a href="subscribe.php?plan=full_combo" class="mt-6 inline-block bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Subscribe</a>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-green-700 text-white py-6 text-center">
  <p>© 2025 GrocoMart. All rights reserved.</p>
</footer>

</body>
</html>
