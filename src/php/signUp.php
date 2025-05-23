<?php ob_start();?>
<?php
session_start();
$signupMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "wmr_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validation: both fields must be 8+ characters
    if (strlen($username) < 4 || strlen($password) < 8) {
        $signupMessage = "❌ Username and password must be at least 8 characters.";
    } elseif ($password !== $confirmPassword) {
        $signupMessage = "❌ Passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $signupMessage = "❌ Username already exists.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $insert->bind_param("ss", $username, $hashedPassword);

            if ($insert->execute()) {
                $_SESSION['user_id'] = $insert->insert_id;
                $_SESSION['username'] = $username;
                header("Location: login.php");
                exit();
            } else {
                $signupMessage = "❌ Error creating account.";
            }
            $insert->close();
        }
        $stmt->close();
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

        <?php if (!empty($$signupMessage)) : ?>
            <div style="text-align: center; color: red; margin-bottom: 15px;">
                <?= $signupMessage ?>
            </div>
        <?php endif; ?>

        <div class="card-login">
            <h1>Sign up</h1>
                <form action="signUp.php" method="POST" onsubmit="return validateForm()">
                    <div>
                        <label for="username">Username:</label>
                        <input type="text" name="username" placeholder="Enter username" class="rounded" id="username" minlength="4" required>
                    </div>
                    <div>
                        <label for="password">Password</label>
                        <input type="password" name="password" placeholder="Enter password" class="rounded" id="password" minlength="8" required>

                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" placeholder="Confirm password" class="rounded" id="confirm_password" minlength="8" required>
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
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        if (username.length < 4) {
            alert("Username must be at least 4 characters.");
            return false;
        }

        if (password.length < 8) {
            alert("Password must be at least 8 characters.");
            return false;
        }

        if (password !== confirmPassword) {
            alert("Passwords do not match!");
            return false;
        }

        return true;
    }
</script>

<?php ob_end_flush(); ?>

</body>
</html>
