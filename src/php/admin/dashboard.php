<?php
session_start();
require_once __DIR__ . '/../db.php';

// Check if user is logged in as admin
if (!isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Handle form submission for updating request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_request'])) {
    $requestId = $_POST['request_id'];
    $driverName = $_POST['driver_name'];
    $assistantName = $_POST['assistant_name'];
    $plateNumber = $_POST['plate_number'];
    $contactNumber = $_POST['contact_number'];
    $currentLocation = $_POST['current_location'];

    $stmt = $pdo->prepare("
        UPDATE delivery_requests 
        SET 
            driver_name = ?, 
            driver_assistant = ?, 
            plate_number = ?, 
            contact_number = ?,
            current_location = ?,
            status = 'In Transit'
        WHERE id = ?
    ");
    $stmt->execute([
        $driverName,
        $assistantName,
        $plateNumber,
        $contactNumber,
        $currentLocation,
        $requestId
    ]);

    header("Location: dashboard.php");
    exit();
}

// Handle status update (Arrived or Rejected)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $requestId = $_POST['request_id'];
    $newStatus = $_POST['update_status'];

    $stmt = $pdo->prepare("UPDATE delivery_requests SET status = ? WHERE id = ?");
    $stmt->execute([$newStatus, $requestId]);

    header("Location: dashboard.php");
    exit();
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_request'])) {
    $requestId = $_POST['request_id'];

    $stmt = $pdo->prepare("DELETE FROM delivery_requests WHERE id = ?");
    $stmt->execute([$requestId]);

    header("Location: dashboard.php");
    exit();
}

// ...existing code...





// Fetch statistics
$stats = [];

// Total deliveries
$stmt = $pdo->query("SELECT COUNT(*) FROM delivery_requests");
$stats['total_deliveries'] = $stmt->fetchColumn() ?: 0;

// Pending requests
$stmt = $pdo->query("SELECT COUNT(*) FROM delivery_requests WHERE status = 'Pending'");
$stats['pending_requests'] = $stmt->fetchColumn() ?: 0;

// User contacts
$stmt = $pdo->query("SELECT COUNT(*) FROM contact_messages");
$stats['user_contacts'] = $stmt->fetchColumn() ?: 0;

// Recent requests - latest 5
$stmt = $pdo->query("
    SELECT dr.*, u.username 
    FROM delivery_requests dr
    LEFT JOIN users u ON dr.client_id = u.id
    ORDER BY dr.created_at DESC 
    LIMIT 5
");
$recent_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get request details if editing
$editRequest = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("
        SELECT dr.*, u.username 
        FROM delivery_requests dr
        LEFT JOIN users u ON dr.client_id = u.id
        WHERE dr.id = ?
    ");
    $stmt->execute([$_GET['edit']]);
    $editRequest = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            overflow-x: hidden;
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
            position: relative;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: var(--primary-color);
            color: white;
            padding: 20px 0;
            transition: transform 0.3s ease;
            position: fixed;
            height: 100vh;
            z-index: 100;
        }
        
        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header h2 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }
        
        .sidebar-header p {
            color: var(--light-color);
            font-size: 0.9rem;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .menu-item:hover {
            background-color: rgba(255,255,255,0.1);
        }
        
        .menu-item.active {
            background-color: var(--accent-color);
        }
        
        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Burger Menu */
        .burger-menu {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 101;
            background: var(--primary-color);
            color: white;
            border: none;
            font-size: 1.5rem;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            padding: 30px;
            margin-left: 250px;
            transition: margin 0.3s ease;
        }
        
        .dashboard-header {
            margin-bottom: 30px;
        }
        
        .dashboard-header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .stat-card .icon {
            font-size: 2rem;
            color: var(--accent-color);
            margin-bottom: 10px;
        }
        
        .stat-card .value {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 5px;
            color: var(--primary-color);
        }
        
        .stat-card h3 {
            color: #666;
            font-size: 1rem;
        }
        
        /* Requests Table */
        .requests-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .requests-table th, .requests-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .requests-table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
        }
        
        .requests-table tr:hover {
            background-color: #f9f9f9;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-pending {
            background-color: var(--warning-color);
            color: white;
        }
        
        .status-in-transit {
            background-color: var(--accent-color);
            color: white;
        }
        
        .status-completed {
            background-color: var(--success-color);
            color: white;
        }
        
        .divider {
            height: 1px;
            background-color: #eee;
            margin: 20px 0;
        }
        
        /* Buttons */
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-edit {
            background-color: var(--accent-color);
            color: white;
        }
        
        .btn-edit:hover {
            background-color: #2980b9;
        }
        
        /* Edit Form */
        .edit-form {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        
        .btn-save {
            background-color: var(--success-color);
            color: white;
        }
        
        .btn-cancel {
            background-color: #95a5a6;
            color: white;
        }
        
        /* Overlay for mobile */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 99;
            display: none;
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .burger-menu {
                display: block;
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .overlay.active {
                display: block;
            }
        }
        
        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .requests-table {
                display: block;
                overflow-x: auto;
            }
            
            .edit-form {
                padding: 15px;
            }
        }
        
        @media (max-width: 576px) {
            .main-content {
                padding: 20px 15px;
            }
            
            .dashboard-header h1 {
                font-size: 1.5rem;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Burger Menu Button -->
    <button class="burger-menu" id="burgerMenu">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay"></div>
    
    <div class="admin-container">
        <!-- Include Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Main Content Area -->
        <div class="main-content">
            <div class="dashboard-header">
                <h1>Dashboard</h1>
            </div>

            <!-- Stats Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-truck"></i></div>
                    <div class="value"><?= htmlspecialchars($stats['total_deliveries']) ?></div>
                    <h3>Total Deliveries</h3>
                </div>

                <div class="stat-card">
                    <div class="icon"><i class="fas fa-clock"></i></div>
                    <div class="value"><?= htmlspecialchars($stats['pending_requests']) ?></div>
                    <h3>Pending Requests</h3>
                </div>

                <div class="stat-card">
                    <div class="icon"><i class="fas fa-user-friends"></i></div>
                    <div class="value"><?= htmlspecialchars($stats['user_contacts']) ?></div>
                    <h3>User Contacts</h3>
                </div>
            </div>

            <div class="divider"></div>

            <h3>Recent Delivery Requests</h3>
            <table class="requests-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Products</th>
                        <th>Boxes</th>
                        <th>Weight</th>
                        <th>Pick-up Address</th>
                        <th>Deliver to</th>
                        <th>Status</th>
                        <th>Pick up date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recent_requests)): ?>
                        <?php foreach ($recent_requests as $request): ?>
                        <tr>
                            <td><?= htmlspecialchars($request['id']) ?></td>
                            <td><?= htmlspecialchars($request['username'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars(mb_strimwidth($request['product_description'], 0, 20, '...')) ?></td>
                            <td><?= htmlspecialchars($request['estimated_boxes']) ?></td>
                            <td><?= htmlspecialchars($request['estimated_weight']) ?> kg</td>
                            <td><?= htmlspecialchars(mb_strimwidth($request['pickup_address'], 0, 20, '...')) ?></td>
                            <td><?= htmlspecialchars(mb_strimwidth($request['delivery_address'], 0, 20, '...')) ?></td>
                            <td>
                                <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $request['status'])) ?>">
                                    <?= htmlspecialchars($request['status']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($request['pickup_date']) ?></td>
                            <td>
    <a href="?edit=<?= $request['id'] ?>" class="btn btn-edit">Edit</a>
    <form method="POST" action="" style="display:inline;" onsubmit="return confirm('Mark as Arrived?');">
        <input type="hidden" name="update_status" value="Arrived">
        <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
        <button class="btn btn-save" type="submit">Arrived</button>
    </form>
    <form method="POST" action="" style="display:inline;" onsubmit="return confirm('Reject this request?');">
        <input type="hidden" name="update_status" value="Rejected">
        <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
        <button class="btn btn-cancel" type="submit">Reject</button>
    </form>
    <form method="POST" action="" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this request?');">
        <input type="hidden" name="delete_request" value="1">
        <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
        <button class="btn btn-cancel" style="background-color: #e74c3c;">Delete</button>
    </form>
</td>

                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">No recent requests found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <?php if ($editRequest): ?>
            <div class="edit-form">
                <h3>Edit Delivery Request #<?= htmlspecialchars($editRequest['id']) ?></h3>
                <form method="POST">
                    <input type="hidden" name="request_id" value="<?= htmlspecialchars($editRequest['id']) ?>">
                    
                    <div class="form-group">
                        <label>Client</label>
                        <input type="text" value="<?= htmlspecialchars($editRequest['username'] ?? 'N/A') ?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>Pick-up Address</label>
                        <input type="text" value="<?= htmlspecialchars($editRequest['pickup_address']) ?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>Delivery Address</label>
                        <input type="text" value="<?= htmlspecialchars($editRequest['delivery_address']) ?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>Driver's Name</label>
                        <input type="text" name="driver_name" value="<?= htmlspecialchars($editRequest['driver_name'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Assistant's Name</label>
                        <input type="text" name="assistant_name" value="<?= htmlspecialchars($editRequest['driver_assistant'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Plate Number</label>
                        <input type="text" name="plate_number" value="<?= htmlspecialchars($editRequest['plate_number'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" name="contact_number" value="<?= htmlspecialchars($editRequest['contact_number'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Current Location</label>
                        <input type="text" name="current_location" value="<?= htmlspecialchars($editRequest['current_location'] ?? '') ?>" required>
                    </div>

                    
                    <div class="form-actions">
                        <a href="dashboard.php" class="btn btn-cancel" onclick="return confirm('Are you sure you want to cancel? Unsaved changes will be lost.')">Cancel</a>


                        <button type="submit" name="update_request" class="btn btn-save">Save & Set to In Transit</button>

                    </div>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Burger menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const burgerMenu = document.getElementById('burgerMenu');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('overlay');
            
            burgerMenu.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
                
                // Change icon based on state
                const icon = this.querySelector('i');
                if (sidebar.classList.contains('active')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
            
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                this.classList.remove('active');
                burgerMenu.querySelector('i').classList.remove('fa-times');
                burgerMenu.querySelector('i').classList.add('fa-bars');
            });
            
            // Close sidebar when clicking on a menu item (for mobile)
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    if (window.innerWidth <= 992) {
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                        burgerMenu.querySelector('i').classList.remove('fa-times');
                        burgerMenu.querySelector('i').classList.add('fa-bars');
                    }
                });
            });
        });
    </script>
</body>
</html>