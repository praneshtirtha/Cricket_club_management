<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cricketclubmanagement_updated";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all clubs
$clubsQuery = "SELECT * FROM club";
$clubsResult = $conn->query($clubsQuery);
$clubs = $clubsResult->fetch_all(MYSQLI_ASSOC);

// Fetch players and committee for each club
$clubsData = [];
foreach ($clubs as $club) {
    $clubId = $club['ClubID'];

    // Fetch players for the club
    $playersQuery = "SELECT * FROM player WHERE ClubID = $clubId";
    $playersResult = $conn->query($playersQuery);
    $players = $playersResult->fetch_all(MYSQLI_ASSOC);

    // Fetch committee members for the club
    $committeeQuery = "SELECT * FROM committee WHERE ClubID = $clubId";
    $committeeResult = $conn->query($committeeQuery);
    $committee = $committeeResult->fetch_all(MYSQLI_ASSOC);

    $clubsData[] = [
        'club' => $club,
        'players' => $players,
        'committee' => $committee,
    ];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Teams</h2>

    <?php foreach ($clubsData as $clubData): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h3><?php echo htmlspecialchars($clubData['club']['ClubName']); ?> (ID: <?php echo $clubData['club']['ClubID']; ?>)</h3>
            </div>
            <div class="card-body">
                <!-- Players Table -->
                <h4>Players</h4>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Player Name</th>
                        <th>Age</th>
                        <th>Playing Style</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($clubData['players'])): ?>
                        <?php foreach ($clubData['players'] as $player): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($player['Name']); ?></td>
                                <td><?php echo htmlspecialchars($player['Age']); ?></td>
                                <td><?php echo htmlspecialchars($player['PlayingStyle']); ?></td>
                                <td><?php echo htmlspecialchars($player['Email']); ?></td>
                                <td><?php echo htmlspecialchars($player['PhoneNumber']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No players registered yet.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>

                <!-- Committee Table -->
                <h4>Management Committee</h4>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Committee ID</th>
                        <th>Member Name</th>
                        <th>Role</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($clubData['committee'])): ?>
                        <?php foreach ($clubData['committee'] as $member): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($member['CommitteeID']); ?></td>
                                <td><?php echo htmlspecialchars($member['MemberName']); ?></td>
                                <td><?php echo htmlspecialchars($member['Role']); ?></td>
                                <td><?php echo htmlspecialchars($member['StartDate']); ?></td>
                                <td><?php echo htmlspecialchars($member['EndDate']); ?></td>
                                <td><?php echo htmlspecialchars($member['PhoneNumber']); ?></td>
                                <td><?php echo htmlspecialchars($member['Email']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No committee members registered yet.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
