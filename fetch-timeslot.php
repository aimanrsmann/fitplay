<?php
// include "config.php";

// $date = $_GET['date'];
// $sport = $_GET['sport'];

// if (empty($date) || empty($sport)) {
//     echo json_encode([]);
//     exit;
// }

// $sql = "SELECT B.Time, U.email, S.SportName FROM BOOKING B 
//         JOIN SPORT S ON B.SportID = S.SportID 
//         JOIN USER U ON U.UserID = B.UserID
//         WHERE B.Date = ? AND S.SportName = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bind_param("ss", $date, $sport);
// $stmt->execute();
// $result = $stmt->get_result();

// $bookedSlots = [];
// while ($row = $result->fetch_assoc()) {
//     $bookedSlots[] = [
//         "Time" => $row['Time'],
//         "Email" => $row['email'],
//         "SportName" => $row['SportName']
//     ];
// }

// $stmt->close();
// $conn->close();

// echo json_encode($bookedSlots);
?>

<?php
include "config.php";

if (!isset($_SESSION['UserID'])) {
    echo "<script>
            alert('Please login to continue');
            window.location.href = 'login.php';
          </script>";
    exit;
}


$date = $_GET['date'];
$sport = $_GET['sport'];

if (empty($date) || empty($sport)) {
    echo json_encode([]);
    exit;
}

// Adjust condition to consider Futsal and Netball as the same court
$sportsToCheck = ($sport === "Futsal" || $sport === "Netball") ? ["Futsal", "Netball"] : [$sport];

// Create placeholders for SQL IN condition
$placeholders = implode(',', array_fill(0, count($sportsToCheck), '?'));

$sql = "SELECT B.Time, U.email, S.SportName, B.Status
FROM BOOKING B
JOIN (
    SELECT MAX(BookingID) as LatestBookingID
    FROM BOOKING
    WHERE Date = ?
    GROUP BY Time, SportID
) latest ON B.BookingID = latest.LatestBookingID
JOIN SPORT S ON B.SportID = S.SportID
JOIN USER U ON U.UserID = B.UserID
WHERE S.SportName IN ($placeholders) AND B.Status != 'Rejected'
";

$stmt = $conn->prepare($sql);
$types = str_repeat('s', count($sportsToCheck) + 1); // "ss" for date + sport(s)
$stmt->bind_param($types, $date, ...$sportsToCheck);
$stmt->execute();
$result = $stmt->get_result();

$bookedSlots = [];
while ($row = $result->fetch_assoc()) {
    $bookedSlots[] = [
        "Time" => $row['Time'],
        "Email" => $row['email'],
        "SportName" => $row['SportName'],
        "Status" => $row['Status']
    ];
}

$stmt->close();
$conn->close();

echo json_encode($bookedSlots);
?>
