<?php
include('includes/dbconnection.php');

// Get the area name from the URL
$areaName = isset($_GET['area']) ? htmlspecialchars($_GET['area']) : '';

if (isset($_POST['register'])) {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']); // Note: consider hashing
    $mobile = htmlspecialchars($_POST['mobile']);
    $address = htmlspecialchars($_POST['address']);
    $gender = htmlspecialchars($_POST['gender']);

    $sql = "INSERT INTO tbluser (UserName, UserEmail, UserPassword, UserMobile, UserAddress, Gender) 
            VALUES (:username, :email, :password, :mobile, :address, :gender)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);

    if ($query->execute()) {
        echo "<script>alert('Registration successful. Please login to continue.');</script>";
        echo "<script>window.location.href='login.php?area=" . urlencode($areaName) . "';</script>";
        exit();
    } else {
        echo "<script>alert('Something went wrong. Please try again later.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-200 via-green-100 to-green-400">
    <div class="w-full max-w-md mx-auto bg-white rounded-2xl shadow-2xl p-8 md:p-10 border border-green-200">
        <div class="flex flex-col items-center mb-8">
            <svg class="w-16 h-16 text-green-600 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M6.05 17.95l-1.414 1.414M17.95 17.95l-1.414-1.414M6.05 6.05L4.636 4.636"/><circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>
            <h2 class="text-2xl font-bold text-green-700 text-center">Create an Account</h2>
        </div>
        <form method="POST" action="" class="space-y-5">
            <div>
                <label for="username" class="block text-green-700 font-semibold mb-1">Full Name</label>
                <input type="text" name="username" id="username" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition shadow-sm bg-gray-50">
            </div>
            <div>
                <label for="email" class="block text-green-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" id="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition shadow-sm bg-gray-50">
            </div>
            <div>
                <label for="password" class="block text-green-700 font-semibold mb-1">Password</label>
                <input type="password" name="password" id="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition shadow-sm bg-gray-50">
            </div>
            <div>
                <label for="mobile" class="block text-green-700 font-semibold mb-1">Mobile</label>
                <input type="text" name="mobile" id="mobile" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition shadow-sm bg-gray-50">
            </div>
            <div>
                <label for="address" class="block text-green-700 font-semibold mb-1">Address</label>
                <input type="text" name="address" id="address" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition shadow-sm bg-gray-50">
            </div>
            <div>
                <label for="gender" class="block text-green-700 font-semibold mb-1">Gender</label>
                <select name="gender" id="gender" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-500 transition shadow-sm bg-gray-50">
                    <option value="">--Select--</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <button type="submit" name="register" class="w-full bg-gradient-to-r from-green-500 to-green-700 text-white font-bold py-2 rounded-full shadow-lg hover:from-green-600 hover:to-green-800 transition text-lg">Register</button>
            <div class="text-center pt-2">
                <a href="login.php?area=<?= urlencode($areaName) ?>" class="text-green-700 hover:underline text-sm">I already have an account</a>
            </div>
        </form>
    </div>
</body>
</html>
