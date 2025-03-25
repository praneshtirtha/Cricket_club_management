<?php
session_start();
if (!isset($_SESSION['club_registered']) || !isset($_SESSION['committee_registered'])) {
    $_SESSION['error_message'] = "Please register a club and committee first.";
    header("Location: dash.php");
    exit();
}

// Get the Club ID from session
$clubId = $_SESSION['ClubID'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Yellow-green background for the form */
        .form-container {
            background-color: #cceecc; /* Light yellow-green color */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h2 class="text-center mb-4">Player Registration</h2>
                    <div class="alert alert-info">
                        <strong>Registered Players: <span id="playerCount">1</span> / 16</strong>
                    </div>

                    <form method="post" action="save_players.php" id="playerForm">
                        <!-- Pass the dynamic Club ID -->
                        <input type="hidden" name="clubId" value="<?php echo $clubId; ?>">

                        <div id="players">
                            <!-- Default Player Input -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="p-3 border rounded bg-white">
                                        <div class="mb-3">
                                            <label for="playerName1" class="form-label">Player Name</label>
                                            <input type="text" id="playerName1" class="form-control placeholder-clear" name="playerName[]" placeholder="Player Name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="age1" class="form-label">Age</label>
                                            <input type="number" id="age1" class="form-control placeholder-clear" name="age[]" placeholder="Age" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="playingStyle1" class="form-label">Playing Style</label>
                                            <input type="text" id="playingStyle1" class="form-control placeholder-clear" name="playingStyle[]" placeholder="Playing Style" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phoneNumber1" class="form-label">Phone Number</label>
                                            <input type="text" id="phoneNumber1" class="form-control placeholder-clear" name="phoneNumber[]" placeholder="Phone Number" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email1" class="form-label">Email</label>
                                            <input type="email" id="email1" class="form-control placeholder-clear" name="email[]" placeholder="Email" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="button" id="addPlayer" class="btn btn-primary me-2">Add More</button>
                            <button type="submit" class="btn btn-success">Done</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let playerCount = 1; // Initialize player count
        const maxPlayers = 16; // Maximum players allowed

        // Add New Player Fields
        document.getElementById('addPlayer').addEventListener('click', function () {
            const container = document.getElementById('players');
            const playerCountElement = document.getElementById('playerCount');

            if (playerCount < maxPlayers) {
                playerCount++;

                const newPlayerRow = document.createElement('div');
                newPlayerRow.classList.add('row', 'mb-3');

                newPlayerRow.innerHTML = `
                    <div class="col-12">
                        <div class="p-3 border rounded bg-white">
                            <div class="mb-3">
                                <label for="playerName${playerCount}" class="form-label">Player Name</label>
                                <input type="text" id="playerName${playerCount}" class="form-control placeholder-clear" name="playerName[]" placeholder="Player Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="age${playerCount}" class="form-label">Age</label>
                                <input type="number" id="age${playerCount}" class="form-control placeholder-clear" name="age[]" placeholder="Age" required>
                            </div>
                            <div class="mb-3">
                                <label for="playingStyle${playerCount}" class="form-label">Playing Style</label>
                                <input type="text" id="playingStyle${playerCount}" class="form-control placeholder-clear" name="playingStyle[]" placeholder="Playing Style" required>
                            </div>
                            <div class="mb-3">
                                <label for="phoneNumber${playerCount}" class="form-label">Phone Number</label>
                                <input type="text" id="phoneNumber${playerCount}" class="form-control placeholder-clear" name="phoneNumber[]" placeholder="Phone Number" required>
                            </div>
                            <div class="mb-3">
                                <label for="email${playerCount}" class="form-label">Email</label>
                                <input type="email" id="email${playerCount}" class="form-control placeholder-clear" name="email[]" placeholder="Email" required>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(newPlayerRow);

                // Update count display
                playerCountElement.textContent = playerCount;
            } else {
                alert('You can only register up to 16 players.');
            }
        });

        // Clear Placeholder on Focus
        document.addEventListener('focusin', function (event) {
            if (event.target.classList.contains('placeholder-clear')) {
                event.target.dataset.placeholder = event.target.placeholder;
                event.target.placeholder = '';
            }
        });

        document.addEventListener('focusout', function (event) {
            if (event.target.classList.contains('placeholder-clear')) {
                event.target.placeholder = event.target.dataset.placeholder || '';
            }
        });
    </script>
</body>
</html>
