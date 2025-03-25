<?php
// Include database connection
include 'db_connection.php';

// Query to fetch match results with club names
$query = "
    SELECT 
        m.MatchNo,
        c1.ClubName AS HomeTeamName,
        c2.ClubName AS AwayTeamName,
        mr.HomeTeamScore,
        mr.AwayTeamScore,
        mr.MatchOutcome,
        mr.POM
    FROM matches m
    JOIN club c1 ON m.HomeTeam = c1.ClubID
    JOIN club c2 ON m.AwayTeam = c2.ClubID
    JOIN matchresult mr ON m.MatchNo = mr.MatchNo
    ORDER BY m.MatchNo ASC
";

$result = $conn->query($query);

// Check if there was an error executing the query
if ($result === false) {
    die('Error executing query: ' . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Match Results</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Match No</th>
                    <th>Home Team</th>
                    <th>Away Team</th>
                    <th>Home Team Score</th>
                    <th>Away Team Score</th>
                    <th>Match Outcome</th>
                    <th>Player of the Match</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['MatchNo']; ?></td>
                        <td><?php echo $row['HomeTeamName']; ?></td>
                        <td><?php echo $row['AwayTeamName']; ?></td>
                        <td><?php echo $row['HomeTeamScore']; ?></td>
                        <td><?php echo $row['AwayTeamScore']; ?></td>
                        <td><?php echo $row['MatchOutcome']; ?></td>
                        <td><?php echo $row['POM']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No match results found.</p>
    <?php endif; ?>

    <?php
    // Close database connection
    $conn->close();
    ?>
</body>
</html>
