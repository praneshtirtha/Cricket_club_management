<?php
// Start the session
session_start();

// Include the database connection file
require_once 'db_connection.php';

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to the home page if not logged in
    header("Location: index.php");
    exit();
}

// Initialize a message variable
$message = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize the input values
    $matchNo = isset($_POST['MatchNo']) ? trim($_POST['MatchNo']) : '';
    $homeTeamScore = isset($_POST['HomeTeamScore']) ? trim($_POST['HomeTeamScore']) : '';
    $awayTeamScore = isset($_POST['AwayTeamScore']) ? trim($_POST['AwayTeamScore']) : '';
    $matchOutcome = isset($_POST['MatchOutcome']) ? trim($_POST['MatchOutcome']) : '';
    $pom = isset($_POST['POM']) ? trim($_POST['POM']) : '';

    // Validate input fields
    if (empty($matchNo) || empty($homeTeamScore) || empty($awayTeamScore) || empty($matchOutcome) || empty($pom)) {
        $message = "All fields are required!";
    } else {
        // Check if the match exists in the matchresult table
        $checkQuery = "SELECT * FROM matchresult WHERE MatchNo = ?";
        $stmtCheck = $conn->prepare($checkQuery);
        $stmtCheck->bind_param("i", $matchNo);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        // If the match doesn't exist, insert a new placeholder entry into matchresult
        if ($resultCheck->num_rows == 0) {
            $insertQuery = "INSERT INTO matchresult (MatchNo, HomeTeamScore, AwayTeamScore, MatchOutcome, POM) 
                            VALUES (?, 0, 0, 'Pending', '')"; // Default values for match result
            $stmtInsert = $conn->prepare($insertQuery);
            $stmtInsert->bind_param("i", $matchNo);
            if (!$stmtInsert->execute()) {
                $message = "Error inserting new record into matchresult: " . $stmtInsert->error;
            } else {
                $message = "New record inserted into matchresult for MatchNo = " . $matchNo;
            }
            $stmtInsert->close();
        }

        // Now proceed to update the matchresult table
        $query = "UPDATE matchresult 
                  SET HomeTeamScore = ?, AwayTeamScore = ?, MatchOutcome = ?, POM = ? 
                  WHERE MatchNo = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $homeTeamScore, $awayTeamScore, $matchOutcome, $pom, $matchNo);

        if ($stmt->execute()) {
            $message = "Match result updated successfully!";
        } else {
            $message = "Error updating match result: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
        $stmtCheck->close();
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Match Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <h1 class="text-center">Update Match Result</h1>
        <?php if (!empty($message)) { ?>
            <div class="alert alert-info text-center">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php } ?>

        <!-- Form for updating match results -->
        <form method="POST" class="bg-light text-dark p-4 rounded">
            <div class="mb-3">
                <label for="MatchNo" class="form-label">Match Number</label>
                <input type="number" class="form-control" id="MatchNo" name="MatchNo" required>
            </div>
            <div class="mb-3">
                <label for="HomeTeamScore" class="form-label">Home Team Score</label>
                <input type="text" class="form-control" id="HomeTeamScore" name="HomeTeamScore" required>
            </div>
            <div class="mb-3">
                <label for="AwayTeamScore" class="form-label">Away Team Score</label>
                <input type="text" class="form-control" id="AwayTeamScore" name="AwayTeamScore" required>
            </div>
            <div class="mb-3">
                <label for="MatchOutcome" class="form-label">Match Outcome</label>
                <input type="text" class="form-control" id="MatchOutcome" name="MatchOutcome" required>
            </div>
            <div class="mb-3">
                <label for="POM" class="form-label">Player of the Match (POM)</label>
                <input type="text" class="form-control" id="POM" name="POM" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Result</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
