<!-- sidebar.php -->
<div class="sidebar">
    <div class="sidebar-header">
        <h2>Delivery Admin</h2>
        <p>Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></p>
    </div>

    <div class="sidebar-menu">
        <div class="menu-item">
            <i class="fas fa-tachometer-alt"></i>
            <span>Contacts</span>
        </div>
        <div class="menu-item active">
            <i class="fas fa-truck"></i>
            <span>Delivery Requests</span>
        </div>
        <div class="menu-item">
            <i class="fas fa-truck-moving"></i>
            <span>Trucks</span>
        </div>
        <div class="menu-item">
            <i class="fas fa-users"></i>
            <span>Drivers</span>
        </div>
        <div class="menu-item">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </div>
        <div class="menu-item">
            <i class="fas fa-file-alt"></i>
            <span>Request Form (test)</span>
        </div>
    </div>
</div>
