<?php
// Start session
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the club ID from the hidden input
    $clubId = $_POST['clubId'];
    
    // Check if the expected player data arrays are set
    if (isset($_POST['playerName']) && isset($_POST['age']) && isset($_POST['playingStyle']) && isset($_POST['phoneNumber']) && isset($_POST['email'])) {
        // Loop through the submitted player data
        $playerNames = $_POST['playerName'];
        $ages = $_POST['age'];
        $playingStyles = $_POST['playingStyle'];
        $phoneNumbers = $_POST['phoneNumber'];
        $emails = $_POST['email'];

        // Insert each player into the database
        for ($i = 0; $i < count($playerNames); $i++) {
            // Make sure all data is set and not empty
            $playerName = !empty($playerNames[$i]) ? $conn->real_escape_string($playerNames[$i]) : null;
            $age = isset($ages[$i]) && !empty($ages[$i]) ? (int)$ages[$i] : null;
            $playingStyle = !empty($playingStyles[$i]) ? $conn->real_escape_string($playingStyles[$i]) : null;
            $phoneNumber = !empty($phoneNumbers[$i]) ? $conn->real_escape_string($phoneNumbers[$i]) : null;
            $email = !empty($emails[$i]) ? $conn->real_escape_string($emails[$i]) : null;

            // If any of the fields are empty, skip this iteration (or handle as needed)
            if (empty($playerName) || empty($age) || empty($playingStyle) || empty($phoneNumber) || empty($email)) {
                continue; // Skip this player if any essential field is empty
            }

            // SQL to insert the player
            $sql = "INSERT INTO player (Name, Age, PlayingStyle, Email, PhoneNumber, ClubID)
                    VALUES ('$playerName', $age, '$playingStyle', '$email', '$phoneNumber', '$clubId')";

            if ($conn->query($sql) !== TRUE) {
                $_SESSION['error_message'] = "Error: " . $conn->error;
                header("Location: register_players.php?clubId=$clubId");
                exit();
            }
        }

        $_SESSION['success_message'] = "Players registered successfully!";
        header("Location: dash.php"); // Redirect to Dashboard
        exit();
    } else {
        // Handle case where expected data is missing
        $_SESSION['error_message'] = "Error: Missing player information!";
        header("Location: register_players.php?clubId=$clubId");
        exit();
    }
}

$conn->close();
?>
