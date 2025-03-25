<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Cricket Club Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212; /* Dark background */
            color: #ffffff; /* Light text */
        }

        .hero-section {
            background: url('about-bg.jpg') no-repeat center center/cover;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        .content-section {
            padding: 40px 20px;
        }

        .content-section h2 {
            color: #007bff; /* Highlighted color for headings */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.html">Cricket Club Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="about.php">About Us</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <h1 class="display-4">About Cricket Club Management</h1>
    </div>

    <!-- Content Section -->
    <div class="container content-section">
        <h2>Our Mission</h2>
        <p>
            The Cricket Club Management System is a web-based platform designed to streamline the operations of cricket clubs. It enables administrators, players, and enthusiasts to manage club activities efficiently, including team management, match scheduling, player statistics, and venue details.
        </p>

        <h2>Key Features</h2>
        <ul>
            <li><strong>User-Friendly Interface:</strong> Easy navigation for both administrators and users.</li>
            <li><strong>Player and Team Management:</strong> Organize player profiles, manage team rosters, and maintain performance records.</li>
            <li><strong>Match Scheduling:</strong> Plan and track upcoming matches with venue details.</li>
            <li><strong>Statistics and Analysis:</strong> Gain insights into team and player performance using detailed statistics.</li>
            <li><strong>Accessibility:</strong> Secure login and signup features for user-specific access.</li>
        </ul>

        <h2>Our Goal</h2>
        <p>
            The system aims to modernize traditional cricket club operations, making management more efficient and engaging for everyone involved. By leveraging technology, we strive to enhance the experience of both players and cricket enthusiasts.
        </p>
    </div>

    <!-- Footer -->
    <footer class="text-center py-3 bg-dark">
        <p>&copy; 2024 Cricket Club Management. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
