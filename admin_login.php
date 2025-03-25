<?php
// Admin login credentials
$adminUsername = "tirtha";
$adminPassword = "cse311";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered username and password
    $enteredUsername = $_POST['adminUsername'];
    $enteredPassword = $_POST['adminPassword'];

    // Validate the credentials
    if ($enteredUsername === $adminUsername && $enteredPassword === $adminPassword) {
        // Start a session and store login status
        session_start();
        $_SESSION['admin_logged_in'] = true;
        // Redirect to welcome page
        header("Location: welcome.php");
        exit();
    } else {
        // Invalid credentials, show error message
        echo "<script>alert('Invalid username or password');</script>";
    }
}
?>
