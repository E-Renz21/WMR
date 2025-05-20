<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = 'deliveryStatus.php'; // Save target page
    header("Location: login.php");
    exit();
}
$userId = $_SESSION['user_id'];
$conn = new mysqli("localhost", "root", "", "wmr_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("
    SELECT * FROM delivery_requests 
    WHERE client_id = $userId 
    ORDER BY created_at DESC
");

// Optional: Handle selected request (if using ?request_id=... in the URL)
$selectedRequest = null;
if (isset($_GET['request_id'])) {
    $requestId = (int) $_GET['request_id'];
    $stmt = $conn->prepare("SELECT * FROM delivery_requests WHERE id = ? AND client_id = ?");
    $stmt->bind_param("ii", $requestId, $userId);
    $stmt->execute();
    $selectedRequest = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Status</title>
    <link rel="stylesheet" href="../css/deliveryStatus.css">
    <link rel="stylesheet" href="../css/header.css">
    <style>
        /* Add these styles to your existing CSS */
        .driver-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .driver-pair {
            display: flex;
            gap: 20px;
            width: 100%;
        }
        
        .driver-section {
            flex: 1;
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .driver-section img {
            margin-right: 15px;
            height: 40px;
        }
        
        .driver-details {
            flex: 1;
        }
        
        .driver-details p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        
        .driver-details h2 {
            margin: 5px 0 0;
            font-size: 18px;
        }

        /* New styles for date-time sections */
        .date-time-container {
            display: flex;
            gap: 20px;
            margin-top: 15px;
            width: 100%;
        }

        .date-time-section {
            flex: 1;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .date-time-section p {
            margin: 0 0 5px 0;
            font-size: 14px;
            color: #666;
        }

        .date-time-section h2 {
            margin: 0;
            font-size: 18px;
        }

        .admin-note {
            background: #333;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .admin-note p {
            margin: 0 0 5px 0;
            font-size: 14px;
            color: #ccc;
        }

        .admin-note-content {
            width: 100%;
            min-height: 80px;
            background: #444;
            color: white;
            border: 1px solid #555;
            border-radius: 4px;
            padding: 8px;
            overflow: auto;
            resize: none; /* Disable resizing */
            white-space: pre-wrap; /* Preserve formatting */
        }
    </style>
</head>
<body>  
    <?php include('header.php'); ?>
    
    <div class="main-container">
        <div class="hero-background"></div>
        <!-- Left Side -->
        <div class="left-side">
            <div class="delivery-status-header">
                <h1>Delivery Status</h1>
            </div>

            <div class="delivery-requests">
                <?php while($row = $result->fetch_assoc()): ?>
                    <?php
                        $isSelected = isset($_GET['request_id']) && $_GET['request_id'] == $row['id'];
                    ?>
                    <div class="request-item <?= $isSelected ? 'selected' : '' ?>">
                        <a href="?request_id=<?= $row['id'] ?>">
                            <img src="../images/Box.png" alt="Package">
                            <div class="request-info">
                                <div class="request-date"><?= date('F j, Y', strtotime($row['pickup_date'])) ?></div>
                                <span class="request-status status-<?= strtolower(str_replace(' ', '', $row['status'])) ?>">
                                    <?= $row['status'] ?>
                                </span>
                                <div class="request-locations">
                                    <span><?= htmlspecialchars($row['pickup_city']) ?></span>
                                    <img src="../images/arrow_back.png" alt="To">
                                    <span><?= htmlspecialchars($row['delivery_city']) ?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        
        <!-- Right Side -->
        <div class="right-side">
            <?php if ($selectedRequest): ?>
                <div class="driver-info">
                    <?php if ($selectedRequest['status'] === 'In Transit'): ?>
                        <div class="driver-pair">
                            <!-- Driver's Name -->
                            <div class="driver-section">
                                <img src="../images/car-driver.png" alt="Driver">
                                <div class="driver-details">
                                    <p>Driver's Name</p>
                                    <h2><?= htmlspecialchars($selectedRequest['driver_name']) ?></h2>
                                </div>
                            </div>
                            
                            <!-- Assistant's Name -->
                            <div class="driver-section">
                                <img src="../images/DriverLogo.png" alt="Assistant">
                                <div class="driver-details">
                                    <p>Assistant's Name</p>
                                    <h2><?= htmlspecialchars($selectedRequest['driver_assistant']) ?></h2>
                                </div>
                            </div>
                        </div>
                        
                        <div class="driver-pair">
                            <!-- Plate Number -->
                            <div class="driver-section">
                                <img src="../images/Trucklogo.png" alt="Truck">
                                <div class="driver-details">
                                    <p>Plate Number</p>
                                    <h2><?= htmlspecialchars($selectedRequest['plate_number']) ?></h2>
                                </div>
                            </div>
                            
                            <!-- Contact Number -->
                            <div class="driver-section">
                                <img src="../images/phoneLogo.png" alt="Phone">
                                <div class="driver-details">
                                    <p>Contact Number</p>
                                    <h2><?= htmlspecialchars($selectedRequest['contact_number']) ?></h2>
                                </div>
                            </div>
                        </div>

                        <!-- New date-time sections -->
                        <div class="date-time-container">
                            <div class="date-time-section">
                                <p>Departure Date</p>
                                <h2><?= htmlspecialchars($selectedRequest['departure_date'] ?? 'Not set') ?></h2>
                                <p>Departure Time</p>
                                <h2><?= htmlspecialchars($selectedRequest['departure_time'] ?? 'Not set') ?></h2>
                            </div>

                            <div class="date-time-section">
                                <p>Arrival Date</p>
                                <h2><?= htmlspecialchars($selectedRequest['arrival_date'] ?? 'Not set') ?></h2>
                                <p>Arrival Time</p>
                                <h2><?= htmlspecialchars($selectedRequest['arrival_time'] ?? 'Not set') ?></h2>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="delivery-details">
                    <div class="details-container">
                        <div class="details-left">
                            <div class="location-section">
                                <img src="../images/roadLogo.png" alt="Location">
                                <div>
                                    <p>Current Location</p>
                                    <h2><?= htmlspecialchars($selectedRequest['current_location'] ?? 'Unknown') ?></h2>
                                </div>
                            </div>

                            <div class="address-section">
                                <p>Departure Address</p>
                                <p><?= htmlspecialchars($selectedRequest['pickup_address'] ?? 'Not available yet') ?></p>
                            </div>

                            <div class="address-section">
                                <p>Arrival Address</p>
                                <p><?= htmlspecialchars($selectedRequest['delivery_address'] ?? 'Not available yet') ?></p>
                            </div>

                        </div>

                        <div class="details-right">
                            <div class="status-section">
                                <div class="status-label">Status</div>
                                <div class="status-value"><?= htmlspecialchars($selectedRequest['status']) ?></div>
                            </div>

                            <div class="date-time-item">
                                <p>Expected Arrival</p>
                                <h2><?= htmlspecialchars($selectedRequest['expected_arrival'] ?? 'Not set') ?></h2>
                            </div>

                            <!-- Admin note section -->
                            <div class="admin-note">
                                <p>Admin Notes</p>
                                <div class="admin-note-content"><?= nl2br(htmlspecialchars($selectedRequest['admin_notes'] ?? 'No notes available')) ?></div>
                            </div>

                            <div class="cargo-section">
                                <div class="cargo-item">
                                    <img src="../images/Weight_Logo.png" alt="Weight">
                                    <div class="cargo-details">
                                        <p>Cargo Weight</p>
                                        <h2><?= number_format($selectedRequest['estimated_weight']) ?> kg</h2>
                                    </div>
                                </div>

                                <div class="cargo-item">
                                    <img src="../images/boxes 2.png" alt="Boxes">
                                    <div class="cargo-details">
                                        <p>Amount of Boxes</p>
                                        <h2><?= htmlspecialchars($selectedRequest['estimated_boxes']) ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <p class="no-selection">No delivery request selected.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>