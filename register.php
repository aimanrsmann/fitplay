<?php
include "config.php";

if (isset($_POST['register'])) {
    $account_type = $_POST['account_type'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $contact = $_POST['contact'];

    // Check if email exists in the respective table
    $check_sql = $account_type === 'user' ? 
        "SELECT * FROM user WHERE email = '$email'" : 
        "SELECT * FROM admin WHERE email = '$email'";

    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Email already registered!'); window.location.href='register.php';</script>";
        exit();
    }

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.'); window.location.href='register.php';</script>";
        exit();
    }

    // Insert into appropriate table
    if ($account_type === 'user') {
        $sql = "INSERT INTO user (email, password, contact) VALUES ('$email', '$password', '$contact')";
    } else {
        $sql = "INSERT INTO admin (email, password) VALUES ('$email', '$password')";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Registration successful! Please login.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Registration failed. Please try again.'); window.location.href='register.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FitPlay - Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="flex items-center justify-center h-screen bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-bold text-center mb-4">Register for FitPlay</h2>

            <form action="" method="POST">
                <div class="flex flex-row gap-5 mb-4">
                    <input id="user" name="account_type" type="radio" value="user" required onclick="toggleContact()"
                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                    <label for="user" class="ml-2 block text-sm text-gray-900">User</label>
                </div>

                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" required class="w-full p-2 border rounded mb-4" />

                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required class="w-full p-2 border rounded mb-4" />

                <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="confirm_password" required class="w-full p-2 border rounded mb-4" />

                <div id="contact-group" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700">Contact</label>
                    <input type="text" name="contact" class="w-full p-2 border rounded mb-4" />
                </div>

                <button type="submit" name="register" class="w-full bg-green-900 text-white p-2 rounded hover:bg-green-700">
                    Register
                </button>
            </form>

            <p class="text-sm text-center mt-4 text-gray-600">
                Already have an account?
                <a href="login.php" class="text-indigo-600 hover:underline">Login here</a>
            </p>
        </div>
    </div>

    <script>
        function toggleContact() {
            const userRadio = document.getElementById('user');
            const contactGroup = document.getElementById('contact-group');

            if (userRadio.checked) {
                contactGroup.style.display = 'block';
            } else {
                contactGroup.style.display = 'none';
            }
        }

        // Trigger visibility on page load if user was selected
        window.onload = toggleContact;
    </script>
</body>

</html>
