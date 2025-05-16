<header class="delivery-status-nav">
    <img src="../images/logo.png" class="delivery-status-logo" alt="Logo">
    <div class="delivery-status-burger" onclick="toggleDeliveryStatusMenu()">☰</div>
    <div class="delivery-status-right-side" id="delivery-status-nav-menu">
        <nav class="delivery-status-nav-links">
            <a href="/wmr/src/php/index.php#hero">Request Delivery</a>
            <a href="/wmr/src/php/index.php#trucks">Trucks</a>
            <a href="/wmr/src/php/index.php#vision-mission">About Us</a>
            <a href="/wmr/src/php/index.php#contactUs">Contact Us</a>
        </nav>

        <div class="delivery-status-auth-buttons">
            <button class="delivery-status-btn" onclick="window.location.href='/wmr/src/php/login.php'">Login</button>
            <button class="delivery-status-btn" onclick="window.location.href='/wmr/src/php/signUp.php'">Sign up</button>
        </div>
    </div>
</header>


<script>
    function toggleDeliveryStatusMenu() {
        const menu = document.getElementById('delivery-status-nav-menu');
        menu.classList.toggle('show');
    }
</script>