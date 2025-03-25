<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include('db_connection.php');

// Fetch venues from the table 'venue'
$venuesQuery = "SELECT * FROM venue";
$venuesResult = mysqli_query($conn, $venuesQuery);

// Check for query success
if (!$venuesResult) {
    die('Query Failed: ' . mysqli_error($conn));
}

// Display venues as cards if they exist
if (mysqli_num_rows($venuesResult) > 0) {
    echo '<div class="container py-5">';
    echo '<div class="row g-3">'; // Bootstrap row with spacing between cards

    while ($venue = mysqli_fetch_assoc($venuesResult)) {
        echo '<div class="col-md-4">'; // Bootstrap column for responsive grid
        echo '<div class="card bg-dark text-white h-100">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">Venue ID: ' . htmlspecialchars($venue['VenueID']) . '</h5>';
        echo '<h4 class="card-title">' . htmlspecialchars($venue['VenueName']) . '</h4>';
        echo '<p class="card-text">Location: ' . htmlspecialchars($venue['Location']) . '</p>';
        echo '<p class="card-text">Capacity: ' . htmlspecialchars($venue['Capacity']) . '</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    echo '</div>'; // End of row
    echo '</div>'; // End of container
} else {
    echo '<p class="text-warning">No venues found in the database.</p>';
}

// Close database connection
mysqli_close($conn);
?>
