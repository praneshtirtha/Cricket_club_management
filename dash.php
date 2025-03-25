<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Replace with your authentication logic
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Example of setting session on successful login
    $_SESSION['user_id'] = $user['id']; // Replace with actual user ID
    $_SESSION['username'] = $user['username']; // Replace with actual username

    // Redirect to dashboard
    header("Location: dash.php");
    exit;
}
?>

<!-- Now you can use the $clubId variable in the rest of your HTML and forms -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Add your CSS and other necessary files here -->
</head>
<body>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    /* Sidebar Styles */
    .sidebar {
      height: 100vh;
      background-color: #28a745;
      color: #ffffff;
      position: fixed;
      left: 0;
      top: 0;
      width: 250px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    .sidebar a {
      color: #ffffff;
      text-decoration: none;
      display: block;
      padding: 10px 20px;
      margin: 5px 0;
      text-align: center;
      width: 100%;
      cursor: pointer;
    }
    .sidebar a:hover {
      background-color: #218838;
      border-radius: 5px;
      text-decoration: none;
    }
    .sidebar a.logout {
      background-color: #dc3545;
    }
    .sidebar a.logout:hover {
      background-color: #c82333;
    }

    /* Active Sidebar Link */
.sidebar a.active {
  background-color: #0056b3; /* Highlight color */
  color: #ffffff; /* Text color */
  border-radius: 5px;
}


    /* Dark Mode Switch */
    .dark-mode-switch {
      margin-top: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .dark-mode-switch label {
      color: #ffffff;
    }

    /* Content Container */
    .content-container {
      margin-left: 250px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: calc(100% - 250px);
      height: 100vh;
      text-align: center;
    }

    .dashboard-title {
      background-color: #007bff;
      color: #ffffff;
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 20px;
      font-size: 2rem;
    }

    .dashboard-subtitle {
      font-size: 1.2rem;
      margin-top: 10px;
      color: #ffffff;
    }

    .section {
      display: none; /* Hide all sections initially */
      width: 50%;
      margin: 0 auto;
    }

    .section.active {
      display: block; /* Show only the active section */
    }


    /* Card container (ensures all cards are contained properly) */
.card-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px; /* Adds space between cards */
  justify-content: flex-start;
  padding-top: 20px; /* Ensure the cards don't get cut off at the top */
  padding: 20px; /* Padding to ensure content is not touching the edges */
  box-sizing: border-box;
  overflow: auto; /* Allows for scrolling if necessary */
  margin-top: 0; /* Remove margin-top if there is any */
  max-height: 100vh; /* Makes sure the container doesn’t overflow the screen */
}

/* Card styling */
.card {
  height: auto; /* Let the height adjust based on content */
  min-width: 250px; /* Minimum width for each card */
  max-width: 300px; /* Max width for each card */
  display: flex;
  flex-direction: column; /* Align items vertically */
  justify-content: flex-start;
  text-align: center;
  margin-bottom: 20px; /* Space between cards when stacked vertically */
  border-radius: 8px;
  background-color: #fff;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  overflow: hidden; /* Prevent content from overflowing */
}

/* Image styling */
.card img {
  width: 100%; /* Full width for the image */
  height: 150px; /* Set a fixed height for image to fit nicely */
  object-fit: cover; /* Crop image to fit within the container */
}

/* Card body styling */
.card-body {
  padding: 10px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  text-align: left;
  overflow: hidden; /* Prevent text overflow */
}

/* Headings inside card */
.card-title {
  font-size: 1.2em;
  font-weight: bold;
  margin-bottom: 10px;
}

/* Responsive Design for smaller screens */
@media (max-width: 768px) {
  .card-container {
    flex-direction: column; /* Stack cards vertically on smaller screens */
    gap: 15px; /* Adjust gap between cards */
  }

  .card {
    width: 100%; /* Ensure cards take full width on mobile */
    height: auto; /* Auto height based on content */
  }
}


    /* Dark Mode Styles */
    body.dark-mode {
      background-color: #121212;
      color: #ffffff;
    }
    .sidebar.dark-mode {
      background-color: #1e1e1e;
      color: #ffffff;
    }
    .sidebar.dark-mode a {
      color: #bbbbbb;
    }
    .sidebar.dark-mode a:hover {
      background-color: #333333;
    }
    .dashboard-title {
      color: #ffffff;
    }
    form label {
      color: inherit;
    }
  </style>
</head>
<body>
  <div class="sidebar">
   
    <a onclick="showSection('club-registration')">Register Club</a>
    <a onclick="showSection('player-registration')">Register Players</a>
    <li class="list-group-item"><a href="your_club.php">Your Club</a></li>
    <a href="venues.php">Venues</a>

   


    <a href="logout.php" class="logout">Logout</a>

    <!-- Dark Mode Switch -->
    <div class="dark-mode-switch">
      <label for="darkModeToggle">Dark Mode</label>
      <input type="checkbox" id="darkModeToggle">
    </div>
  </div>

  <div class="content-container">

  <?php if (isset($_SESSION['success_message'])): ?>
  <div id="successMessage" class="alert alert-success">
    <?php 
      echo $_SESSION['success_message']; 
      unset($_SESSION['success_message']); // Clear the message
    ?>
  </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
  <div id="errorMessage" class="alert alert-danger">
    <?php 
      echo $_SESSION['error_message']; 
      unset($_SESSION['error_message']); // Clear the message
    ?>
  </div>
<?php endif; ?>


    <div class="dashboard-title">
      Welcome to Cricket Club Management
      <p class="dashboard-subtitle">Welcome to your personalized Cricket Club Management</p>
    </div>

    <!-- Sections -->
    <div id="club-registration" class="section">
      <h2>Register Club</h2>
      <form action="register_club.php" method="post">

  <button type="submit" class="btn btn-primary">Register Club</button>
</form>

    </div>

    <!-- Player Registration Form -->
    <div id="player-registration" class="section">
        <h2>Register Player</h2>
        <form method="POST" action="register_players.php">
            <!-- Pass ClubID to the registration page -->
            <input type="hidden" name="ClubID" value="<?php echo $clubId; ?>">
            
            
            <button type="submit" class="btn btn-primary">Register Player</button>
        </form>
    </div>

</body>
</html>
</form>
    </div>
  </div>

  <div id="venues" class="section">
  <h2>Manage Venues</h2>
  <p>Enter the venue details and upload an image for each venue.</p>


  <div id="tournament-registration" class="section">
    <h2>Register for a Tournament</h2>
    <?php if (!empty($tournaments)): ?>
        <div class="row">
            <?php foreach ($tournaments as $tournament): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($tournament['name']); ?></h5>
                            <p class="card-text"><strong>Start Date:</strong> <?php echo htmlspecialchars($tournament['start_date']); ?></p>
                            <p class="card-text"><strong>End Date:</strong> <?php echo htmlspecialchars($tournament['end_date']); ?></p>
                            <p class="card-text"><?php echo htmlspecialchars($tournament['description']); ?></p>
                            <form action="register_tournament.php" method="POST">
                                <input type="hidden" name="tournament_id" value="<?php echo $tournament['id']; ?>">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No tournaments available for registration at the moment.</p>
    <?php endif; ?>
</div>


  
  <!-- Display Added Venues -->
  <div id="venuesList" class="mt-4">
    <h3>Available Venues</h3>
    <div class="row">
      <!-- Venue 1 -->
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="C:\Users\Asus\Downloads\download (1).jpg" class="card-img-top" alt="Sher-e-Bangla National Cricket Stadium">
          <div class="card-body">
            <h5 class="card-title">Sher-e-Bangla National Cricket Stadium</h5>
            <p class="card-text">Location: Mirpur, Dhaka</p>
            <p><strong>Capacity:</strong> 25,000</p>
          </div>
        </div>
      </div>

      <!-- Venue 2 -->
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="path_to_venue_image.jpg" class="card-img-top" alt="Zahur Ahmed Chowdhury Stadium">
          <div class="card-body">
            <h5 class="card-title">Zahur Ahmed Chowdhury Stadium</h5>
            <p class="card-text">Location: Chattogram</p>
            <p><strong>Capacity:</strong> 20,000</p>
          </div>
        </div>
      </div>

      <!-- Venue 3 -->
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="path_to_venue_image.jpg" class="card-img-top" alt="Sylhet International Cricket Stadium">
          <div class="card-body">
            <h5 class="card-title">Sylhet International Cricket Stadium</h5>
            <p class="card-text">Location: Sylhet</p>
            <p><strong>Capacity:</strong> 18,500</p>
          </div>
        </div>
      </div>

      <!-- Venue 4 -->
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="path_to_venue_image.jpg" class="card-img-top" alt="Khan Shaheb Osman Ali Stadium">
          <div class="card-body">
            <h5 class="card-title">Khan Shaheb Osman Ali Stadium</h5>
            <p class="card-text">Location: Fatullah, Narayanganj</p>
            <p><strong>Capacity:</strong> 25,000</p>
          </div>
        </div>
      </div>


      <!-- Venue 5-->
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="path_to_venue_image.jpg" class="card-img-top" alt="Shaheed Chandu Stadium">
          <div class="card-body">
            <h5 class="card-title">Shaheed Chandu Stadium</h5>
            <p class="card-text">Location: Bogura</p>
            <p><strong>Capacity:</strong> 15,000</p>
          </div>
        </div>
      </div>

      <!-- Venue 6-->
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="path_to_venue_image.jpg" class="card-img-top" alt="Sheikh Abu Naser Stadium">
          <div class="card-body">
            <h5 class="card-title">Sheikh Abu Naser Stadium</h5>
            <p class="card-text">Location: Khulna</p>
            <p><strong>Capacity:</strong> 15,000</p>
          </div>
        </div>
      </div>

      <!-- Venue 7-->
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="path_to_venue_image.jpg" class="card-img-top" alt="M. A. Aziz Stadium">
          <div class="card-body">
            <h5 class="card-title">M. A. Aziz Stadium</h5>
            <p class="card-text">Location: Chattogram</p>
            <p><strong>Capacity:</strong> 20,000</p>
          </div>
        </div>
      </div>

      <!-- Venue 8-->
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="path_to_venue_image.jpg" class="card-img-top" alt="Shaheed A. H. M. Kamruzzaman Stadium">
          <div class="card-body">
            <h5 class="card-title">Shaheed A. H. M. Kamruzzaman Stadium</h5>
            <p class="card-text">Location: Rajshahi</p>
            <p><strong>Capacity:</strong> 20,000</p>
          </div>
        </div>
      </div>

      <!-- Venue 9-->
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="path_to_venue_image.jpg" class="card-img-top" alt="Barisal Divisional Stadium">
          <div class="card-body">
            <h5 class="card-title">Barisal Divisional Stadium</h5>
            <p class="card-text">Location: Barisal</p>
            <p><strong>Capacity:</strong> 15,000</p>
          </div>
        </div>
      </div>


      <!-- Venue 10-->
      <div class="col-md-4">
        <div class="card mb-4">
          <img src="path_to_venue_image.jpg" class="card-img-top" alt="Bir Shreshtha Shahid Flight Lieutenant Matiur Rahman Stadium">
          <div class="card-body">
            <h5 class="card-title">Bir Shreshtha Shahid Flight Lieutenant Matiur Rahman Stadium</h5>
            <p class="card-text">Location: Khulna</p>
            <p><strong>Capacity:</strong> 25,000</p>
          </div>
        </div>
      </div>



      <!-- Add more venues following the same pattern -->

    </div>
  </div>
</div>



  <script>
    // Function to show a section and hide others
    function showSection(sectionId) {
      const sections = document.querySelectorAll('.section');
      sections.forEach(section => {
        section.classList.remove('active');
      });
      document.getElementById(sectionId).classList.add('active');
    }


    function showSection(sectionId) {
  const sections = document.querySelectorAll('.section');
  const links = document.querySelectorAll('.sidebar a');

  // Hide all sections
  sections.forEach(section => {
    section.classList.remove('active');
  });

  // Remove active class from all links
  links.forEach(link => {
    link.classList.remove('active');
  });

  // Show the clicked section and highlight its link
  document.getElementById(sectionId).classList.add('active');
  const clickedLink = Array.from(links).find(link => link.getAttribute('onclick') === `showSection('${sectionId}')`);
  if (clickedLink) {
    clickedLink.classList.add('active');
  }
}
  // Auto-hide success and error messages
setTimeout(() => {
  const successMessage = document.getElementById('successMessage');
  if (successMessage) {
    successMessage.style.transition = 'opacity 0.5s';
    successMessage.style.opacity = '0';
    setTimeout(() => successMessage.remove(), 500);
  }

  const errorMessage = document.getElementById('errorMessage');
  if (errorMessage) {
    errorMessage.style.transition = 'opacity 0.5s';
    errorMessage.style.opacity = '0';
    setTimeout(() => errorMessage.remove(), 500);
  }
}, 1000);


    // Dark mode switch functionality
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;
    const sidebar = document.querySelector('.sidebar');

    // Check for saved user preference
    const isDarkMode = localStorage.getItem('dark-mode') === 'true';
    if (isDarkMode) {
      body.classList.add('dark-mode');
      sidebar.classList.add('dark-mode');
      darkModeToggle.checked = true;
    }

    darkModeToggle.addEventListener('change', () => {
      const isEnabled = darkModeToggle.checked;
      body.classList.toggle('dark-mode', isEnabled);
      sidebar.classList.toggle('dark-mode', isEnabled);
      localStorage.setItem('dark-mode', isEnabled);
    });

    
    function submitForm(action) {
        document.getElementById('formAction').value = action;
        document.querySelector('form').submit();
    }

  </script>
</body>
</html>
