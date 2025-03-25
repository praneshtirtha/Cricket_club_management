<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clubId = $_POST['clubId'];

    $memberNames = $_POST['memberName'];
    $roles = $_POST['role'];
    $phoneNumbers = $_POST['phoneNumber'];
    $emails = $_POST['email'];
    $startDates = $_POST['startDate'];
    $endDates = $_POST['endDate'];

    for ($i = 0; $i < count($memberNames); $i++) {
        $memberName = $conn->real_escape_string($memberNames[$i]);
        $role = $conn->real_escape_string($roles[$i]);
        $phoneNumber = $conn->real_escape_string($phoneNumbers[$i]);
        $email = $conn->real_escape_string($emails[$i]);
        $startDate = $conn->real_escape_string($startDates[$i]);
        $endDate = $conn->real_escape_string($endDates[$i]);

        $sql = "INSERT INTO managementcommittee (MemberName, Role, PhoneNumber, Email, StartDate, EndDate, ClubID)
                VALUES ('$memberName', '$role', '$phoneNumber', '$email', '$startDate', '$endDate', '$clubId')";

        if (!$conn->query($sql)) {
            $_SESSION['error_message'] = "Error: " . $conn->error;
            header("Location: management_committee_registration.php?clubId=$clubId");
            exit();
        }
    }

    $_SESSION['committee_registered'] = true;
    $_SESSION['success_message'] = "Committee members registered successfully!";
    header("Location: dash.php?clubId=$clubId");
    exit();
}
?>
