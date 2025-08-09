<?php
session_start();error_reporting(0);include('includes/dbconnection.php');

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT ID FROM tblagent WHERE AgentEmail=:email and AgentPassword=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['agentid'] = $result->ID;
        }

        if (!empty($_POST['remember'])) {
            // COOKIES for email
            setcookie("agent_email", $_POST['email'], time() + (10 * 365 * 24 * 60 * 60));
            // COOKIES for password
            setcookie("agent_password", $_POST['password'], time() + (10 * 365 * 24 * 60 * 60));
        } else {
            if (isset($_COOKIE['agent_email'])) {
                setcookie("agent_email", "");
            }
            if (isset($_COOKIE['agent_password'])) {
                setcookie("agent_password", "");
            }
        }
        $_SESSION['agent_login'] = $_POST['email'];
        echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Maid Hiring Management System || Agent Login Page</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/colors.css" />
    <link rel="stylesheet" href="css/bootstrap-select.css" />
    <link rel="stylesheet" href="css/perfect-scrollbar.css" />
    <link rel="stylesheet" href="css/custom.css" />
    <link rel="stylesheet" href="js/semantic.min.css" />
</head>
<body class="inner_page login">
<div class="full_container">
    <div class="container">
        <div class="center verticle_center full_height">
            <div class="login_section">
                <div class="logo_login">
                    <div class="center">
                        <h3 style="color: white;">Agent Login</h3>
                    </div>
                </div>
                <div class="login_form">
                    <form method="post" name="login">
                        <fieldset>
                            <div class="field">
                                <label class="label_field">Email</label>
                                <input type="email" class="form-control" placeholder="Enter your email" required="true" name="email" value="<?php if(isset($_COOKIE['agent_email'])) { echo $_COOKIE['agent_email']; } ?>">
                            </div>
                            <div class="field">
                                <label class="label_field">Password</label>
                                <input type="password" class="form-control" placeholder="Enter your password" required="true" name="password" value="<?php if(isset($_COOKIE['agent_password'])) { echo $_COOKIE['agent_password']; } ?>">
                            </div>
                            <div class="field">
                                <label class="label_field hidden">hidden label</label>
                                <label class="form-check-label">
                                    <input class="form-check-input" id="remember" name="remember" <?php if(isset($_COOKIE['agent_email'])) { ?> checked <?php } ?> type="checkbox"/> Remember Me
                                </label>
                                <a class="forgot" href="forgot-password.php">Forgotten Password?</a>
                            </div>
                            <div class="field margin_0">
                                <label class="label_field hidden">hidden label</label>
                                <button class="main_bt" name="login" type="submit">Login</button>
                            </div>
                        </fieldset>
                        <a class="forgot" href="../index.php">Home Page</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/animate.js"></script>
<script src="js/bootstrap-select.js"></script>
<script src="js/perfect-scrollbar.min.js"></script>
<script>
    var ps = new PerfectScrollbar('#sidebar');
</script>
<script src="js/custom.js"></script>
</body>
</html>
