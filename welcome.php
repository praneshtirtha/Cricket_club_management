<?php
// Start the session
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to the home page if not logged in
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <h1 class="text-center">Welcome, Admin!</h1>
        <p class="text-center">You are successfully logged in.</p>

        <!-- Admin options -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-dark bg-light">
                    <div class="card-body text-center">
                        <h5 class="card-title">Add Venues</h5>
                        <p class="card-text">Add new venues to the system.</p>
                        <a href="add_venue.php" class="btn btn-primary">Add Venue</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-dark bg-light">
                    <div class="card-body text-center">
                        <h5 class="card-title">Match Officials</h5>
                        <p class="card-text">Manage match officials for upcoming matches.</p>
                        <a href="add_official.php" class="btn btn-primary">Manage Officials</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-dark bg-light">
                    <div class="card-body text-center">
                        <h5 class="card-title">Match Schedule</h5>
                        <p class="card-text">Create and manage the match schedule.</p>
                        <a href="schedule_match.php" class="btn btn-primary">Create Schedule</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-dark bg-light">
                    <div class="card-body text-center">
                        <h5 class="card-title">Arrange Tournament</h5>
                        <p class="card-text">Organize a new tournament.</p>
                        <a href="arrange_tournament.php" class="btn btn-primary">Arrange Tournament</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
    <div class="card text-dark bg-light">
        <div class="card-body text-center">
            <h5 class="card-title">Update Match Result</h5>
            <p class="card-text">Update the results of completed matches.</p>
            <a href="update_match_result.php" class="btn btn-primary">Update</a>
        </div>
    </div>
</div>


        </div>

        <!-- Logout Button -->
        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
