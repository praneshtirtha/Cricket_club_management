<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root"; // Replace with your database username
    $password = "";     // Replace with your database password
    $dbname = "cricketclubmanagement_updated"; // Replace with your database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize user input
    $clubId = $conn->real_escape_string($_POST['clubId']);
    $memberName = $conn->real_escape_string($_POST['memberName']);
    $startDate = $conn->real_escape_string($_POST['startDate']);
    $endDate = isset($_POST['endDate']) ? $conn->real_escape_string($_POST['endDate']) : null;
    $role = $conn->real_escape_string($_POST['role']);
    $phoneNumber = isset($_POST['phoneNumber']) ? $conn->real_escape_string($_POST['phoneNumber']) : null;
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : null;

    // Insert data into the committee table
    $sql = "INSERT INTO committee (MemberName, StartDate, EndDate, Role, PhoneNumber, Email, ClubID)
            VALUES ('$memberName', '$startDate', '$endDate', '$role', '$phoneNumber', '$email', '$clubId')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Committee member registered successfully!";
        header("Location: dash.php"); // Redirect to dashboard or any desired page
        exit();
    } else {
        $_SESSION['error_message'] = "Error: " . $sql . "<br>" . $conn->error;
        header("Location: management_committee_registration.php?clubId=$clubId");
        exit();
    }

    $conn->close();
}
?>
