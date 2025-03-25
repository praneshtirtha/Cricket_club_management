<?php
// Start the session
session_start();

// Check if user is logged in and if club is registered
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['club_registered']) || !$_SESSION['club_registered']) {
    echo "<p>Please register a club first.</p>";
    exit();
}

// Include database connection
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $memberName = $_POST['committee_member_name'];
    $role = $_POST['role'];
    $phoneNumber = $_POST['phone_number'];
    $email = $_POST['email'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $clubID = $_SESSION['ClubID']; // Assuming you have the club ID stored in the session

    // Prepare SQL query to insert committee member
    $sql = "INSERT INTO committee_management (MemberName, StartDate, EndDate, Role, PhoneNumber, Email, ClubID) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the prepared statement
        $stmt->bind_param("sssssss", $memberName, $startDate, $endDate, $role, $phoneNumber, $email, $clubID);

        // Execute the query
        if ($stmt->execute()) {
            // Successfully added committee member
            echo "<p>Committee member registered successfully!</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<p>Error preparing the statement: " . $conn->error . "</p>";
    }
    
    // Close the connection
    $conn->close();
}
?>
