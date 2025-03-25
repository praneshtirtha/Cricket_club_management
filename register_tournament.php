<?php
session_start();
include('db_connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch tournaments for the dropdown
$query = "SELECT TournamentID, TournamentName, TournamentDate FROM tournament ";
$result = mysqli_query($conn, $query);

$tournaments = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tournaments[] = $row;
    }
}

// Handle tournament registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tournament_id'])) {
    $tournament_id = intval($_POST['tournament_id']);
    $user_id = $_SESSION['user_id']; // Assuming user ID is stored in the session

    // Retrieve user's club ID (replace with actual logic to fetch club ID)
    $club_id_query = "SELECT club_id FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $club_id_query);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $club_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Ensure the tournament exists
    $tournament_query = "SELECT TournamentName FROM tournament WHERE TournamentID = ?";
    $stmt = mysqli_prepare($conn, $tournament_query);
    mysqli_stmt_bind_param($stmt, 'i', $tournament_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $tournament_name);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($tournament_name && $club_id) {
        // Register the club for the tournament
        $insert_query = "INSERT INTO tor_played (TournamentName, ClubID) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $insert_query);
        mysqli_stmt_bind_param($stmt, 'si', $tournament_name, $club_id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success_message'] = "Successfully registered for the tournament: " . htmlspecialchars($tournament_name);
        } else {
            $_SESSION['error_message'] = "Error registering for the tournament.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error_message'] = "Invalid tournament or club ID.";
    }

    // Redirect to avoid form resubmission
    header("Location: register_tournament.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for Tournament</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['success_message']; 
                unset($_SESSION['success_message']); 
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php 
                echo $_SESSION['error_message']; 
                unset($_SESSION['error_message']); 
            ?>
        </div>
    <?php endif; ?>

    <h1 class="mb-4">Register for a Tournament</h1>

    <?php if (!empty($tournaments)): ?>
        <form action="register_tournament.php" method="POST">
            <div class="mb-3">
                <label for="tournament" class="form-label">Select Tournament</label>
                <select name="tournament_id" id="tournament" class="form-select" required>
                    <option value="">-- Select Tournament --</option>
                    <?php foreach ($tournaments as $tournament): ?>
                        <option value="<?php echo $tournament['TournamentID']; ?>">
                            <?php echo htmlspecialchars($tournament['TournamentName']); ?> 
                            (<?php echo htmlspecialchars($tournament['TournamentDate']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    <?php else: ?>
        <p>No tournaments available for registration at the moment.</p>
    <?php endif; ?>
</div>

</body>
</html>
