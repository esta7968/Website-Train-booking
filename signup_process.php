<?php
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $phone = $_POST['phone'];
    $railcard = $_POST['railcard'] == 'yes' ? $_POST['railcard_type'] : null;

    // Insert into Customers table
    $customer_query = "INSERT INTO Customers (FullName, Email, Phone) VALUES (?, ?, ?)";
    $stmt = $db->prepare($customer_query);
    $stmt->bind_param("sss", $full_name, $email, $phone);
    $stmt->execute();
    $customer_id = $stmt->insert_id;
    $stmt->close();

    if ($railcard) {
        // Retrieve or insert railcard ID from Railcard table
        $railcard_query = "SELECT RailcardID FROM Railcard WHERE RailcardType = ?";
        $stmt = $db->prepare($railcard_query);
        $stmt->bind_param("s", $railcard);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $railcard_id = $row['RailcardID'];
        } else {
            $stmt->close();
            $insert_railcard_query = "INSERT INTO Railcard (RailcardType) VALUES (?)";
            $stmt = $db->prepare($insert_railcard_query);
            $stmt->bind_param("s", $railcard);
            $stmt->execute();
            $railcard_id = $stmt->insert_id;
        }
        $stmt->close();

        // Insert into RegisteredCustomers table
        $registered_customer_query = "INSERT INTO RegisteredCustomers (CustomerID, RailcardID, Username, Password) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($registered_customer_query);
        $stmt->bind_param("iiss", $customer_id, $railcard_id, $username, $password);
        $stmt->execute();
        $stmt->close();
    } else {
        // Insert into RegisteredCustomers table without railcard
        $registered_customer_query = "INSERT INTO RegisteredCustomers (CustomerID, Username, Password) VALUES (?, ?, ?)";
        $stmt = $db->prepare($registered_customer_query);
        $stmt->bind_param("iss", $customer_id, $username, $password);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: home.html");
    exit;
}
?>
