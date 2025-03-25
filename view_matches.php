<?php
// Include the database connection file
include('db_connection.php');

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
  <title>Upcoming Matches</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #121212;
      color: #ffffff;
      padding-left: 10px;
      padding-right: 10px;
    }
    .match-box {
      background-color: #1e1e1e;
      border: none;
      margin-bottom: 20px;
      padding: 20px;
      position: relative;
      display: flex;
      flex-direction: column; /* Stack items vertically */
      justify-content: center;
      align-items: center;
      width: 100%; /* Full width */
      border-radius: 8px;
    }
    .match-box .badge {
      background-color: #17a2b8;
      color: #fff;
      font-size: 1rem;
      padding: 5px 15px;
      border-radius: 12px;
      position: absolute;
      top: 10px;
      left: 10px;
    }
    .match-box .match-time {
      font-size: 1.5rem;
      font-weight: bold;
      text-align: center;
      margin-bottom: 5px; /* Reduced margin to make it closer to VS */
    }
    .match-box .vs {
      font-size: 2rem;
      font-weight: bold;
      text-align: center;
      margin-bottom: 10px;
    }
    .match-box .team-names {
      width: 100%;
      display: flex;
      justify-content: space-between; /* Space between teams */
      padding: 0 200px;
      font-size: 1.2rem;
      font-weight: bold;
      margin-bottom: 20px; /* Add spacing between teams and venue */
    }
    .match-box .match-info {
      text-align: center;
      margin-top: 15px;
    }
    .match-box .date {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 1rem;
      font-weight: bold;
    }
    .match-details p {
      margin: 5px 0;
      font-size: 1rem;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Upcoming Matches</h1>

    <div class="row justify-content-center">
      <?php foreach ($matches as $match): ?>
      <div class="col-12">
        <div class="match-box text-white">
          <span class="badge">Match No: <?php echo htmlspecialchars($match['MatchNo']); ?></span>
          
          <!-- Date (Top Right Corner) -->
          <div class="date">
            <?php echo htmlspecialchars($match['Date']); ?>
          </div>
          
          <!-- Time (Top Center) -->
          <div class="match-time">
            <?php echo htmlspecialchars($match['Time']); ?>
          </div>
          
          <!-- VS (Between Time and Teams) -->
          <div class="vs">VS</div>
          
          <!-- Teams (Left: Home, Right: Away) -->
          <div class="team-names">
            <span><?php echo htmlspecialchars($match['HomeTeam']); ?></span>
            <span><?php echo htmlspecialchars($match['AwayTeam']); ?></span>
          </div>

          <!-- Venue (Below VS) -->
          <div class="match-info">
            <p><strong>Venue:</strong> <?php echo htmlspecialchars($match['Venue']); ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
