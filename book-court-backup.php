<?php
include "config.php";

$sport = $_GET['sport'];
$userID = 1;

if ($sport == 'Football') {
    $sport .= " Field";
} else {
    $sport .= " Court";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $time_slot = $_POST['time_slot'];
    $sportName = $_GET['sport']; // Get sport from URL parameter
    $courtID = 1;

    $time_parts = explode(" - ", $time_slot); // Split the range
    $start_time = date("H:i", strtotime($time_parts[0])); // Convert to 24-hour format



    // Get SportID based on SportName
    $query = "SELECT SportID FROM sport WHERE SportName = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $sportName);
    $stmt->execute();
    $stmt->bind_result($sportID);
    $stmt->fetch();
    $stmt->close();

    if (!$sportID) {
        die("Error: Sport not found.");
    }
    echo "UserID: $userID <br>";
    echo "SportID: $sportID <br>";
    echo "Date: $date <br>";
    echo "Time Slot: $time_slot <br>";
    echo "UserID: $userID <br>";
    echo "SportID: $sportID <br>";
    echo "Date: $date <br>";
    echo "Time Slot: $start_time <br>";
    // Insert booking into the database
    $insertQuery = "INSERT INTO booking (UserID, SportID, CourtID, Time, Date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iiiss", $userID, $sportID, $courtID, $start_time, $date);

    if ($stmt->execute()) {
        echo "<script>alert('Booking confirmed successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $stmt->error; // This will show the MySQL error message
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
    <title>FitPlay - Football Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css">
    <style>
        .slot-btn:disabled {
            background-color: #ef4444 !important;
            /* Tailwind red-500 */
            color: white !important;
            cursor: not-allowed !important;
        }
    </style>
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
                <li><a href="aitips.php" class="nav-link">Training Tips</a></li>
                <li><a href="contact.php" class="nav-link">Contact Us</a></li>
                <li><a href="logout.php" class="nav-link">Logout</a></li>
            </ul>
        </div>
    </nav><br><br>

    <!-- Football Booking Section -->
    <section id="football-booking" class="py-16 container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-8"><?php echo $sport ?> Booking</h2>
        <p class="text-center text-lg text-gray-700 mb-6">Click on an available time slot to book your session.</p>
        <form method="POST" action="">
            <div class="max-w-lg mx-auto bg-white p-6 shadow-lg rounded-lg">
                <label class="block text-lg font-semibold mb-2" for="date">Choose Date:</label>
                <input type="date" id="date" name="date" class="w-full border p-2 rounded mb-4" required>

                <div id="slots-container" class="hidden">
                    <h3 class="text-lg font-semibold mb-2">Available Time Slots:</h3>
                    <div id="time-slots" class="grid grid-cols-2 gap-4"></div>
                </div>

                <!-- Hidden input to store selected slot -->
                <input type="hidden" id="selected-slot" name="time_slot">

                <button id="confirm-btn" class="btn w-full py-3 mt-4 bg-blue-500 text-white rounded cursor-not-allowed opacity-50" disabled>
                    Confirm Booking
                </button>
            </div>
        </form>
        <!-- AI Training Recommendation Section -->
        <div id="ai-tips" class="max-w-lg mx-auto bg-blue-100 p-6 mt-8 shadow-lg rounded-lg hidden">
            <h3 class="text-xl font-bold text-center">Training Tips</h3>
            <p id="tip-text" class="text-gray-700 mt-2 text-center"></p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="custom-footer text-white text-center py-6 mt-8">
        <p>&copy; 2025 FitPlay. All rights reserved.</p>
    </footer>

    <script>
        const allSlots = [
            "9:00 AM - 10:30 AM", "11:00 AM - 12:30 PM",
            "2:00 PM - 3:30 PM", "4:00 PM - 5:30 PM", "7:00 PM - 8:30 PM"
        ];

        
        // Function to convert 24-hour time (HH:mm:ss) to 12-hour format (h:mm A)
        function convertTo12Hour(time) {
            const [hour, minute] = time.split(":");
            const h = parseInt(hour, 10);
            const ampm = h >= 12 ? "PM" : "AM";
            const formattedHour = h % 12 || 12; // Convert 0 to 12
            return `${formattedHour}:${minute} ${ampm}`;
        }

        // Function to map single booked times to time ranges in allSlots
        function mapBookedTimeToRange(bookedTime) {
            const formattedTime = convertTo12Hour(bookedTime.substring(0, 5)); // Convert "18:00:00" → "6:00 PM"

            // Map the booked time to its respective time range
            return allSlots.find(slot => slot.startsWith(formattedTime));
        }

        document.getElementById("date").addEventListener("change", function() {
            const date = this.value;
            const urlParams = new URLSearchParams(window.location.search);
            const sport = urlParams.get("sport");

            const slotsContainer = document.getElementById("slots-container");
            const timeSlotsDiv = document.getElementById("time-slots");
            slotsContainer.classList.remove("hidden");
            timeSlotsDiv.innerHTML = "<p class='text-center text-gray-500'>Loading slots...</p>";

            fetch(`fetch-timeslot.php?date=${encodeURIComponent(date)}&sport=${encodeURIComponent(sport)}`)
                .then(response => response.json())
                .then(bookedSlots => {
                    console.log("Raw Booked Slots:", bookedSlots);

                    // Convert booked slots from "18:00:00" to mapped time ranges
                    const formattedBookedSlots = bookedSlots
                        .map(mapBookedTimeToRange)
                        .filter(Boolean); // Remove undefined values

                    console.log("Mapped Booked Slots:", formattedBookedSlots);

                    timeSlotsDiv.innerHTML = "";
                    allSlots.forEach(slot => {
                        const slotBtn = document.createElement("button");
                        slotBtn.className = "slot-btn px-4 py-2 rounded w-full";
                        slotBtn.innerText = slot;
                        slotBtn.disabled = formattedBookedSlots.includes(slot);

                        if (slotBtn.disabled) {
                            slotBtn.className += " bg-red-500 text-white cursor-not-allowed";
                        } else {
                            slotBtn.classList.add("bg-green-500", "text-white", "hover:bg-green-600");
                            slotBtn.addEventListener("click", function(event) {
                                event.preventDefault();
                                document.querySelectorAll(".slot-btn").forEach(btn => btn.classList.remove("bg-blue-500"));
                                slotBtn.classList.add("bg-blue-500");
                                document.getElementById("selected-slot").value = slot;
                                document.getElementById("confirm-btn").classList.remove("opacity-50", "cursor-not-allowed");
                                document.getElementById("confirm-btn").disabled = false;
                            });
                        }


                        timeSlotsDiv.appendChild(slotBtn);
                    });
                })
                .catch(error => {
                    console.error("Error fetching booked slots:", error);
                    timeSlotsDiv.innerHTML = "<p class='text-red-500 text-center'>Error loading slots.</p>";
                });
        });
    </script>

</body>

</html>