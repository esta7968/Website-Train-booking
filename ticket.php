<?php
// ticket.php
include("db_connection.php");

$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : null;

if (!$booking_id) {
    header("Location: home.html");
    exit;
}

// Fetch booking details
$query = "SELECT * FROM Bookings WHERE BookingID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

// Fetch customer details
$query = "SELECT FullName FROM Customers WHERE CustomerID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $booking['CustomerID']);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

// Fetch ticket details
$query = "SELECT * FROM Ticket WHERE BookingID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$ticket = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Ticket</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div class="logo">
            <h1>Treazure</h1>
        </div>
    </nav>
    <div class="wrapper">
        <h1>Train Ticket</h1>
        <div class="ticket-details">
            <p><strong>Passenger Name:</strong> <?php echo $customer['FullName']; ?></p>
            <p><strong>Travel Date:</strong> <?php echo $booking['TravelDate']; ?></p>
            <p><strong>Number of Seats:</strong> <?php echo $booking['NumberOfSeats']; ?></p>
            <p><strong>Departure Station:</strong> <?php echo $booking['DepartureStation']; ?></p>
            <p><strong>Arrival Station:</strong> <?php echo $booking['ArrivalStation']; ?></p>
            <p><strong>Departure Time:</strong> <?php echo $ticket['Dept_time']; ?></p>
            <p><strong>Arrival Time:</strong> <?php echo $ticket['Arrival_time']; ?></p>
        </div>
        <button class="btn" onclick="location.href='home.html'">Go to Home Page</button>
    </div>
</body>
</html>
