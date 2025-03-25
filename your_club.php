<?php
session_start();
require 'db_connection.php'; // Ensure $conn is defined in db_connection.php

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Get the UserID from the session
$user_id = $_SESSION['UserID']; 

// Query to fetch club details using the UserID
$clubQuery = "SELECT ClubID, ClubName, Location FROM club WHERE UserID = ?";
$stmt = $conn->prepare($clubQuery); // Using MySQLi with $conn
$stmt->bind_param("i", $user_id); // Bind the UserID to the query
$stmt->execute();
$result = $stmt->get_result();

// Check if the result is valid
if ($result->num_rows > 0) {
    $club = $result->fetch_assoc();
    $clubID = $club['ClubID']; // Use ClubID for further queries
    $clubName = $club['ClubName'];
    $clubLocation = $club['Location'];
} else {
    echo "No club found for this user.";
    exit();
}

// Handle Add Player
if (isset($_POST['add_player'])) {
    $playerName = $_POST['player_name'];
    $playerAge = $_POST['age'];
    $playingStyle = $_POST['playing_style'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];

    // Insert new player
    $addPlayerQuery = "INSERT INTO player (Name, Age, PlayingStyle, Email, PhoneNumber, ClubID) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($addPlayerQuery);
    
    if (!$stmt) {
        echo "Error in prepare statement: " . $conn->error;
        exit();
    }

    $stmt->bind_param("sisssi", $playerName, $playerAge, $playingStyle, $email, $phoneNumber, $clubID);

    if ($stmt->execute()) {
        echo "Player added successfully.";
    } else {
        echo "Error executing query: " . $stmt->error;
    }
}

// Handle Add Committee Member
if (isset($_POST['add_committee'])) {
    // Get form data
    $memberName = $_POST['member_name'];
    $role = $_POST['role'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $phoneNumber = $_POST['phone_number'];
    $email = $_POST['email'];
    $clubID = $_POST['club_id'];

    // Prepare the SQL query
    $addCommitteeMemberQuery = "INSERT INTO managementcommittee (MemberName, Role, StartDate, EndDate, PhoneNumber, Email, ClubID) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($addCommitteeMemberQuery);

    if (!$stmt) {
        echo "Error in prepare statement: " . $conn->error;
        exit();
    }

    // Bind parameters to the prepared statement
    $stmt->bind_param("ssssssi", $memberName, $role, $startDate, $endDate, $phoneNumber, $email, $clubID);

    // Execute the query
    if ($stmt->execute()) {
        echo "Committee member added successfully.";
    } else {
        echo "Error executing query: " . $stmt->error;
    }
}

// Handle Edit Player
if (isset($_POST['edit_player'])) {
    $playerID = $_POST['player_id'];
    $playerName = $_POST['player_name'];
    $playingStyle = $_POST['playing_style'];

    // Update the player's details
    $editPlayerQuery = "UPDATE player SET Name = ?, PlayingStyle = ? WHERE PlayerID = ?";
    $stmt = $conn->prepare($editPlayerQuery);
    $stmt->bind_param("ssi", $playerName, $playingStyle, $playerID);
    $stmt->execute();
    echo "Player updated successfully.";
}

// Handle Edit Committee Member
if (isset($_POST['edit_committee'])) {
    $committeeID = $_POST['committee_id'];
    $committeeRole = $_POST['role'];
    $committeeMemberName = $_POST['member_name'];

    // Update the committee member's details
    $editCommitteeQuery = "UPDATE managementcommittee SET Role = ?, MemberName = ? WHERE CommitteeID = ?";
    $stmt = $conn->prepare($editCommitteeQuery);
    $stmt->bind_param("ssi", $committeeRole, $committeeMemberName, $committeeID);
    $stmt->execute();
    echo "Committee member updated successfully.";
}

// Fetching players for the club
$playerQuery = "SELECT PlayerID, Name, PlayingStyle FROM player WHERE ClubID = ?";
$stmt = $conn->prepare($playerQuery); // Using MySQLi with $conn
$stmt->bind_param("i", $clubID); // Bind the ClubID
$stmt->execute();
$playersResult = $stmt->get_result();

// Fetching management committee for the club
$committeeQuery = "SELECT CommitteeID, Role, MemberName FROM managementcommittee WHERE ClubID = ?";
$stmt = $conn->prepare($committeeQuery); // Using MySQLi with $conn
$stmt->bind_param("i", $clubID); // Bind the ClubID
$stmt->execute();
$committeeResult = $stmt->get_result();

// Check if a delete action was requested
if (isset($_GET['delete_player'])) {
    $playerID = $_GET['delete_player'];
    // Delete the player from the database
    $deletePlayerQuery = "DELETE FROM player WHERE PlayerID = ?";
    $stmt = $conn->prepare($deletePlayerQuery);
    $stmt->bind_param("i", $playerID);
    $stmt->execute();
    header("Location: your_club.php");
    exit();
}

if (isset($_GET['delete_committee'])) {
    $committeeID = $_GET['delete_committee'];
    // Delete the committee member from the database
    $deleteCommitteeQuery = "DELETE FROM managementcommittee WHERE CommitteeID = ?";
    $stmt = $conn->prepare($deleteCommitteeQuery);
    $stmt->bind_param("i", $committeeID);
    $stmt->execute();
    header("Location: your_club.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Club</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin-top: 20px;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        h2 {
            color: #343a40;
            text-align: center;
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .club-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .club-name {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .club-location {
            color: #6c757d;
            font-size: 1.1rem;
        }
        .players-list, .committee-list {
            margin-bottom: 30px;
        }
        .list-group-item {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .list-group-item:hover {
            background-color: #f1f1f1;
        }
        .btn-back {
            display: block;
            width: 100%;
            text-align: center;
            padding: 12px;
            background-color: #28a745;
            color: white;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn-back:hover {
            background-color: #218838;
        }
        .action-buttons {
            display: flex;
            gap: 10px; /* Creates space between the buttons */
        }
    </style>
</head>
<body>

<div class="container">
    
    <div class="club-info">
        <div class="club-name"><?php echo htmlspecialchars($clubName); ?></div>
        <div class="club-location"><?php echo htmlspecialchars($clubLocation); ?></div>
    </div>

    <div class="players-list">
        <h3>Players</h3>
        <?php if ($playersResult->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($player = $playersResult->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <div>
                            <strong><?php echo htmlspecialchars($player['Name']); ?></strong><br>
                            <span>Playing Style: <?php echo htmlspecialchars($player['PlayingStyle']); ?></span>
                        </div>
                        <!-- Action Buttons (Edit and Delete) -->
                        <div class="action-buttons">
                            <!-- Edit Button -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPlayerModal<?php echo $player['PlayerID']; ?>">Edit</button>

                            <!-- Delete Button -->
                            <a href="your_club.php?delete_player=<?php echo $player['PlayerID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this player?')">Delete</a>
                        </div>

                        <!-- Modal for Editing Player -->
                        <div class="modal fade" id="editPlayerModal<?php echo $player['PlayerID']; ?>" tabindex="-1" aria-labelledby="editPlayerModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editPlayerModalLabel">Edit Player</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="player_id" value="<?php echo $player['PlayerID']; ?>">
                                            <div class="mb-3">
                                                <label for="player_name" class="form-label">Player Name</label>
                                                <input type="text" class="form-control" name="player_name" value="<?php echo htmlspecialchars($player['Name']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="playing_style" class="form-label">Playing Style</label>
                                                <input type="text" class="form-control" name="playing_style" value="<?php echo htmlspecialchars($player['PlayingStyle']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="edit_player">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No players found for this club.</p>
        <?php endif; ?>
        <!-- Add Player Button -->
        <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#addPlayerModal">Add Player</button>
    </div>

    <!-- Modal for Adding Player -->
    <div class="modal fade" id="addPlayerModal" tabindex="-1" aria-labelledby="addPlayerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPlayerModalLabel">Add New Player</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="player_name" class="form-label">Player Name</label>
                            <input type="text" class="form-control" name="player_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" name="age" required>
                        </div>
                        <div class="mb-3">
                            <label for="playing_style" class="form-label">Playing Style</label>
                            <input type="text" class="form-control" name="playing_style" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" name="phone_number" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="add_player">Save Player</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Committee List -->
    <div class="committee-list">
        <h3>Committee Members</h3>
        <?php if ($committeeResult->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($committee = $committeeResult->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <div>
                            <strong><?php echo htmlspecialchars($committee['MemberName']); ?></strong><br>
                            <span>Role: <?php echo htmlspecialchars($committee['Role']); ?></span>
                        </div>
                        <!-- Action Buttons (Edit and Delete) -->
                        <div class="action-buttons">
                            <!-- Edit Button -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCommitteeModal<?php echo $committee['CommitteeID']; ?>">Edit</button>

                            <!-- Delete Button -->
                            <a href="your_club.php?delete_committee=<?php echo $committee['CommitteeID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this committee member?')">Delete</a>
                        </div>

                        <!-- Modal for Editing Committee Member -->
                        <div class="modal fade" id="editCommitteeModal<?php echo $committee['CommitteeID']; ?>" tabindex="-1" aria-labelledby="editCommitteeModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editCommitteeModalLabel">Edit Committee Member</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="committee_id" value="<?php echo $committee['CommitteeID']; ?>">
                                            <div class="mb-3">
                                                <label for="member_name" class="form-label">Member Name</label>
                                                <input type="text" class="form-control" name="member_name" value="<?php echo htmlspecialchars($committee['MemberName']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="role" class="form-label">Role</label>
                                                <input type="text" class="form-control" name="role" value="<?php echo htmlspecialchars($committee['Role']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="edit_committee">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No committee members found for this club.</p>
        <?php endif; ?>
        <!-- Add Committee Member Button -->
        <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#addCommitteeModal">Add Committee Member</button>
    </div>

</div>

<!-- Modal for Adding Committee Member -->
<div class="modal fade" id="addCommitteeModal" tabindex="-1" aria-labelledby="addCommitteeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCommitteeModalLabel">Add Committee Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="member_name" class="form-label">Member Name</label>
                        <input type="text" class="form-control" name="member_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" name="role" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" name="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" name="phone_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <input type="hidden" name="club_id" value="<?php echo $clubID; ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="add_committee">Save Committee Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<a href="dashboard.php" class="btn-back">Back to Dashboard</a>

<!-- Include Bootstrap JS for modal functionality -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
