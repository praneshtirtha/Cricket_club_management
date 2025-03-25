<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Cricket Club Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212; /* Dark background */
            color: #ffffff; /* Light text */
        }

        .hero-section {
            background: url('contact-bg.jpg') no-repeat center center/cover;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #ffffff;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        .contact-details {
            padding: 40px 20px;
        }

        .contact-details h2 {
            color: #007bff;
        }

        .contact-details a {
            color: #00ff7f;
            text-decoration: none;
        }

        .contact-details a:hover {
            text-decoration: underline;
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
                    <a class="nav-link <?php echo basename($_SERVER['SCRIPT_NAME']) == 'index.html' ? 'active' : ''; ?>" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['SCRIPT_NAME']) == 'about.php' ? 'active' : ''; ?>" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['SCRIPT_NAME']) == 'contact.php' ? 'active' : ''; ?>" href="contact.php">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <h1 class="display-4">Contact Us</h1>
        <p class="lead">We’re here to assist you!</p>
    </div>

    <!-- Contact Details Section -->
    <div class="container contact-details">
        <h2>Contact Information</h2>
        <p>Feel free to reach out to us through any of the following channels:</p>

        <h4>Email</h4>
        <p>
            <a href="mailto:admin1@cricketclub.com">praneshmajumder80@gmail.com</a><br>
            <a href="mailto:admin2@cricketclub.com">pranesh.tirtha@northsouth.edu</a>
        </p>

        <h4>Phone</h4>
        <p>
            <a href="tel:+1234567890">+8801648054148</a><br>
            <a href="tel:+0987654321">+8801322361431</a>
        </p>

        <h4>Social Media</h4>
        <p>
            <a href="https://wa.me/+8801648054148" target="_blank">WhatsApp</a><br>
            <a href="https://www.facebook.com/pranesh.majumder.777/" target="_blank">Facebook</a>
        </p>

        <h4>Location</h4>
        <div>
            <!-- Embed Google Maps -->
            <iframe 
                src="https://www.google.com/maps/@23.8092288,90.4200192,14z?entry=ttu&g_ep=EgoyMDI0MTExMy4xIKXMDSoASAFQAw%3D%3D" 
                width="100%" 
                height="300" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy"
            ></iframe>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-3 bg-dark">
        <p>&copy; 2024 Cricket Club Management. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
