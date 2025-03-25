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

// Fetch all teams (clubs) and venues for the dropdowns
$clubsQuery = "SELECT ClubID, ClubName FROM club";
$clubsResult = mysqli_query($conn, $clubsQuery);

$venuesQuery = "SELECT VenueID, VenueName FROM venue";
$venuesResult = mysqli_query($conn, $venuesQuery);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form input values
    $homeTeam = $_POST['homeTeam'];
    $awayTeam = $_POST['awayTeam'];
    $matchDate = $_POST['matchDate'];
    $matchTime = $_POST['matchTime'];
    $venueID = $_POST['venueID'];

    // Insert match schedule into the database
    $query = "INSERT INTO matches(HomeTeam, AwayTeam, Date, Time, VenueID) 
              VALUES ('$homeTeam', '$awayTeam', '$matchDate', '$matchTime', '$venueID')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Match scheduled successfully!'); window.location.href='welcome.php';</script>";
    } else {
        echo "<script>alert('Error scheduling match: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule a Match</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <h1 class="text-center">Schedule a New Match</h1>
        <form method="POST" class="mt-4">
            <!-- Home Team -->
            <div class="mb-3">
                <label for="homeTeam" class="form-label">Home Team</label>
                <select class="form-select" id="homeTeam" name="homeTeam" required>
                    <option value="">Select Home Team</option>
                    <?php while ($club = mysqli_fetch_assoc($clubsResult)): ?>
                        <option value="<?php echo $club['ClubID']; ?>"><?php echo htmlspecialchars($club['ClubName']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Away Team -->
            <div class="mb-3">
                <label for="awayTeam" class="form-label">Away Team</label>
                <select class="form-select" id="awayTeam" name="awayTeam" required>
                    <option value="">Select Away Team</option>
                    <?php mysqli_data_seek($clubsResult, 0); // Reset the pointer to fetch clubs again ?>
                    <?php while ($club = mysqli_fetch_assoc($clubsResult)): ?>
                        <option value="<?php echo $club['ClubID']; ?>"><?php echo htmlspecialchars($club['ClubName']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Match Date -->
            <div class="mb-3">
                <label for="matchDate" class="form-label">Match Date</label>
                <input type="date" class="form-control" id="matchDate" name="matchDate" required>
            </div>

            <!-- Match Time -->
            <div class="mb-3">
                <label for="matchTime" class="form-label">Match Time</label>
                <input type="time" class="form-control" id="matchTime" name="matchTime" required>
            </div>

            <!-- Venue -->
            <div class="mb-3">
                <label for="venueID" class="form-label">Venue</label>
                <select class="form-select" id="venueID" name="venueID" required>
                    <option value="">Select Venue</option>
                    <?php while ($venue = mysqli_fetch_assoc($venuesResult)): ?>
                        <option value="<?php echo $venue['VenueID']; ?>"><?php echo htmlspecialchars($venue['VenueName']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Schedule Match</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
