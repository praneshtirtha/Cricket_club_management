<?php
// Start session
session_start();

// Destroy all session variables
session_unset();
session_destroy();

// Redirect to homepage
header("Location: index.html");
exit();
?>
