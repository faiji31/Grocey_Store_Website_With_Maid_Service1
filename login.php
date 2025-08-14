<?php
include('includes/dbconnection.php');
session_start();

// Retrieve the area from the URL or form submission
$area = isset($_GET['area']) ? htmlspecialchars($_GET['area']) : '';

if (isset($_POST['login'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']); // Match raw password

    $sql = "SELECT * FROM tbluser WHERE UserEmail = :email AND UserPassword = :password"; // Match email and password
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) { // Check if a record matches
        $_SESSION['userid'] = $result->ID;
        $_SESSION['username'] = $result->UserName;

        // Store email in the session for further use
        $_SESSION['email'] = $email;

        // Redirect to maid-hiring.php with area as a parameter
        echo "<script>
            sessionStorage.setItem('email', '" . addslashes($email) . "');
            alert('Login successful.');
            window.location.href = 'maid-hiring.php?area=" . urlencode($area) . "';
        </script>";
    } else {
        echo "<script>alert('Invalid email or password.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-200 via-green-100 to-green-400">
    <div class="w-full max-w-md mx-auto bg-white rounded-2xl shadow-2xl p-8 md:p-10 border border-green-200">
        <div class="flex flex-col items-center mb-8">
            <svg class="w-16 h-16 text-green-600 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M6.05 17.95l-1.414 1.414M17.95 17.95l-1.414-1.414M6.05 6.05L4.636 4.636"/><circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>
            <h3 class="text-2xl font-bold text-green-700 text-center">Login</h3>
        </div>
        <form method="POST" action="" class="space-y-6">
            <div>
                <label for="email" class="block text-green-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" id="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition shadow-sm bg-gray-50">
            </div>
            <div>
                <label for="password" class="block text-green-700 font-semibold mb-1">Password</label>
                <input type="password" name="password" id="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition shadow-sm bg-gray-50">
            </div>
            <button type="submit" name="login" class="w-full bg-gradient-to-r from-green-500 to-green-700 text-white font-bold py-2 rounded-full shadow-lg hover:from-green-600 hover:to-green-800 transition text-lg">Login</button>
        </form>
        <div class="text-center pt-4">
            <small class="text-gray-600">Don't have an account? <a href="registration.php" class="text-green-700 hover:underline">Register here</a></small>
        </div>
    </div>
</body>
</html>
