<?php
include "config.php";

if (!isset($_SESSION['UserID'])) {
    echo "<script>
            alert('Please login to continue');
            window.location.href = 'login.php';
          </script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $details = $_POST['details'];
    $userID = $_SESSION['UserID'];

    // Insert contact into the database
    $insertQuery = "INSERT INTO contact (details, UserID) VALUES (?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("si", $details, $userID);

    if ($stmt->execute()) {
        echo "<script>
            alert('Your message has been sent!');
              </script>";
    }
    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitPlay - Contact Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dropdownBtn = document.getElementById("dropdown-btn");
        const dropdownMenu = document.getElementById("dropdown-menu");

        let hideTimeout; // Store timeout reference

        // Show dropdown on hover
        dropdownBtn.addEventListener("mouseenter", () => {
            clearTimeout(hideTimeout); // Prevent premature hiding
            dropdownMenu.classList.remove("hidden");
            dropdownMenu.classList.add("flex", "flex-col"); // Ensure layout
        });

        dropdownMenu.addEventListener("mouseenter", () => {
            clearTimeout(hideTimeout); // Cancel hiding when menu is hovered
        });

        // Hide dropdown only if the user fully leaves both elements
        function hideDropdown() {
            hideTimeout = setTimeout(() => {
                if (!dropdownBtn.matches(":hover") && !dropdownMenu.matches(":hover")) {
                    dropdownMenu.classList.add("hidden");
                }
            }, 300); // Delay hiding a bit longer for smoother UX
        }

        dropdownBtn.addEventListener("mouseleave", hideDropdown);
        dropdownMenu.addEventListener("mouseleave", hideDropdown);
    });
</script>

<body>
    <nav class="bg-green-900 text-white py-4 fixed w-full top-0 shadow-md z-10">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-2xl font-bold">FitPlay</h1>
            <ul class="flex space-x-6 items-center">
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li class="relative">
                    <button id="dropdown-btn" class="px-4 py-2 rounded-lg dropdown-btn hover:bg-green-700">Sports ▼</button>
                    <ul id="dropdown-menu" class="absolute left-0 hidden bg-green-800 text-white shadow-lg mt-2 py-2 w-44 rounded-lg">
                        <li><a href="book-court.php?sport=Football" class="block px-4 py-2 hover:bg-green-600">Football</a></li>
                        <li><a href="book-court.php?sport=Futsal" class="block px-4 py-2 hover:bg-green-600">Futsal</a></li>
                        <li><a href="book-court.php?sport=Volleyball" class="block px-4 py-2 hover:bg-green-600">Volleyball</a></li>
                        <li><a href="book-court.php?sport=Netball" class="block px-4 py-2 hover:bg-green-600">Netball</a></li>
                    </ul>
                </li>
                <li><a href="training-tips.php" class="active">Training Tips</a></li>
                <li><a href="booking.php" class="active">Booking</a></li>
                <li><a href="contact.php" class="nav-link">Contact Us</a></li>
                <li><a href="logout.php" class="nav-link">Logout</a></li>
            </ul>
        </div>
    </nav><br><br>

    <main class="p-6 mt-20 container mx-auto text-center">
        <h1 class="text-3xl font-bold mb-6">Contact Us</h1>
        <p class="text-gray-700 mb-8">Feel free to reach out to us by filling out the form below.</p>

        <form action="" method="post" class="max-w-lg mx-auto bg-white shadow-lg p-6 rounded-lg">
            <div class="mb-4 text-left">
                <label class="block text-gray-700 font-semibold">Email</label>
                <input type="email" class="w-full p-2 border rounded-md" value="<?php echo  $_SESSION['email']; ?>" disabled>
            </div>
            <div class="mb-4 text-left">
                <label class="block text-gray-700 font-semibold">Email</label>
                <input type="text" class="w-full p-2 border rounded-md" value="<?php echo  $_SESSION['contact']; ?>" disabled>
            </div>
            <div class="mb-4 text-left">
                <label class="block text-gray-700 font-semibold">Message</label>
                <textarea class="w-full p-2 border rounded-md" rows="4" name="details" required></textarea>
            </div>
            <button type="submit" name="submit" class="bg-green-700 text-white px-6 py-2 rounded-md hover:bg-green-800">Send Message</button>
        </form>
    </main>

    <footer class="bg-gray-800 text-white text-center py-4 w-full mt-auto fixed bottom-0 left-0 right-0">
        &copy; 2025 FitPlay
    </footer>

    <script>
        function sendMessage(event) {
            event.preventDefault();
            alert("Your message has been sent!");
        }
    </script>
</body>

</html>