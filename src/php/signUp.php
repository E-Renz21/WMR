<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // DB config
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "wmr";

    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result(); 

    if ($check->num_rows > 0) {
        $check->close();
        $conn->close();
        die("This email is already registered.");
    }

    $check->close(); // close the select statement

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "User registered successfully.";
        // header("Location: ../html/login.html"); exit(); // optional redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../html/signUp.html");
    exit();
}
?>
