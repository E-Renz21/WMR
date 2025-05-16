<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$isLoggedIn = isset($_SESSION['user_id']);
$defaultAvatar = "../images/profileAvatar.png"; // fallback
$avatar = $defaultAvatar;


if ($isLoggedIn) {
    $conn = new mysqli("localhost", "root", "", "wmr_db"); // updated DB name if needed

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the profile picture from the clients table
    $stmt = $conn->prepare("SELECT profile_picture FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']); // assuming clients.id = users.id
    $stmt->execute();
    $stmt->bind_result($profilePic);

    if ($stmt->fetch() && !empty($profilePic)) {
        $avatar = "../uploads/" . htmlspecialchars($profilePic);
    }

    $stmt->close();
    $conn->close();
}
?>


<header class="delivery-status-nav">
    <img src="../images/logo.png" class="delivery-status-logo" alt="Logo">
    <div class="delivery-status-burger" onclick="toggleDeliveryStatusMenu()">☰</div>
    <div class="delivery-status-right-side" id="delivery-status-nav-menu">
        <nav class="delivery-status-nav-links">
            <a href="/wmr/src/php/index.php#hero">Request Delivery</a>
            <a href="/wmr/src/php/deliveryStatus.php">Delivery Status</a>
            <a href="/wmr/src/php/index.php#trucks">Trucks</a>
            <a href="/wmr/src/php/index.php#vision-mission">About Us</a>
            <a href="/wmr/src/php/index.php#contactUs">Contact Us</a>
        </nav>

        <div class="delivery-status-auth-buttons">
            <?php if ($isLoggedIn): ?>
                <div class="profile-dropdown">
                    <img src="<?= htmlspecialchars($avatar) ?>" alt="Profile" class="profile-avatar" id="profileBtn" onclick="toggleProfileDropdown()">
                    <div class="profile-dropdown-content" id="profileDropdown">
                        <a href="/wmr/src/php/profile.php">Profile</a>
                       <a href="/wmr/src/php/logout.php">Logout</a>

                    </div>
                </div>
            <?php else: ?>
                <button class="delivery-status-btn" onclick="window.location.href='/wmr/src/php/login.php'">Login</button>
                <button class="delivery-status-btn" onclick="window.location.href='/wmr/src/php/signUp.php'">Sign up</button>
            <?php endif; ?>
        </div>
    </div>
</header>

<script>
    function toggleDeliveryStatusMenu() {
        const menu = document.getElementById('delivery-status-nav-menu');
        menu.classList.toggle('show');
    }
    
    function toggleProfileDropdown() {
        // Close any other open dropdowns first
        const allDropdowns = document.querySelectorAll('.profile-dropdown-content');
        allDropdowns.forEach(dropdown => {
            if (dropdown.id !== 'profileDropdown' && dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });
        
        // Toggle the clicked dropdown
        document.getElementById('profileDropdown').classList.toggle('show');
    }
    
    // Close dropdowns when clicking outside
    window.onclick = function(event) {
        if (!event.target.matches('#profileBtn') && !event.target.matches('.profile-avatar')) {
            const dropdowns = document.getElementsByClassName("profile-dropdown-content");
            for (let i = 0; i < dropdowns.length; i++) {
                const openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>