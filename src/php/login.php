<?php
session_start();
$loginMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "wmr");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($userId, $userEmail, $userPassword);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();

        if (password_verify($password, $userPassword)) {
            $_SESSION['user_id'] = $userId;
            $_SESSION['email'] = $userEmail;
            header("Location: dashboard.php");
            exit();
        } else {
            $loginMessage = "❌ Invalid password.";
        }
    } else {
        $loginMessage = "❌ No user found with this email.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="../js/script.js" defer></script>
</head>
<body>
    <div class="container">
        <img class="logo" src="../images/logo.png" alt="WMR Logo">
        <h1 class="intro-text">Sign in to WMR to request a delivery and track your deliveries.</h1>

        <?php if (!empty($loginMessage)) : ?>
            <div style="text-align: center; color: red; margin-bottom: 15px;">
                <?= $loginMessage ?>
            </div>
        <?php endif; ?>

        <div class="card-login">
            <h1>Login</h1>
            <form method="POST" action="login.php">
                <div>
                    <label for="login-name">Email:</label>
                    <input type="text" name="email" placeholder="Enter email" id="login-name" class="rounded" required>
                </div>
                <div>
                    <label for="login-password">Password</label>
                    <input type="password" name="password" placeholder="Enter password" id="login-password" class="rounded" required>
                    <a id="forgotPassBTN" href="#">Forgot Password?</a>
                </div>
                <button class="rounded" type="submit">Login</button>
            </form>

            <div style="margin-top: 20px; text-align: center;">
                <div id="g_id_onload"
                     data-client_id="YOUR_GOOGLE_CLIENT_ID"
                     data-context="signin"
                     data-ux_mode="popup"
                     data-callback="handleCredentialResponse"
                     data-auto_prompt="false">
                </div>

                <div class="g_id_signin"
                     data-type="standard"
                     data-size="large"
                     data-theme="outline"
                     data-text="sign_in_with"
                     data-shape="rectangular"
                     data-logo_alignment="left">
                </div>
            </div>

            <div class="sign-up-container">
                <p>New User?</p>
                <a href="signUp.php">Create account here</a>
            </div>
        </div>
    </div>

    <script>
        function handleCredentialResponse(response) {
            const data = { credential: response.credential };

            fetch('../php/verify_google_login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.href = "dashboard.php";
                } else {
                    alert("Google login failed");
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>
