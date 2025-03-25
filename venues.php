<?php
// Include the database connection file
include('db_connection.php');

// Fetch all venues
$venuesQuery = "SELECT * FROM venue";  // Adjust this query to fit your database structure
$venuesResult = mysqli_query($conn, $venuesQuery);

// Check if the query was successful
if (!$venuesResult) {
    die('Query Failed: ' . mysqli_error($conn));
}

// Fetch the venues as an associative array
$venues = mysqli_fetch_all($venuesResult, MYSQLI_ASSOC);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Venues</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body {
  background-color: #121212;
  color: #ffffff; /* Default text color for the page */
}

.card {
  background-color: #1e1e1e;
  border: none;
  margin-bottom: 20px;
  padding: 20px;
  position: relative;
  min-height: 200px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  color: #fff !important; /* Force text color to white inside card */
}

.card .card-title {
  color: #ffffff !important; /* Ensure title text is white */
}

.card .card-text {
  color: #ccc !important; /* Light gray color for other text */
}

.card .card-body {
  color: #ffffff !important; /* Ensure all text in card body is white */
}

.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.badge-venue-id {
  position: absolute;
  top: 10px;
  left: 10px;
  background-color: #28a745;
  color: #fff;
  font-size: 1rem;
  padding: 5px 15px;
  border-radius: 12px;
  z-index: 2;
}

.card-title {
  margin-top: 40px; /* Space for the ID badge */
  font-size: 1.5rem;
}

  </style>
</head>
<body>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Venues</h1>

    <!-- Venues List -->
    <div class="row">
      <?php if ($venues): ?>
        <?php foreach ($venues as $venue): ?>
          <div class="col-md-6 col-lg-4">
            <div class="card text-white">
              <span class="badge-venue-id">ID: <?php echo htmlspecialchars($venue['VenueID']); ?></span>
              <div class="card-body">
                <h5 class="card-title text-center"><?php echo htmlspecialchars($venue['VenueName']); ?></h5>
                <p class="card-text">Location: <?php echo htmlspecialchars($venue['Location']); ?></p>
                <p class="card-text">Capacity: <?php echo htmlspecialchars($venue['Capacity']); ?></p>
                <div class="d-flex justify-content-center">
                  
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No venues found.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
