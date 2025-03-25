<?php
// Start session
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to the home page if not logged in
    header("Location: index.php");
    exit();
}

// Include the database connection
include('db_connection.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tournamentName = $_POST['TournamentName'];
    $startDate = $_POST['StartDate'];
    $endDate = $_POST['EndDate'];
    $organizedBy = $_POST['OrganizedBy'];

    // Insert tournament into the database
    $insertQuery = "INSERT INTO tournament (TournamentName, StartDate, EndDate, OrganizedBy) 
                    VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssss", $tournamentName, $startDate, $endDate, $organizedBy);

    if ($stmt->execute()) {
        $successMessage = "Tournament added successfully!";
    } else {
        $errorMessage = "Error adding tournament: " . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arrange Tournament</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <h1 class="text-center">Arrange a Tournament</h1>

        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success text-center" role="alert">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <!-- Tournament Form -->
        <form action="arrange_tournament.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="TournamentName" class="form-label">Tournament Name</label>
                <input type="text" class="form-control" id="TournamentName" name="TournamentName" required>
            </div>
            <div class="mb-3">
                <label for="StartDate" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="StartDate" name="StartDate" required>
            </div>
            <div class="mb-3">
                <label for="EndDate" class="form-label">End Date</label>
                <input type="date" class="form-control" id="EndDate" name="EndDate" required>
            </div>
            <div class="mb-3">
                <label for="OrganizedBy" class="form-label">Organized By</label>
                <input type="text" class="form-control" id="OrganizedBy" name="OrganizedBy" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Add Tournament</button>
            </div>
        </form>

        <!-- Back Button -->
        <div class="text-center mt-4">
            <a href="welcome.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
