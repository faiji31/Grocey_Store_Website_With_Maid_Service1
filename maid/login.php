<?php
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
    $maidId = $_POST['maidId']; // Using MaidId instead of Email
    $password = $_POST['password'];

    $sql = "SELECT ID FROM tblmaid WHERE MaidId = :maidId AND Password = :password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':maidId', $maidId, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
        if (!empty($_POST["remember"])) {
            // Cookies for MaidId
            setcookie("maid_login", $_POST["maidId"], time() + (10 * 365 * 24 * 60 * 60));
            // Cookies for Password
            setcookie("userpassword", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60));
        } else {
            if (isset($_COOKIE["maid_login"])) {
                setcookie("maid_login", "");
            }
            if (isset($_COOKIE["userpassword"])) {
                setcookie("userpassword", "");
            }
        }

        // Redirect to dashboard with maidId in the URL
        header("Location: dashboard.php?maidId=" . urlencode($maidId));
        exit;
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Grocery Store and Maid Service Website || Login Page</title>
      <link rel="stylesheet" href="css/bootstrap.min.css" />
      <!-- site css -->
      <link rel="stylesheet" href="style.css" />
      <!-- responsive css -->
      <link rel="stylesheet" href="css/responsive.css" />
      <!-- color css -->
      <link rel="stylesheet" href="css/colors.css" />
      <!-- select bootstrap -->
      <link rel="stylesheet" href="css/bootstrap-select.css" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="css/perfect-scrollbar.css" />
      <!-- custom css -->
      <link rel="stylesheet" href="css/custom.css" />
   </head>
   <body class="inner_page login">
      <div class="full_container">
         <div class="container">
            <div class="center verticle_center full_height">
               <div class="login_section">
                  <div class="logo_login">
                     <div class="center">
                        <h3 style="color: white;">Grocery Store Website and Maid Services</h3>
                     </div>
                  </div>
                  <div class="login_form">
                     <form method="post" name="login">
                        <fieldset>
                           <div class="field">
                              <label class="label_field">Maid ID</label>
                              <input type="text" class="form-control" placeholder="Enter your Maid ID" required="true" name="maidId" value="<?php if (isset($_COOKIE["maid_login"])) { echo $_COOKIE["maid_login"]; } ?>" >
                           </div>
                           <div class="field">
                              <label class="label_field">Password</label>
                              <input type="password" class="form-control" placeholder="Enter your password" name="password" required="true" value="<?php if (isset($_COOKIE["userpassword"])) { echo $_COOKIE["userpassword"]; } ?>">
                           </div>
                           <div class="field">
                              <label class="label_field hidden">hidden label</label>
                              <label class="form-check-label"><input class="form-check-input" id="remember" name="remember" <?php if (isset($_COOKIE["maid_login"])) { ?> checked <?php } ?> type="checkbox"/> Remember Me</label>
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
      <script src="js/custom.js"></script>
   </body>
</html>
