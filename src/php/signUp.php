<?php
$registrationMessage = "";

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
        $registrationMessage = "❌ Passwords do not match.";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result(); 

        if ($check->num_rows > 0) {
            $registrationMessage = "❌ This email is already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $hashedPassword);

            if ($stmt->execute()) {
                $registrationMessage = "✅ User registered successfully. <a href='login.php'>Login here</a>.";
            } else {
                $registrationMessage = "❌ Error: " . $stmt->error;
            }

            $stmt->close();
        }
        $check->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign up</title>
    <link rel="stylesheet" href="../css/signUp.css">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="../js/script.js" defer></script>
</head>
<body>
    <div class="container">
        <img class="logo" src="../images/logo.png" alt="WMR Logo">
        <h1 class="intro-text">Sign up to WMR to request a delivery and track your deliveries.</h1>

        <?php if (!empty($registrationMessage)) : ?>
            <div style="text-align: center; color: red; margin-bottom: 15px;">
                <?= $registrationMessage ?>
            </div>
        <?php endif; ?>

        <div class="card-login">
            <h1>Sign up</h1>
            <form action="signUp.php" method="POST" onsubmit="return validateForm()">
                <div>
                    <label for="email">Email:</label>
                    <input type="email" name="email" placeholder="Enter email" class="rounded" required>
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Enter password" class="rounded" required>
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Confirm password" class="rounded" required>
                </div>
                <button type="submit" class="rounded">Sign up</button>
            </form>

            <div style="margin-top: 20px; text-align: center;">
                <div id="g_id_onload"
                    data-client_id="YOUR_GOOGLE_CLIENT_ID"
                    data-context="signup"
                    data-ux_mode="popup"
                    data-callback="handleCredentialResponse"
                    data-auto_prompt="false">
                </div>
                <div class="g_id_signin"
                    data-type="standard"
                    data-size="large"
                    data-theme="outline"
                    data-text="continue_with"
                    data-shape="rectangular"
                    data-logo_alignment="left">
                </div>
            </div>

            <div class="sign-in-container">
                <p>Already have an account?</p>
                <a href="login.php">Login in here</a>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]').value;

            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
