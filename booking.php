<?php
// booking.php
include("db_connection.php");

$train_id = isset($_GET['train_id']) ? $_GET['train_id'] : null;

if (!$train_id) {
    // Handle case where train_id is not provided
    header("Location: available.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div class="logo">
            <h1>Treazure</h1>
        </div>
    </nav>
    <div class="wrapper">
        <form action="checkout.php" method="POST">
            <h1>Booking</h1>
            <input type="hidden" name="train_id" value="<?php echo $train_id; ?>">
            <div class="input-box">
                <input type="text" name="full_name" placeholder="Full Name" required>
                <i class="bx bx-user"></i>
            </div>
            <div class="input-box">
                <input type="date" name="travel_date" placeholder="Travel Date" required>
                <i class="bx bx-calendar"></i>
            </div>
            <div class="input-box">
                <input type="number" name="number_of_seats" placeholder="Number of Seats" min="1" required>
                <i class="bx bx-numeric"></i>
            </div>
            <button type="submit" class="btn">Book Now</button>
        </form>
    </div>
</body>
</html>
