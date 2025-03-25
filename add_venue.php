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

// Check if the form is submitted to add a new venue
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form input values
    $venueName = $_POST['venueName'];
    $location = $_POST['location'];
    $availability = $_POST['availability'];
    $capacity = $_POST['capacity'];

    // Insert new venue into the database
    $query = "INSERT INTO venue (VenueName, Location, Availability, Capacity) 
              VALUES ('$venueName', '$location', '$availability', '$capacity')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Venue added successfully!'); window.location.href='welcome.php';</script>";
    } else {
        echo "<script>alert('Error adding venue: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Venue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <h1 class="text-center">Add New Venue</h1>
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="venueName" class="form-label">Venue Name</label>
                <input type="text" class="form-control" id="venueName" name="venueName" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>
            <div class="mb-3">
                <label for="availability" class="form-label">Availability</label>
                <input type="text" class="form-control" id="availability" name="availability" required>
            </div>
            <div class="mb-3">
                <label for="capacity" class="form-label">Capacity</label>
                <input type="number" class="form-control" id="capacity" name="capacity" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Add Venue</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
