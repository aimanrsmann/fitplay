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
$userID = $_SESSION['UserID'];

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
    $status = "Pending";
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

    // Insert booking into the database
    $insertQuery = "INSERT INTO booking (UserID, SportID, CourtID, Time, Date,Status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iiisss", $userID, $sportID, $courtID, $start_time, $date, $status);

    if ($stmt->execute()) {
        echo "<script>
                var bookingSuccess = true;
                var selectedDate = '" . $date . "';
                var selectedSport = '" . $sportName . "';
                alert('Booking confirmed successfully!');
              </script>";
    } else {
        echo "<script>
                alert('Error: ' + " . json_encode($stmt->error) . ");
                var bookingSuccess = false; // Set booking failure flag
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
    <title>FitPlay - Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css">
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
    </nav><br><br>

    <!-- Football Booking Section -->
    <section id="football-booking" class="py-16 container mx-auto px-4 mb-10">
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
    </section>

    <!-- Training Tips Popup -->
    <div id="training-popup" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm text-center">
            <h3 class="text-lg font-bold mb-4">Need Training Tips?</h3>
            <p>Do you want some training tips before your sport session?</p>
            <div class="mt-4 flex justify-center space-x-4">
                <button id="yes-tips" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Yes</button>
                <button id="no-tips" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">No</button>
            </div>
        </div>
    </div>


    <footer class="bg-gray-800 text-white text-center py-4 w-full mt-auto fixed bottom-0 left-0 right-0">
        &copy; 2025 FitPlay
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dateInput = document.getElementById("date");

            // Function to get today's date in Asia/Kuala Lumpur timezone
            function getTodayDate() {
                const now = new Date();
                const malaysiaTime = new Date(now.toLocaleString("en-US", {
                    timeZone: "Asia/Kuala_Lumpur"
                }));

                const year = malaysiaTime.getFullYear();
                const month = String(malaysiaTime.getMonth() + 1).padStart(2, "0"); // Ensure 2-digit format
                const day = String(malaysiaTime.getDate()).padStart(2, "0");

                return `${year}-${month}-${day}`;
            }

            // Set the minimum selectable date
            dateInput.min = getTodayDate();
        });

        const allSlots = [
            "9:00 AM - 10:00 AM", "10:00 AM - 11:00 AM", "11:00 AM - 12:00 PM",
            "12:00 PM - 1:00 PM", "1:00 PM - 2:00 PM", "2:00 PM - 3:00 PM",
            "3:00 PM - 4:00 PM", "4:00 PM - 5:00 PM", "5:00 PM - 6:00 PM",
            "6:00 PM - 7:00 PM", "7:00 PM - 8:00 PM", "8:00 PM - 9:00 PM",
            "9:00 PM - 10:00 PM", "10:00 PM - 11:00 PM"
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

                    timeSlotsDiv.innerHTML = "";
                    allSlots.forEach(slot => {
                        const slotBtn = document.createElement("button");
                        slotBtn.className = "slot-btn px-4 py-2 rounded w-full relative"; // Ensure relative for tooltip positioning
                        slotBtn.innerText = slot;

                        // Check if the slot is booked
                        const bookedSlot = bookedSlots.find(b => mapBookedTimeToRange(b.Time) === slot);

                        if (bookedSlot) {
                            // If the slot is booked but rejected, don't disable it
                            if (bookedSlot.Status == 'Pending' || bookedSlot.Status == 'Booked') {
                                slotBtn.disabled = true;
                                slotBtn.classList.add("bg-red-500", "text-white", "cursor-not-allowed");

                                // Create tooltip for booked slot
                                const tooltip = document.createElement("div");
                                tooltip.className = "absolute left-0 top-full mt-1 bg-black text-white text-sm px-2 py-1 rounded hidden";
                                tooltip.innerText = `Booked by: ${bookedSlot.Email}\nSport: ${bookedSlot.SportName}`;

                                // Show tooltip on hover
                                slotBtn.addEventListener("mouseenter", () => {
                                    tooltip.classList.remove("hidden");
                                });

                                slotBtn.addEventListener("mouseleave", () => {
                                    tooltip.classList.add("hidden");
                                });

                                // Append tooltip to button
                                slotBtn.appendChild(tooltip);
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
                            // else {
                            //     // If the status is 'Rejected', allow the slot to be clickable (not disabled)
                            //     slotBtn.classList.add("bg-yellow-500", "text-white", "hover:bg-yellow-600");
                            //     slotBtn.addEventListener("click", function(event) {
                            //         event.preventDefault();
                            //         document.querySelectorAll(".slot-btn").forEach(btn => btn.classList.remove("bg-blue-500"));
                            //         slotBtn.classList.add("bg-blue-500");
                            //         document.getElementById("selected-slot").value = slot;
                            //         document.getElementById("confirm-btn").classList.remove("opacity-50", "cursor-not-allowed");
                            //         document.getElementById("confirm-btn").disabled = false;
                            //     });
                            // }
                        } 
                        else {
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

        // Wait until the DOM content is loaded
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("date").value = selectedDate; // Set the date field

            // Check if the booking was successful from the PHP script
            if (typeof bookingSuccess !== 'undefined' && bookingSuccess === true) {
                // When the alert from PHP is dismissed, show the popup
                setTimeout(function() {
                    document.getElementById("training-popup").classList.remove("hidden");
                }, 300); // Delay to make sure alert is dismissed
            }

            // Handle "Yes" button (show AI tips)
            document.getElementById("yes-tips").addEventListener("click", function() {
                // Redirect to the next page after showing training tips
                window.location.href = "training-details.php?sport=" + selectedSport;
            });

            // Handle "No" button (close popup and reload page)
            document.getElementById("no-tips").addEventListener("click", function() {
                // Close the training popup
                document.getElementById("training-popup").classList.add("hidden");
                // alert("Alright! Enjoy your upcoming session.");

                // Reload the page
                window.location.href = 'booking.php';
            });
        });
    </script>

</body>

</html>