<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "wmr");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user input from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prevent SQL injection
    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userId, $userEmail, $userPassword);

    if ($stmt->num_rows > 0) {
        // If user exists, check password
        $stmt->fetch();

        if (password_verify($password, $userPassword)) {
            // Set session for logged-in user
            $_SESSION['user_id'] = $userId;
            $_SESSION['email'] = $userEmail;
            header("Location: dashboard.php"); // Redirect to the dashboard or home page
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this email.";
    }

    $stmt->close();
    $conn->close();
}
?>
