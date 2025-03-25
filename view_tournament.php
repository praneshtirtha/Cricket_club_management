<?php
// Include the database connection file
require_once 'db_connection.php'; // Adjust this to match your connection file's name

// Fetch tournaments from the database
$query = "SELECT * FROM tournament"; // Replace `tournaments` with your actual table name
$result = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Tournaments</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">Cricket Club Management</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container my-5">
    <h1 class="text-center mb-4">All Tournaments</h1>
    <div class="row">
      <?php
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<div class="col-md-4 mb-4">';
          echo '<div class="card bg-dark text-light">';
          echo '<div class="card-body">';
          echo '<h5 class="card-title">' . htmlspecialchars($row['TournamentName']) . '</h5>';
          echo '<p class="card-text">Start Date: ' . htmlspecialchars($row['StartDate']) . '</p>';
          echo '<p class="card-text">End Date: ' . htmlspecialchars($row['EndDate']) . '</p>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
      } else {
        echo '<p class="text-center text-light">No tournaments found.</p>';
      }
      ?>
    </div>
  </div>

  <!-- Footer -->
  <footer class="text-center py-3 bg-dark text-light">
    <p>&copy; 2024 Cricket Club Management. All Rights Reserved.</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
