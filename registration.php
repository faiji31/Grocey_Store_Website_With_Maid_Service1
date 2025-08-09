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
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-blue-500 text-white text-center py-5">
            <h2 class="text-2xl font-bold">Create an Account</h2>
        </div>
        <div class="p-6">
            <form method="POST" action="">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-medium mb-1">Full Name</label>
                    <input type="text" name="username" id="username" required 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                </div>
                
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                </div>
                
                <div class="mb-4">
                    <label for="mobile" class="block text-gray-700 font-medium mb-1">Mobile</label>
                    <input type="text" name="mobile" id="mobile" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                </div>
                
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 font-medium mb-1">Address</label>
                    <input type="text" name="address" id="address" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                </div>
                
                <div class="mb-4">
                    <label for="gender" class="block text-gray-700 font-medium mb-1">Gender</label>
                    <select name="gender" id="gender" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 outline-none">
                        <option value="">--Select--</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                
                <button type="submit" name="register" 
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                    Register
                </button>

                <a href="login.php?area=<?= urlencode($areaName) ?>" 
                    class="block w-full mt-3 text-center bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg transition duration-200">
                    I already have an account
                </a>
            </form>
        </div>
    </div>

</body>
</html>
