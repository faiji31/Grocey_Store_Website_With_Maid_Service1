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
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            background-color: #007bff;
            color: #fff;
            border-bottom: none;
            padding: 1.5rem;
        }
        .card-body {
            padding: 2rem;
        }
        .btn-primary {
            width: 100%;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="card login-card">
        <div class="card-header">Login</div>
        <div class="card-body">
            <form method="POST" action="">
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary">Login</button>
            </form>
        </div>
        <div class="card-footer text-center">
            <small>Don't have an account? <a href="registration.php">Register here</a></small>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
