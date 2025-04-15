<?php
include "config.php";

if (!isset($_SESSION['UserID'])) {
    echo "<script>
            alert('Please login to continue');
            window.location.href = 'login.php';
          </script>";
    exit;
}
$userID = $_SESSION['UserID'];

// Handle booking cancellation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_booking'])) {
    $bookingID = $_POST['booking_id'];

    // Delete query
    $query = "DELETE FROM Booking WHERE BookingID = ? AND UserID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $bookingID, $userID);

    if ($stmt->execute()) {
        echo "<script>alert('The selected booking has been cancelled!'); window.location.href='booking.php';</script>";
    } else {
        echo "<script>alert('Error cancelling booking!');</script>";
    }
    $stmt->close();
}

// Fetch booking data for the logged-in user
$sql = "SELECT B.BookingID, S.SportName, B.Date, B.Time, B.Status 
        FROM Booking B 
        JOIN Sport S ON B.SportID = S.SportID 
        WHERE B.UserID = ? 
        ORDER BY B.Date";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitPlay - Booking</title>
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

    function confirmDelete(bookingID) {
        if (confirm("Are you sure you want to cancel this booking?")) {
            document.getElementById("delete-form-" + bookingID).submit();
        }
    }
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
                <li><a href="training-tips.php" class="nav-link">Training Tips</a></li>
                <li><a href="booking.php" class="active">Booking</a></li>
                <li><a href="contact.php" class="nav-link">Contact Us</a></li>
                <li><a href="logout.php" class="nav-link">Logout</a></li>
            </ul>
        </div>
    </nav><br><br>

    <main class="p-6 mt-20 container mx-auto">
        <h1 class="text-3xl font-bold text-center mb-6">My Bookings</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead>
                    <tr class="bg-green-900 text-white">
                        <th class="py-3 px-6 text-left">No</th>
                        <th class="py-3 px-2 text-left">Booking ID</th>
                        <th class="py-3 px-6 text-left">Sport</th>
                        <th class="py-3 px-6 text-left">Date</th>
                        <th class="py-3 px-6 text-left">Time</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php
                        $count = 1;
                        while ($row = $result->fetch_assoc()): ?>
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-3 px-6"><?php echo $count; ?></td>
                                <td class="py-3 px-6"><?php echo $row['BookingID']; ?></td>
                                <td class="py-3 px-6"><?php echo $row['SportName']; ?></td>
                                <td class="py-3 px-6"><?php echo $row['Date']; ?></td>
                                <td class="py-3 px-6"><?php echo $row['Time']; ?></td>
                                <td class="py-3 px-6">
                                    <?php
                                    $statusClass = '';
                                    $statusText = $row['Status'];

                                    // Set styles based on status
                                    if ($statusText == 'Pending') {
                                        $statusClass = 'font-semibold text-yellow-500'; // Yellow for Pending
                                        $statusText = "Waiting for Admin approval";
                                    } elseif ($statusText == 'Rejected') {
                                        $statusClass = 'font-semibold text-red-500'; // Red for Rejected
                                    } elseif ($statusText == 'Booked') {
                                        $statusClass = 'font-semibold text-green-500'; // Green for Approved
                                    }
                                    ?>
                                    <span class="<?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                </td>
                                <td class="py-3 px-6">
                                    <?php if ($row['Status'] == 'Pending'): ?>
                                        <form id="delete-form-<?php echo $row['BookingID']; ?>" method="POST" style="display:inline;">
                                            <input type="hidden" name="booking_id" value="<?php echo $row['BookingID']; ?>">
                                            <input type="hidden" name="delete_booking" value="1">
                                            <button type="button" class="bg-orange-500 text-white px-4 py-2 rounded"
                                                onclick="confirmDelete(<?php echo $row['BookingID']; ?>)">Cancel</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-gray-500">-</span> <!-- Show text if status is rejected -->
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php $count++;
                        endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">No bookings found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </main>

    <footer class="bg-gray-800 text-white text-center py-4 w-full mt-auto fixed bottom-0 left-0 right-0">
        &copy; 2025 FitPlay
    </footer>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>