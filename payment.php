<?php
// payment.php
include("db_connection.php");

$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : null;

if (!$booking_id) {
    header("Location: available.php");
    exit;
}

$query = "SELECT * FROM Bookings WHERE BookingID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();
$total_price = $booking['TotalPrice'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function showPaymentForm() {
            var method = document.getElementById("payment_method").value;
            var cardForm = document.getElementById("card_form");
            var paypalForm = document.getElementById("paypal_form");

            cardForm.style.display = "none";
            paypalForm.style.display = "none";

            if (method === "credit_card") {
                cardForm.style.display = "block";
            } else if (method === "paypal") {
                paypalForm.style.display = "block";
            }
        }
    </script>
</head>
<body>
    <nav>
        <div class="logo">
            <h1>Treazure</h1>
        </div>
    </nav>
    <div class="wrapper">
        <h1>Payment</h1>
        <p>Total Price: $<?php echo number_format($total_price, 2); ?></p>
        <form action="success.php" method="POST">
            <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
            <div class="input-box">
                <select id="payment_method" name="payment_method" onchange="showPaymentForm()" required>
                    <option value="">Select Payment Method</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                </select>
            </div>
            <div id="card_form" style="display: none;">
                <div class="input-box">
                    <input type="text" name="card_number" placeholder="Card Number">
                    <i class="bx bx-credit-card"></i>
                </div>
                <div class="input-box">
                    <input type="month" name="expiry_date" placeholder="Expiry Date">
                    <i class="bx bx-calendar"></i>
                </div>
                <div class="input-box">
                    <input type="text" name="cvv" placeholder="CVV">
                    <i class="bx bx-lock"></i>
                </div>
            </div>
            <div id="paypal_form" style="display: none;">
                <div class="input-box">
                    <input type="email" name="paypal_email" placeholder="PayPal Email">
                    <i class="bx bx-envelope"></i>
                </div>
            </div>
            <button type="submit" class="btn">Pay Now</button>
        </form>
    </div>
</body>
</html>
