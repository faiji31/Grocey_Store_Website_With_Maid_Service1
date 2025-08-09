<?php
session_start();
error_reporting(0);

include('includes/dbconnection.php');
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <title>Maid Hiring Management System || Contact Us</title>

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.css">
    <link rel="stylesheet" href="assets/css/price_rangs.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .complain-box {
            margin-top: 50px;
            padding: 30px;
            background: #f7f7f7;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .complain-box h3 {
            color: #333;
            font-size: 22px;
            margin-bottom: 20px;
        }

        .whatsapp-chat {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
        }

        .whatsapp-chat a:hover i {
            color: #1DA851; /* Slightly darker green for hover */
            transform: scale(1.1); /* Slight zoom on hover */
            transition: all 0.2s ease-in-out;
    }


        .whatsapp-chat img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .whatsapp-chat {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }

    .whatsapp-chat img {
        width: 100px; /* Increase size */
        height: 100px; /* Maintain proportions */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .whatsapp-chat img:hover {
        transform: scale(1.2); /* Zoom effect */
        box-shadow: 0 8px 16px rgba(0, 255, 0, 0.4); /* Green glow effect */
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }

    .whatsapp-chat img {
        animation: bounce 2s infinite; /* Continuous bounce effect */
    }
    </style>
</head>

<body>
    <?php include_once('includes/header.php'); ?>
    <!-- Hero Area Start-->
    <div class="slider-area">
        <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="assets/img/hero/contact.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>Contact Us</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End -->

    <!-- Contact Section Start -->
    <section class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <?php
                    $sql = "SELECT * from tblpage where PageType='contactus'";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    if ($query->rowCount() > 0) {
                        foreach ($results as $row) { ?>

                            <div class="media contact-info">
                                <span class="contact-info__icon"><i class="ti-home"></i></span>
                                <div class="media-body">
                                    <h3>Address</h3>
                                    <p><?php echo htmlentities($row->PageDescription); ?></p>
                                </div>
                            </div>
                            <div class="media contact-info">
                                <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                                <div class="media-body">
                                    <h3>Contact Number</h3>
                                    <p><?php echo htmlentities($row->MobileNumber); ?></p>
                                </div>
                            </div>
                            <div class="media contact-info">
                                <span class="contact-info__icon"><i class="ti-email"></i></span>
                                <div class="media-body">
                                    <h3>Email</h3>
                                    <p><?php echo htmlentities($row->Email); ?></p>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </div>

                <!-- Complain Box -->
                <div class="col-lg-6">
                    <div class="complain-box">
                        <h3>Submit Your Complaint</h3>
                        <form action="complain-process.php" method="post">
                            <div class="form-group">
                                <label for="name">Your Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Your Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="complaint">Your Complaint</label>
                                <textarea class="form-control" id="complaint" name="complaint" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Submit Complaint</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- WhatsApp Chat Button -->
    <div class="whatsapp-chat fixed mb-5">
        <a href="https://wa.me/8801758551245" target="_blank">
            <img class="img-fluid rounded-circle shadow width-100 " src="assets/img/logo/whatsapp-icon.png" alt="WhatsApp Chat">
        </a>
    </div>

    <?php include_once('includes/footer.php'); ?>

    <!-- JS here -->
    <script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="./assets/js/popper.min.js"></script>
    <script src="./assets/js/bootstrap.min.js"></script>
    <script src="./assets/js/jquery.slicknav.min.js"></script>
    <script src="./assets/js/owl.carousel.min.js"></script>
    <script src="./assets/js/slick.min.js"></script>
    <script src="./assets/js/price_rangs.js"></script>
    <script src="./assets/js/wow.min.js"></script>
    <script src="./assets/js/animated.headline.js"></script>
    <script src="./assets/js/jquery.scrollUp.min.js"></script>
    <script src="./assets/js/jquery.nice-select.min.js"></script>
    <script src="./assets/js/jquery.sticky.js"></script>
    <script src="./assets/js/jquery.magnific-popup.js"></script>
    <script src="./assets/js/contact.js"></script>
    <script src="./assets/js/jquery.form.js"></script>
    <script src="./assets/js/jquery.validate.min.js"></script>
    <script src="./assets/js/mail-script.js"></script>
    <script src="./assets/js/jquery.ajaxchimp.min.js"></script>
    <script src="./assets/js/plugins.js"></script>
    <script src="./assets/js/main.js"></script>
</body>

</html>
