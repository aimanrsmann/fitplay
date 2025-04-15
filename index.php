<?php
include "config.php";

if (!isset($_SESSION['UserID'])) {
    echo "<script>
            alert('Please login to continue');
            window.location.href = 'login.php';
          </script>";
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitPlay - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css">


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dropdownBtn = document.getElementById("dropdown-btn");
            const dropdownMenu = document.getElementById("dropdown-menu");

            dropdownBtn.addEventListener("mouseenter", () => {
                dropdownMenu.classList.remove("hidden");
                dropdownMenu.classList.add("flex", "flex-col"); // Ensure proper layout
            });

            dropdownMenu.addEventListener("mouseenter", () => {
                dropdownMenu.classList.remove("hidden");
            });

            dropdownBtn.addEventListener("mouseleave", () => {
                setTimeout(() => {
                    if (!dropdownMenu.matches(":hover")) {
                        dropdownMenu.classList.add("hidden");
                    }
                }, 200);
            });

            dropdownMenu.addEventListener("mouseleave", () => {
                dropdownMenu.classList.add("hidden");
            });
        });
    </script>
</head>

<body>
    <nav class="bg-green-900 text-white py-4 fixed w-full top-0 shadow-md z-10">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-2xl font-bold">FitPlay</h1>
            <ul class="flex space-x-6 items-center">
                <li><a href="index.php" class="nav-link" data-link="index">Home</a></li>
                <li class="relative">
                    <button id="dropdown-btn" class="px-4 py-2 rounded-lg hover:bg-green-700">Sports ▼</button>
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
    </nav>


    <video autoplay muted loop class="hero-video">
        <source src="assets/video.mp4" type="video/mp4">
    </video>
    <div class="absolute inset-0 bg-black bg-opacity-0 flex flex-col justify-center items-center text-white text-center px-6">
        <h1 class="text-4xl font-bold">Welcome to FitPlay</h1>
        <p class="text-lg mt-2">Book your favorite sports venues with ease and get personalized recommendations training tips!</p>
        <a href="#sports" class="btn-slide mt-6 px-6 py-3 bg-green-900 hover:bg-green-700 text-white font-semibold rounded-lg">Explore Sports</a>
    </div>

    <section id="sports" class="py-16 container mx-auto text-center">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 px-4">
            <a href="book-court.php?sport=Futsal" class="block bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                <img src="assets/futsal.jpg" alt="Futsal" class="w-full h-75 object-cover rounded-md">
                <h3 class="text-xl font-semibold mt-4">Futsal</h3>
            </a>
            <a href="book-court.php?sport=Football" class="block bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                <img src="assets/football.jpg" alt="Joga Bonito" class="w-full h-75 object-cover rounded-md">
                <h3 class="text-xl font-semibold mt-4">Joga Bonito (Football 7 Side)</h3>
            </a>
            <a href="book-court.php?sport=Netball" class="block bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                <img src="assets/netball.jpg" alt="Netball" class="w-full h-75 object-cover rounded-md">
                <h3 class="text-xl font-semibold mt-4">Netball</h3>
            </a>
            <a href="book-court.php?sport=Volleyball" class="block bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                <img src="assets/volleyball.jpeg" alt="Volleyball" class="w-full h-75 object-cover rounded-md">
                <h3 class="text-xl font-semibold mt-4">Volleyball</h3>
            </a>
        </div>
    </section>

    <footer class="bg-gray-800 text-white text-center py-4 w-full mt-auto bottom-0 left-0 right-0">
        &copy; 2025 FitPlay
    </footer>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the current page URL
        const currentPath = window.location.pathname.split("/").pop(); // Extract filename

        // Get all navigation links
        const navLinks = document.querySelectorAll(".nav-link");

        // Loop through links and set the active class
        navLinks.forEach(link => {
            if (link.getAttribute("href") === currentPath) {
                link.classList.add("active");
            }
        });
    });
</script>

</html>