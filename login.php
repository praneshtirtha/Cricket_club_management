<?php
// Start session
session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['UserID'])) {
    header("Location: dash.php");
    exit();
}

// Include database connection
require 'db_connection.php';

// Initialize error message variable
$error_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validate inputs
    if (empty($email) || empty($password)) {
        $error_message = "Please enter both email and password.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        // Query to fetch user data based on email
        $stmt = $conn->prepare("SELECT username, email, password, Fullname, Phone, UserID FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a user record exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc(); // Fetch the user record as an associative array

            // Fetch the hashed password from the database
            $db_password = $user['password'];

            // Use password_verify to check if the entered password matches the stored hash
            if (password_verify($password, $db_password)) {
                // Set session variables
                $_SESSION['UserID'] = $user['UserID']; // Store the UserID from the database
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['fullname'] = $user['Fullname'];
                $_SESSION['phone'] = $user['Phone'];

                // Redirect to dashboard
                header("Location: dash.php");
                exit();
            } else {
                // Incorrect password
                $_SESSION['error_message'] = "Invalid password. Please try again.";
                header("Location: login.php");
                exit();
            }
        } else {
            // No user found with the given email
            $_SESSION['error_message'] = "No account found with this email. Please sign up.";
            header("Location: login.php");
            exit();
        }

        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cricket Club Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Login</h2>

        <!-- Display error message if there is one -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php 
                echo $_SESSION['error_message'];
                unset($_SESSION['error_message']); // Clear the message after displaying it
                ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <p class="mt-3">Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
