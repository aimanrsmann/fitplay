<?php
include "config.php";

if (!isset($_SESSION['UserID'])) {
    echo "<script>
            alert('Please login to continue');
            window.location.href = 'login.php';
          </script>";
    exit;
}


$sport = $_GET['sport'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitPlay - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
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
    </nav>

    <main class="p-6">
        <?php if ($sport === "Football") { ?>
            <section id="football-tips" class="py-16 container mx-auto text-center">
                <h1 class="mt-10 mb-10 text-3xl font-bold">Football Training Tips</h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
                    <a href="tips-football.php?name=passing" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/football.jpg" alt="Passing" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Passing</h3>
                    </a>
                    <a href="tips-football.php?name=dribbling" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/football.jpg" alt="Dribbling" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Dribbling</h3>
                    </a>
                    <a href="tips-football.php?name=shooting" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/football.jpg" alt="Shooting" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Shooting</h3>
                    </a>
                    <a href="tips-football.php?name=keeper" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/football.jpg" alt="Keeper" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Keeper</h3>
                    </a>
                    <a href="tips-football.php?name=tackling" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/football.jpg" alt="Tackling" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Tackling</h3>
                    </a>
                    <a href="tips-football.php?name=throw" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/football.jpg" alt="Throw-in" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Throw-in</h3>
                    </a>
                </div>
            </section>
        <?php } else if ($sport === "Futsal") { ?>
            <section id="futsal-tips" class="py-16 container mx-auto text-center">
                <h1 class="mt-10 mb-10 text-3xl font-bold">Futsal Training Tips</h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
                    <a href="tips-futsal.php?name=control" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/futsal.jpg" alt="Ball Control" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Ball Control</h3>
                    </a>
                    <a href="tips-futsal.php?name=dribbling" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/futsal/bule-website.webp" alt="Dribbling" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Dribbling</h3>
                    </a>
                    <a href="tips-futsal.php?name=shooting" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/futsal/futsal_3.jpg" alt="Shooting" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Shooting</h3>
                    </a>
                    <a href="tips-futsal.php?name=goalkeeping" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/futsal/futsaler.jpg" alt="Goalkeeping" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Goalkeeping</h3>
                    </a>
                    <a href="tips-futsal.php?name=passing" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/futsal/futsalll.jpg" alt="Passing" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Passing</h3>
                    </a>
                    <a href="tips-futsal.php?name=passing" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/futsal/fotsal.webp" alt="Passing" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Defending</h3>
                    </a>
                </div>
            </section>
        <?php } else if ($sport === "Netball") { ?>
            <section id="netball-tips" class="py-16 container mx-auto text-center">
                <h1 class="mt-10 mb-10 text-3xl font-bold">Netball Training Tips</h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
                    <a href="tips-netball.php?name=passing" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/netball.jpg" alt="Passing" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Passing</h3>
                    </a>
                    <a href="tips-netball.php?name=shooting" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/netball.jpg" alt="Shooting" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Shooting</h3>
                    </a>
                    <a href="tips-netball.php?name=footwork" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/netball.jpg" alt="Footwork" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Footwork</h3>
                    </a>
                    <a href="tips-netball.php?name=defense" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/netball.jpg" alt="Defense" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Defense</h3>
                    </a>
                </div>
            </section>
        <?php } else if ($sport === "Volleyball") { ?>
            <section id="volleyball-tips" class="py-16 container mx-auto text-center">
                <h1 class="mt-10 mb-10 text-3xl font-bold">Volleyball Training Tips</h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
                    <a href="tips-volleyball.php?name=serving" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/volleyball.jpeg" alt="Serving" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Serving</h3>
                    </a>
                    <a href="tips-volleyball.php?name=spiking" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/volleyball.jpeg" alt="Spiking" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Spiking</h3>
                    </a>
                    <a href="tips-volleyball.php?name=blocking" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/volleyball.jpeg" alt="Blocking" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Blocking</h3>
                    </a>
                    <a href="tips-volleyball.php?name=digging" class="bg-white shadow-lg p-6 rounded-lg hover:shadow-xl sport-card">
                        <img src="assets/volleyball.jpeg" alt="Digging" class="w-full h-48 object-cover rounded-md">
                        <h3 class="text-xl font-semibold mt-4">Digging</h3>
                    </a>
                </div>
            </section>
        <?php } ?>
    </main>





    <footer class="bg-gray-800 text-white text-center py-4 w-full mt-auto bottom-0 left-0 right-0">
        &copy; 2025 FitPlay
    </footer>

</body>

</html>