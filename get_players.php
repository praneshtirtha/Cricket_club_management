<?php
// Include the database connection file
include('db_connection.php');

// Check if club_id is passed
if (isset($_GET['club_id'])) {
    $clubId = $_GET['club_id'];

    // Fetch players for the specific club
    $playersQuery = "SELECT Name,Age,PlayingStyle FROM player WHERE ClubID = $clubId ORDER BY Name ASC";
    $playersResult = mysqli_query($conn, $playersQuery);

    if (mysqli_num_rows($playersResult) > 0) {
        echo '<table class="table table-dark table-striped">';
        echo '<thead><tr><th>Name</th><th>Age</th><th>Playing Style</th></tr></thead>';
        echo '<tbody>';
        while ($player = mysqli_fetch_assoc($playersResult)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($player['Name']) . '</td>';
            echo '<td>' . htmlspecialchars($player['Age']) . '</td>';
            echo '<td>' . htmlspecialchars($player['PlayingStyle']) . '</td>';
          
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p class="text-warning">No players found for this club.</p>';
    }
} else {
    echo '<p class="text-danger">Invalid request.</p>';
}
?>
