<?php
error_reporting(0);
include('includes/dbconnection.php');
?>

<header>
    <div class="header-area bg-light border-bottom shadow-sm sticky-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <!-- Brand Name or Logo -->
           

                <!-- Toggle Button for Mobile View -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Collapsible Navigation Links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex align-items-center justify-content-start gap-4 fw-bold">
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="maid-hiring.php">Find a Maid</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="grocery-list.php">Find Groceries</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="services.php">Our Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="order-list.php">My Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="contact.php">Contact</a>
                        </li>
                    </ul>

                 <!-- Account & Login/Logout Section -->
                 <div class="col-lg-3 col-md-3 d-flex justify-content-end align-items-center gap-3">
                    <?php if (!isset($_SESSION['email']) || empty($_SESSION['email'])): ?>
                        <!-- Show Create Account and Login when not logged in -->
                        <a href="registration.php" class="btn btn-primary btn-sm me-3 p-4" style="font-size: 16px;">Create Account</a>
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 16px;">
                                Login
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="loginDropdown">
                                <li><a class="dropdown-item" href="login.php" style="font-size: 16px;">Customer Login</a></li>
                                <li><a class="dropdown-item" href="admin/login.php" style="font-size: 16px;">Admin Login</a></li>
                                <li><a class="dropdown-item" href="agent/login.php" style="font-size: 16px;">Agent Login</a></li>
                                <li><a class="dropdown-item" href="maid/login.php" style="font-size: 16px;">Maid Login</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Show Logout when logged in -->
                        <a href="logout.php" class="btn btn-danger btn-sm me-3 p-4" style="font-size: 16px;">Logout</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</header>
