<?php
include "config.php";

if (!isset($_SESSION['UserID'])) {
    echo "<script>
            alert('Please login to continue');
            window.location.href = 'login.php';
          </script>";
    exit;
}



$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '';

$images = [];
$videos = [];

switch ($name) {
    case "passing":
        $images = [
            'assets/football/passing/passing1.jpg',
            'assets/football/passing/passing2.jpg',
            'assets/football/passing/passing3.jpg',
            'assets/football/passing/passing4.jpg',
        ];
        $videos = [
            'assets/football/passing/passing1.mp4',
            'assets/football/passing/passing2.mp4',
            'assets/football/passing/passing2.mp4',
            'assets/football/passing/passing2.mp4',
        ];
        break;

    case "dribbling":
        $images = [
            'assets/football/dribbling/messi.jpg',
            'assets/football/dribbling/crrr.jpg',
            'assets/football/dribbling/neymar.jpg',
            'assets/football/dribbling/mbappe.jpg',
        ];
        $videos = [
            'assets/football/dribbling/5 Shooting Techniques Explained _ Learn How To Strike The Ball With This Step By Step Tutorial.mp4',
            'assets/football/dribbling/5 Shooting Techniques Explained _ Learn How To Strike The Ball With This Step By Step Tutorial.mp4',
        ];
        break;

    case "shooting":
        $images = [
            'assets/football/shooting/messi.jpg',
            'assets/football/shooting/crrr.jpg',
            'assets/football/shooting/neymar.jpg',
            'assets/football/shooting/mbappe.jpg',
        ];
        $videos = [
            'assets/football/shooting/5 Shooting Techniques Explained _ Learn How To Strike The Ball With This Step By Step Tutorial.mp4',
            'assets/football/shooting/5 Shooting Techniques Explained _ Learn How To Strike The Ball With This Step By Step Tutorial.mp4',
            'assets/football/shooting/5 Shooting Techniques Explained _ Learn How To Strike The Ball With This Step By Step Tutorial.mp4',
            'assets/football/shooting/5 Shooting Techniques Explained _ Learn How To Strike The Ball With This Step By Step Tutorial.mp4',
        ];
        break;

    case "tackling":
        $images = [
            'assets/football/tackling/messi.jpg',
            'assets/football/tackling/crrr.jpg',
            'assets/football/tackling/neymar.jpg',
            'assets/football/tackling/mbappe.jpg',
        ];
        $videos = [
            'assets/football/tackling/5 Shooting Techniques Explained _ Learn How To Strike The Ball With This Step By Step Tutorial.mp4',
            'assets/football/tackling/5 Shooting Techniques Explained _ Learn How To Strike The Ball With This Step By Step Tutorial.mp4',
        ];
        break;

    case "keeper":
        $images = [
            'assets/football/keeper/messi.jpg',
            'assets/football/keeper/crrr.jpg',
            'assets/football/keeper/neymar.jpg',
            'assets/football/keeper/mbappe.jpg',
        ];
        $videos = [
            'assets/football/keeper/5 Shooting Techniques Explained _ Learn How To Strike The Ball With This Step By Step Tutorial.mp4',
            'assets/football/keeper/5 Shooting Techniques Explained _ Learn How To Strike The Ball With This Step By Step Tutorial.mp4',
        ];
        break;

    case "throw":
        $images = [
            'assets/football/throw/messi.jpg',
            'assets/football/throw/crrr.jpg',
            'assets/football/throw/neymar.jpg',
            'assets/football/throw/mbappe.jpg',
        ];
        $videos = [
            'assets/football/throw/5 Shooting Techniques Explained _ Learn How To Strike The Ball With This Step By Step Tutorial.mp4',
            'assets/football/throw/5 Shooting Techniques Explained _ Learn How To Strike The Ball With This Step By Step Tutorial.mp4',
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