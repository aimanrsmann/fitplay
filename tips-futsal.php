<?php
include "config.php";

if (!isset($_SESSION['UserID'])) {
    echo "<script>
            alert('Please login to continue');
            window.location.href = 'login.php';
          </script>";
    exit;
}



// FUTSAL PAGE

$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '';

$images = [];
$videos = [];

switch ($name) {
    case "control":
        $images = [
            'assets/futsal/control/control1.jpg',
            'assets/futsal/control/control2.jpg',
            'assets/futsal/control/control3.jpg',
            'assets/futsal/control/control4.jpg',
        ];
        $videos = [
            'assets/futsal/control/control1.mp4',
            'assets/futsal/control/control2.mp4',
            'assets/futsal/control/control2.mp4',
            'assets/futsal/control/control2.mp4',
        ];
        break;

    case "dribbling":
        $images = [
            'assets/futsal/dribbling/dribbling1.jpg',
            'assets/futsal/dribbling/dribbling2.jpg',
            'assets/futsal/dribbling/dribbling3.jpg',
            'assets/futsal/dribbling/dribbling4.jpg',
        ];
        $videos = [
            'assets/futsal/dribbling/dribbling1.mp4',
            'assets/futsal/dribbling/dribbling2.mp4',
        ];
        break;

    case "goalkeeping":
        $images = [
            'assets/futsal/goalkeeping/goalkeeping1.jpg',
            'assets/futsal/goalkeeping/goalkeeping2.jpg',
            'assets/futsal/goalkeeping/goalkeeping3.jpg',
            'assets/futsal/goalkeeping/goalkeeping4.jpg',
        ];
        $videos = [
            'assets/futsal/goalkeeping/goalkeeping1.mp4',
            'assets/futsal/goalkeeping/goalkeeping2.mp4',
        ];
        break;

    case "passing":
        $images = [
            'assets/futsal/passing/passing1.jpg',
            'assets/futsal/passing/passing2.jpg',
            'assets/futsal/passing/passing3.jpg',
            'assets/futsal/passing/passing4.jpg',
        ];
        $videos = [
            'assets/futsal/passing/passing1.mp4',
            'assets/futsal/passing/passing2.mp4',
        ];
        break;

    case "shooting":
        $images = [
            'assets/futsal/shooting/shooting1.jpg',
            'assets/futsal/shooting/shooting2.jpg',
            'assets/futsal/shooting/shooting3.jpg',
            'assets/futsal/shooting/shooting4.jpg',
        ];
        $videos = [
            'assets/futsal/shooting/shooting1.mp4',
            'assets/futsal/shooting/shooting2.mp4',
        ];
        break;

    default:
        $images = [];
        $videos = [];
        break;
}

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
                        <li><a href="book-court.php?sport=futsal" class="block px-4 py-2 hover:bg-green-600">futsal</a></li>
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
        <section class="bg-white p-4 rounded-lg shadow-md text-center mt-20 pb-20 max-w-3xl h-[550px] mx-auto">
            <h2 class="text-3xl font-semibold mb-4"><?php echo htmlspecialchars(ucwords($name)); ?></h2>
            <div class="carousel-container">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($images as $image) : ?>
                            <div class="swiper-slide">
                                <img src="<?php echo htmlspecialchars($image); ?>" class="w-full h-[450px] max-w-3xl mx-auto rounded-lg" alt="Image">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>

        <section class="mt-20 bg-white p-6 mx-auto w-auto rounded-lg shadow-md mb-10">
            <h2 class="text-3xl font-semibold mb-4 text-center">Suggested Videos</h2>
            <div class="swiper videoSwiper">
                <div class="swiper-wrapper">
                    <?php foreach ($videos as $video) : ?>
                        <div class="swiper-slide">
                            <video src="<?php echo htmlspecialchars($video); ?>" controls class="rounded-lg shadow w-full h-[250px] object-cover"></video>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white text-center py-4 w-full mt-auto bottom-0 left-0 right-0">
        &copy; 2025 FitPlay
    </footer>

    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 10,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });

        var videoSwiper = new Swiper(".videoSwiper", {
            slidesPerView: 3,
            spaceBetween: 50,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                }
            }
        });
    </script>

</body>

</html>