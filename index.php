<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
?>

<!doctype html>
<html lang="zxx">
<head>
    <title>Grocery Store and Maid Service Management System || Home Page</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    
    <!-- External Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">

    <!-- External Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
      /* Improved Slider Styling */
.slider-area {
    position: relative;
    overflow: hidden;
    background-color: #f8f9fa; /* Light background for better contrast */
}

.slider-active .single-slider {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 450px; /* Adjusted height for better visibility */
    background-size: contain; /* Ensure the image is fully visible */
    background-repeat: no-repeat;
    background-position: center;
}

.slider-active .hero__caption {
    text-align: center;
    color: #000; /* Use darker text for readability */
}

.slider-active .hero__caption h1 {
    font-size: 40px; /* Scaled down for better balance */
    font-weight: bold;
    margin-bottom: 20px;
}

.slider-active .hero__caption p {
    font-size: 18px;
    margin-bottom: 20px;
    color: #555; /* Softer color for secondary text */
}

.slider-active .btn {
    font-size: 16px;
    padding: 10px 20px;
    border-radius: 6px;
}

.slick-dots {
    bottom: 20px;
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .slider-active .single-slider {
        height: 300px; /* Adjust height for tablets */
    }
    .slider-active .hero__caption h1 {
        font-size: 32px;
    }
}

@media (max-width: 576px) {
    .slider-active .single-slider {
        height: 250px; /* Adjust height for mobile devices */
    }
    .slider-active .hero__caption h1 {
        font-size: 24px;
    }
    .slider-active .hero__caption p {
        font-size: 16px;
    }
}

/* Additional Styling */

.btn-info{
    background-color: black !important;
}

    </style>
</head>
<body>
    <?php include_once('includes/header.php'); ?>
    <main>
<!-- Hero Section -->
<div class="slider-area">
    <div class="slider-active slick-slider">
        <!-- Slide 1 -->
        <div class="single-slider" >
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    
                    <div class="col-lg-8 text-center">
                        <h1 class="display-5 fw-bold text-uppercase text-primary fw-bold mt-4">Smart Grocery Store & Maid Services</h1>
                        <p class="fs-5 mt-4 text-dark">Experience a wide range of grocery and household solutions tailored to your needs!</p>
                
                        <a href="javascript:void(0);" id="sliderOrderServiceButton" class="btn btn-info btn-lg px-5 py-4 mt-3">Order Grocery & Maid Service</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Service Search Section -->
<section class="service-section my-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="section-title text-success fw-bold mb-4">Available Grocery & Maid Services</h2>
            </div>
        </div>
        <div class="row">
            <form method="GET" action="" class="col-md-8 offset-md-2">
                <div class="form-group mb-3">
                    <label for="area" class="fw-bold">Select Preferred Area:</label>
                    <select name="area" id="area" class="form-control form-select" required>
                        <option value="" <?= empty($_GET['area']) ? 'selected' : '' ?>>-- Select Area --</option>
                        <option value="Basundhara R/A" <?= (isset($_GET['area']) && $_GET['area'] == 'Basundhara R/A') ? 'selected' : '' ?>>Basundhara R/A</option>
                        <option value="Banani" <?= (isset($_GET['area']) && $_GET['area'] == 'Banani') ? 'selected' : '' ?>>Banani</option>
                        <option value="Gulshan" <?= (isset($_GET['area']) && $_GET['area'] == 'Gulshan') ? 'selected' : '' ?>>Gulshan</option>
                        <option value="Uttara" <?= (isset($_GET['area']) && $_GET['area'] == 'Uttara') ? 'selected' : '' ?>>Uttara</option>
                        <option value="Badda" <?= (isset($_GET['area']) && $_GET['area'] == 'Badda') ? 'selected' : '' ?>>Badda</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </form>
        </div>
        <div class="row mt-4">
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
                    <div class="col-12 text-center">
                        <p class="text-success fs-5">
                            Grocery Store and Maid Service is available in <strong><?= $area ?></strong>.<br>
                            <strong><?= $maidCount ?></strong> maid(s) work in this area.
                        </p>
                        <a href="javascript:void(0);" id="searchOrderServiceButton" class="btn btn-success me-3">Order Grocery & Maid Service</a>
                        <a href="grocery-list.php?area=<?= urlencode($area) ?>" class="btn btn-primary">Visit Grocery Page</a>
                    </div>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <p class="text-danger fs-5">Grocery Store and Maid Service is not available in <strong><?= $area ?></strong>.</p>
                    </div>
                <?php endif;
            } else { ?>
                <div class="col-12 text-center">
                    <p class="text-muted fs-5">Please select an area to see available grocery store and maid services.</p>
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
