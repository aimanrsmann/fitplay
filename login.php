<?php
include "config.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (isset($_POST['account_type']) && $_POST['account_type'] === 'user') {

        $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $_SESSION['UserID'] = $row['UserID'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['contact'] = $row['contact'];

                    echo "<script>alert('Welcome to FitPlay!');</script>";
                    echo "<script>window.location.href = 'index.php';</script>";
                }
            } else {
                echo "<script>alert('Invalid email or password. Please try again!');</script>";
                echo "<script>window.location.href = 'login.php';</script>";
            }
        } else {
            echo "<script>alert('Error in executing SQL query. Please try again later!');</script>";
            echo "<script>window.location.href = 'login.php';</script>";
        }
    } else {
        $sql = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $_SESSION['AdminID'] = $row['AdminID'];
                    $_SESSION['email'] = $row['email'];

                    echo "<script>alert('Welcome to FitPlay!');</script>";
                    echo "<script>window.location.href = 'dashboard.php';</script>";
                }
            } else {
                echo "<script>alert('Invalid email or password. Please try again!');</script>";
                echo "<script>window.location.href = 'login.php';</script>";
            }
        } else {
            echo "<script>alert('Error in executing SQL query. Please try again later!');</script>";
            echo "<script>window.location.href = 'login.php';</script>";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitPlay - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <video autoplay muted loop class="fixed top-0 left-0 w-full h-full object-cover z-0">
        <source src="video.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="flex items-center justify-center h-screen relative z-10">
        <div class="bg-white bg-opacity-90 p-8 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-bold text-center mb-4">Login to FitPlay</h2>

            <form action="" method="POST">
                <div class="flex flex-row gap-5">
                    <input id="user" name="account_type" type="radio" value="user" required
                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                    <label for="user" class="ml-2 block text-sm text-gray-900">User</label>

                    <input id="admin" name="account_type" type="radio" value="staff" required
                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                    <label for="admin" class="ml-2 block text-sm text-gray-900">Admin</label>
                </div><br>

                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" required class="w-full p-2 border rounded mb-4">

                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required class="w-full p-2 border rounded mb-4">

                <button type="submit" name="submit" class="w-full bg-green-900 text-white p-2 rounded hover:bg-green-700">
                    Login
                </button>
            </form>

            <p class="text-sm text-center mt-4 text-gray-600">
                Don’t have an account?
                <a href="register.php" class="text-indigo-600 hover:underline">Register here</a>
            </p>
        </div>
    </div>
</body>


</html>