<?php
include "config.php";

if (!isset($_SESSION['AdminID'])) {
    echo "<script>
            alert('Please login to continue');
            window.location.href = 'login.php';
          </script>";
    exit;
}

$UserID = $_GET['user_id'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $new_password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if email already exists (excluding the current user)
    $check_email_query = "SELECT * FROM User WHERE email = '$new_email' AND UserID != '$UserID'";
    $result = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Error: Email already exists! Please use a different email.');</script>";
    } else {
        // Update user details
        $update_query = "UPDATE User SET email='$new_email', contact='$new_contact', password='$new_password' WHERE UserID='$UserID'";

        if (mysqli_query($conn, $update_query)) {
            echo "<script>
            alert('Profile updated successfully!'); 
            window.location.href='user-details.php?user_id=" . $UserID . "';
          </script>";
        } else {
            echo "<script>alert('Error updating profile. Please try again.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>


</head>

<body class="">
    <div class="flex flex-row min-h-screen">
        <!-- Sidebar component -->
        <div class="w-72 lg:w-80 min-h-screen overflow-y-auto bg-gradient-to-r from-blue-500 to-teal-500">
            <div class="flex flex-col gap-y-5 px-6 pb-4">
                <div class="flex h-16 shrink-0 items-center mb-20">
                    <div class="ml-0 flex h-16 shrink-0 items-center mb-10 mt-10">
                        <h2 class="text-2xl font-bold text-white text-center mt-5 mb-4">FitPlay</h2>
                    </div>
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <ul role="list" class="-mx-2 space-y-1">
                            <li>
                                <a href="dashboard.php"
                                    class="text-white hover:text-indigo-200 hover:bg-teal-700 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <svg class="h-6 w-6 shrink-0 text-white group-hover:text-indigo-200" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                    </svg>
                                    Dashboard
                                </a>
                            </li>

                            <li>
                                <a href="list-booking.php"
                                    class="text-white hover:text-indigo-200 hover:bg-teal-700 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <svg class="h-6 w-6 shrink-0 text-white group-hover:text-indigo-200"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    Manage Booking
                                </a>
                            </li>
                            <li>
                                <a href="list-user.php"
                                    class="bg-teal-600 text-white group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <svg class="h-6 w-6 shrink-0 text-white group-hover:text-indigo-200"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    Manage User
                                </a>
                            </li>
                            <li>
                                <a href="list-contact.php"
                                    class="text-white hover:text-indigo-200 hover:bg-teal-700 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <svg class="h-6 w-6 shrink-0 text-white group-hover:text-indigo-200"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 12.75c0-.75-.75-1.5-1.5-1.5h-15c-.75 0-1.5.75-1.5 1.5v6.75c0 .75.75 1.5 1.5 1.5h15c.75 0 1.5-.75 1.5-1.5V12.75zM3 6.75h18c.75 0 1.5-.75 1.5-1.5v-3c0-.75-.75-1.5-1.5-1.5h-18c-.75 0-1.5.75-1.5 1.5v3c0 .75.75 1.5 1.5 1.5z" />
                                    </svg>
                                    Message
                                </a>
                            </li>
                            <li>
                                <a href="logout.php"
                                    class="text-white hover:text-indigo-200 hover:bg-teal-700 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    <svg class="h-6 w-6 shrink-0 fill-white group-hover:text-indigo-200"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path
                                            d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 192 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128zM160 96c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 32C43 32 0 75 0 128L0 384c0 53 43 96 96 96l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l64 0z" />
                                    </svg>
                                    Log Out
                                </a>
                            </li>
                        </ul>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="w-full bg-slate-100">
            <div class="mt-8 bg-white mx-10 rounded-2xl h-[900px] shadow-lg border border-gray-300">
                <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h2 class="text-2xl font-bold tracking-tight text-gray-900">List of User</h2>
                        </div>
                    </div>
                </div>

                <div class="max-w-lg mx-auto mt-10 bg-white shadow-md rounded-lg overflow-hidden p-6 border border-black">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">User Details</h2>

                    <?php
                    $sql = "SELECT * FROM User WHERE UserID = '$UserID'";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $contact = $row['contact'];
                            $password = $row['password'];
                            $email = $row['email'];
                        }
                    }
                    ?>

                    <form method="POST" action="">
                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="text" name="email" id="email" value="<?php echo $email; ?>"
                                class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 bg-gray-100 focus:ring-2 focus:ring-indigo-600 outline-none">
                        </div>

                        <!-- Contact Field -->
                        <div class="mb-4">
                            <label for="contact" class="block text-sm font-medium text-gray-700">Contact</label>
                            <input type="text" name="contact" id="contact" value="<?php echo $contact; ?>"
                                class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 bg-gray-100 focus:ring-2 focus:ring-indigo-600 outline-none">
                        </div>

                        <!-- Password Field -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" value="<?php echo $password; ?>"
                                class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 bg-gray-100 focus:ring-2 focus:ring-indigo-600 outline-none">
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-between">
                            <a href="list-user.php"
                                class="px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                                Back
                            </a>

                            <button type="submit" name="submit"
                                class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-500">
                                Edit
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>

    <footer class="bg-blue-600 text-white text-center py-4 w-full mt-auto fixed bottom-0 left-0 right-0">
        &copy; 2025 FitPlay
    </footer>

</body>


</html>


</html>