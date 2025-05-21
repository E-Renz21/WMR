<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="delivery-status-nav">
    <img src="../../images/logo.png" class="delivery-status-logo" alt="Logo">
    <h1>Admin</h1>
    <div class="delivery-status-right-side" id="delivery-status-nav-menu">
    </div>
</header>