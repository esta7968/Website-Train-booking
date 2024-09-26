<?php
// success.php
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];
    $payment_method = $_POST['payment_method'];
    $amount_paid = 0;

    // Dummy payment processing logic
    $query = "SELECT TotalPrice, TravelDate, NumberOfSeats, TrainID FROM Bookings WHERE BookingID = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
    $amount_paid = $booking['TotalPrice'];

    // Fetch train details for Dept_time and Arrival_time
    $query = "SELECT DepartureTime, ArrivalTime FROM Trains WHERE TrainID = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $booking['TrainID']);
    $stmt->execute();
    $result = $stmt->get_result();
    $train = $result->fetch_assoc();
    $dept_time = $train['DepartureTime'];
    $arrival_time = $train['ArrivalTime'];

    // Process based on payment method
    if ($payment_method === "credit_card") {
        $card_number = $_POST['card_number'];
        $expiry_date = $_POST['expiry_date'];
        $cvv = $_POST['cvv'];
        
    
    } else if ($payment_method === "paypal") {
        $paypal_email = $_POST['paypal_email'];
        
    }

    // Insert payment record
    $query = "INSERT INTO Payment (BookingID, AmountPaid, PaymentMethod) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ids", $booking_id, $amount_paid, $payment_method);
    $stmt->execute();
    $stmt->close();

    // Insert ticket record
    $query = "INSERT INTO Ticket (BookingID, NumberOfSeats, TravelDate, Dept_time, Arrival_time) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("iisss", $booking_id, $booking['NumberOfSeats'], $booking['TravelDate'], $dept_time, $arrival_time);
    $stmt->execute();
    $stmt->close();

    header("Location: ticket.php?booking_id=$booking_id");
    exit;
}
?>
