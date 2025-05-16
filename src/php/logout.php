<?php
session_start();
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session
header("Location: index.php"); // Redirect to homepage
exit();
?>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="0.1;url=index.php">
    <title>Logging out...</title>
</head>
<body>
    <p>You have been logged out. Redirecting to home...</p>
</body>
</html>
