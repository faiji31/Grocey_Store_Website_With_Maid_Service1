<?php
error_reporting(0);
include('includes/dbconnection.php');
?>

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Alpine.js for dropdown toggle -->
<script src="//unpkg.com/alpinejs" defer></script>

<header class="bg-white shadow sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-4">
            
            <!-- Brand / Logo -->
            <a href="index.php" class="text-2xl font-bold text-green-600">Grocery & Maid</a>
            
            <!-- Desktop Menu -->
            <nav class="hidden md:flex items-center gap-6 font-semibold">
                <a href="index.php" class="hover:text-green-600">Home</a>
                <a href="maid-hiring.php" class="hover:text-green-600">Find a Maid</a>
                <a href="grocery-list.php" class="hover:text-green-600">Find Groceries</a>
                <a href="services.php" class="hover:text-green-600">Our Services</a>
                <a href="order-list.php" class="hover:text-green-600">My Orders</a>
                <a href="about.php" class="hover:text-green-600">About</a>
                <a href="contact.php" class="hover:text-green-600">Contact</a>
            </nav>

            <!-- Account Section -->
            <div class="flex items-center gap-4">
                <?php if (!isset($_SESSION['email']) || empty($_SESSION['email'])): ?>
                    <!-- Create Account -->
                    <a href="registration.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">Create Account</a>

                    <!-- Login Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="text-gray-700 hover:text-green-600 text-sm font-semibold flex items-center gap-1">
                            Login
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" 
                            class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg py-2">
                            <a href="login.php" class="block px-4 py-2 hover:bg-gray-100 text-sm">Customer Login</a>
                            <a href="admin/login.php" class="block px-4 py-2 hover:bg-gray-100 text-sm">Admin Login</a>
                            <a href="agent/login.php" class="block px-4 py-2 hover:bg-gray-100 text-sm">Agent Login</a>
                            <a href="maid/login.php" class="block px-4 py-2 hover:bg-gray-100 text-sm">Maid Login</a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Logout -->
                    <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">Logout</a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn" class="md:hidden text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden flex flex-col gap-2 pb-4 font-semibold">
            <a href="index.php" class="hover:text-green-600">Home</a>
            <a href="maid-hiring.php" class="hover:text-green-600">Find a Maid</a>
            <a href="grocery-list.php" class="hover:text-green-600">Find Groceries</a>
            <a href="services.php" class="hover:text-green-600">Our Services</a>
            <a href="order-list.php" class="hover:text-green-600">My Orders</a>
            <a href="about.php" class="hover:text-green-600">About</a>
            <a href="contact.php" class="hover:text-green-600">Contact</a>
        </div>
    </div>
</header>

<script>
    // Mobile menu toggle
    document.getElementById('mobileMenuBtn').addEventListener('click', function () {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    });
</script>
