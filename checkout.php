<?php
// checkout.php
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $train_id = $_POST['train_id'];
    $full_name = $_POST['full_name'];
    $travel_date = $_POST['travel_date'];
    $number_of_seats = $_POST['number_of_seats'];
    $customer_id = isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : null;

    // Fetch train details
    $query = "SELECT * FROM Trains WHERE TrainID = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $train_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $train = $result->fetch_assoc();
    $price_per_seat = $train['Price'];

    // Calculate total price
    $total_price = $price_per_seat * $number_of_seats;

    if ($customer_id) {
        // Fetch discount if any
        $query = "SELECT RailcardID FROM RegisteredCustomers WHERE CustomerID = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $customer = $result->fetch_assoc();

        if ($customer['RailcardID']) {
            $query = "SELECT DiscountAmount FROM Railcard WHERE RailcardID = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("i", $customer['RailcardID']);
            $stmt->execute();
            $result = $stmt->get_result();
            $railcard = $result->fetch_assoc();
            $discount = $railcard['DiscountAmount'];
            $total_price -= $total_price * $discount;
        }
    }

    // Insert booking record without BookingDate and BookingTime
    $query = "INSERT INTO Bookings (TrainID, CustomerID, TravelDate, NumberOfSeats, TotalPrice, DepartureStation, ArrivalStation) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);

    // Check if customer_id is null and set default value (0 or another appropriate value)
    if ($customer_id === null) {
        $customer_id = 0; // or another appropriate default value for guest users
    }

    $stmt->bind_param("iisdsss", $train_id, $customer_id, $travel_date, $number_of_seats, $total_price, $train['Source'], $train['Destination']);
    $stmt->execute();
    $booking_id = $stmt->insert_id;
    $stmt->close();

    // Redirect to payment page
    header("Location: payment.php?booking_id=$booking_id");
    exit;
}
?>
