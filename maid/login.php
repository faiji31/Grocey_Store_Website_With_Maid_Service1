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
   <script src="https://cdn.tailwindcss.com"></script>
   </head>
   <body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-200 via-green-100 to-green-400">
      <div class="w-full max-w-md mx-auto bg-white rounded-2xl shadow-2xl p-8 md:p-10 border border-green-200">
         <div class="flex flex-col items-center mb-8">
            <svg class="w-16 h-16 text-green-600 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M6.05 17.95l-1.414 1.414M17.95 17.95l-1.414-1.414M6.05 6.05L4.636 4.636"/><circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>
            <h3 class="text-2xl font-bold text-green-700 text-center">Grocery Store Website and Maid Services</h3>
         </div>
         <form method="post" name="login" class="space-y-6">
            <div>
               <label class="block text-green-700 font-semibold mb-1">Maid ID</label>
               <input type="text" placeholder="Enter your Maid ID" required name="maidId" value="<?php if (isset($_COOKIE['maid_login'])) { echo $_COOKIE['maid_login']; } ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition shadow-sm bg-gray-50">
            </div>
            <div>
               <label class="block text-green-700 font-semibold mb-1">Password</label>
               <input type="password" placeholder="Enter your password" name="password" required value="<?php if (isset($_COOKIE['userpassword'])) { echo $_COOKIE['userpassword']; } ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition shadow-sm bg-gray-50">
            </div>
            <div class="flex items-center justify-between">
               <label class="flex items-center text-gray-600">
                  <input id="remember" name="remember" <?php if (isset($_COOKIE['maid_login'])) { ?> checked <?php } ?> type="checkbox" class="form-checkbox text-green-600 rounded">
                  <span class="ml-2">Remember Me</span>
               </label>
               <a href="forgot-password.php" class="text-green-600 hover:underline text-sm">Forgotten Password?</a>
            </div>
            <button name="login" type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-700 text-white font-bold py-2 rounded-full shadow-lg hover:from-green-600 hover:to-green-800 transition text-lg">Login</button>
            <div class="text-center pt-2">
               <a href="../index.php" class="text-green-700 hover:underline text-sm">Home Page</a>
            </div>
         </form>
      </div>
   </body>
</html>
