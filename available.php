<?php
include("db_connection.php");

$source = $_POST['source'];
$destination = $_POST['destination'];
$departure_time = $_POST['departure_time'];
$departure_date = $_POST['departure_date'];

$query = "SELECT * FROM trains WHERE Source = ? AND Destination = ? AND DepartureTime = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("sss", $source, $destination, $departure_time);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Train Details</title>
</head>
<body>
    <nav>
        <div class="logo">
            <h1>Treazure</h1>
        </div>
    </nav>
    <section>
        <div class="wrapper">
            <h1>Available Trains</h1>
            <div class="train-listings">
                <table>
                    <thead>
                        <tr>
                            <th>TrainID</th>
                            <th>Source</th>
                            <th>Destination</th>
                            <th>Departure Time</th>
                            <th>Arrival Time</th>
                            <th>Departure Platform</th>
                            <th>Arrival Platform</th>
                            <th>Available Seats</th>
                            <th>Class</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr onclick=\"navigateToBooking(" . $row['TrainID'] . ")\">";
                                echo "<td>" . $row["TrainID"] . "</td>";
                                echo "<td>" . $row["Source"] . "</td>";
                                echo "<td>" . $row["Destination"] . "</td>";
                                echo "<td>" . $row["DepartureTime"] . "</td>";
                                echo "<td>" . $row["ArrivalTime"] . "</td>";
                                echo "<td>" . $row["DeparturePlatform"] . "</td>";
                                echo "<td>" . $row["ArrivalPlatform"] . "</td>";
                                echo "<td>" . $row["AvailableSeats"] . "</td>";
                                echo "<td>" . $row["Class"] . "</td>";
                                echo "<td>" . $row["Price"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10'>No trains available for the selected route and time.</td></tr>";
                        }
                        $stmt->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script>
        function navigateToBooking(trainID) {
            window.location.href = 'booking.php?train_id=' + trainID;
        }
    </script>
</body>
</html>
