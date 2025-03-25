<?php
// Start the session
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

// Include the database connection
include('db_connection.php');

// Check if the form is submitted to add a new official
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form input values
    $officialName = $_POST['officialName'];
    $role = $_POST['role'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];

    // Insert new official into the database
    $query = "INSERT INTO matchofficial (OfficialName, Role, PhoneNumber, Email) 
              VALUES ('$officialName', '$role', '$phoneNumber', '$email')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Official added successfully!'); window.location.href='welcome.php';</script>";
    } else {
        echo "<script>alert('Error adding official: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Match Official</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <h1 class="text-center">Add New Match Official</h1>
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="officialName" class="form-label">Official Name</label>
                <input type="text" class="form-control" id="officialName" name="officialName" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <input type="text" class="form-control" id="role" name="role" required>
            </div>
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Add Official</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
