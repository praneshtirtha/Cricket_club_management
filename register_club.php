<?php
include 'db_connection.php'; // Include the database connection file
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    echo "You must be logged in to register a club.";
    exit();
}

// Get the logged-in user's ID
$userID = $_SESSION['UserID'];

// Check if the user has already registered a club
$checkClubQuery = "SELECT * FROM Club WHERE UserID = '$userID'";
$checkClubResult = mysqli_query($conn, $checkClubQuery);

if (mysqli_num_rows($checkClubResult) > 0) {
    // User has already registered a club
    echo "You have already registered a club. You cannot register another one.";
    exit();
}

// Register the new club if no existing club
if (isset($_POST['register_club'])) {
    $clubName = $_POST['ClubName'];
    $foundingDate = $_POST['FoundingDate'];
    $location = $_POST['Location'];
    $email = $_POST['Email'];
    $phoneNumber = $_POST['PhoneNumber'];

    // Insert new club into the database
    $query = "INSERT INTO Club (ClubName, FoundingDate, Location, Email, PhoneNumber, UserID) 
              VALUES ('$clubName', '$foundingDate', '$location', '$email', '$phoneNumber', '$userID')";
    if (mysqli_query($conn, $query)) {
        $clubID = mysqli_insert_id($conn); // Get the ClubID of the new club
        $_SESSION['ClubID'] = $clubID; // Store ClubID for further forms
        $_SESSION['club_registered'] = true; // Mark club as registered
        header("Location: management_committee_registration.php?clubId=$clubID"); // Redirect to committee registration
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Club</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            background-color: #cceecc; /* Light yellow-green color */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <h2 class="form-header">Register Club</h2>
                    <form method="post">
                        <div class="mb-3">
                            <label for="ClubName" class="form-label">Club Name</label>
                            <input type="text" class="form-control" id="ClubName" name="ClubName" placeholder="Enter club name" required>
                        </div>
                        <div class="mb-3">
                            <label for="FoundingDate" class="form-label">Founding Date</label>
                            <input type="date" class="form-control" id="FoundingDate" name="FoundingDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="Location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="Location" name="Location" placeholder="Enter location" required>
                        </div>
                        <div class="mb-3">
                            <label for="Email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="Email" name="Email" placeholder="Enter email" required>
                        </div>
                        <div class="mb-3">
                            <label for="PhoneNumber" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="PhoneNumber" name="PhoneNumber" placeholder="Enter phone number" required>
                        </div>
                        <button type="submit" name="register_club" class="btn btn-primary w-100">Register Club</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Placeholder Removal -->
    <script>
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', () => {
                input.placeholder = ''; // Clear placeholder on focus
            });
            input.addEventListener('blur', () => {
                // Restore placeholder if the input is empty
                if (!input.value) {
                    input.placeholder = input.getAttribute('placeholder-default');
                }
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
