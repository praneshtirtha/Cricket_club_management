<?php
// Include the database connection file
include('db_connection.php');

// Fetch all clubs
$clubsQuery = "SELECT * FROM club";
$clubsResult = mysqli_query($conn, $clubsQuery);
$clubs = mysqli_fetch_all($clubsResult, MYSQLI_ASSOC);

// Fetch all scheduled matches
$matchesQuery = "SELECT 
                    matches.MatchNo,
                    home.ClubName AS HomeTeam,
                    away.ClubName AS AwayTeam,
                    matches.Date,
                    matches.Time,
                    venue.VenueName AS Venue
                 FROM 
                    matches
                 JOIN 
                    club AS home ON matches.HomeTeam = home.ClubID
                 JOIN 
                    club AS away ON matches.AwayTeam = away.ClubID
                 JOIN 
                    venue ON matches.VenueID = venue.VenueID";
$matchesResult = mysqli_query($conn, $matchesQuery);
$matches = mysqli_fetch_all($matchesResult, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cricket Club Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #121212;
      color: #ffffff;
    }
    .card {
      background-color: #1e1e1e;
      border: none;
      margin-bottom: 20px;
      padding: 20px;
      min-height: 200px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }
    .btn-primary:hover {
      background-color: #0056b3;
    }
    .badge-club-id {
      background-color: #28a745; /* Green background for the ID badge */
      color: #fff;
      font-size: 1rem;
      padding: 5px 10px;
      border-radius: 20px;
      position: absolute;
      top: 10px;
      left: 10px;
    }

    .card-text {
      font-size: 1.2rem; /* Increased size for location */
      text-align: center;
    }
    .card-title {
      font-size: 1.8rem;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Cricket Club Management</h1>

    <!-- Clubs Section -->
    <h2 class="text-center mb-4">Clubs</h2>
    <div class="row">
      <?php foreach ($clubs as $club): ?>
      <div class="col-md-6 col-lg-4 position-relative">
        <div class="card text-white">
          <span class="badge-club-id">ID: <?php echo htmlspecialchars($club['ClubID']); ?></span>
          <div class="card-body">
            <h5 class="card-title text-center"><?php echo htmlspecialchars($club['ClubName']); ?></h5>
            <p class="card-text">Location: <?php echo htmlspecialchars($club['Location']); ?></p>
            <div class="d-flex justify-content-center">
              <button class="btn btn-primary" 
                      data-bs-toggle="modal" 
                      data-bs-target="#playersModal" 
                      onclick="loadPlayers(<?php echo $club['ClubID']; ?>)">
                View Players
              </button>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Matches Section -->
   

  <!-- Modal for displaying players -->
  <div class="modal fade" id="playersModal" tabindex="-1" aria-labelledby="playersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content bg-dark text-light">
        <div class="modal-header">
          <h5 class="modal-title" id="playersModalLabel">Players</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modalContent">
          <p>Loading players...</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function loadPlayers(clubId) {
      fetch(`get_players.php?club_id=${clubId}`)
        .then(response => response.text())
        .then(data => {
          document.getElementById('modalContent').innerHTML = data;
        })
        .catch(error => {
          document.getElementById('modalContent').innerHTML = `<p class="text-danger">Error loading players.</p>`;
        });
    }
  </script>
</body>
</html>
