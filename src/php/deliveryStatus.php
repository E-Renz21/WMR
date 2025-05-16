<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = 'deliveryStatus.php'; // Save target page
    header("Location: login.php");
    exit();
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
                <h5>Delivery Requests</h5>
                
                <div class="request-item">
                    <img src="../images/Box.png" alt="Package">
                    <div class="request-info">
                        <div class="request-date">May 12, 2025</div>
                        <span class="request-status status-intransit">In Transit</span>
                        <div class="request-locations">
                            <span>Davao City</span>
                            <img src="../images/arrow_back.png" alt="To">
                            <span>Cagayan De Oro City</span>
                        </div>
                    </div>
                </div>
                
                <div class="request-item">
                    <img src="../images/Box.png" alt="Package">
                    <div class="request-info">
                        <div class="request-date">May 10, 2025</div>
                        <span class="request-status status-arrived">Arrived</span>
                        <div class="request-locations">
                            <span>Davao City</span>
                            <img src="../images/arrow_back.png" alt="To">
                            <span>Zamboanga City</span>
                        </div>
                    </div>
                </div>
                
                <div class="request-item">
                    <img src="../images/Box.png" alt="Package">
                    <div class="request-info">
                        <div class="request-date">May 1, 2025</div>
                        <span class="request-status status-arrived">Arrived</span>
                        <div class="request-locations">
                            <span>Cagayan De Oro</span>
                            <img src="../images/arrow_back.png" alt="To">
                            <span>Davao City</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side -->
        <div class="right-side">
            <!-- Driver Info Section -->
            <div class="driver-info">
                <div class="driver-top">
                    <div class="driver-section">
                        <img src="../images/car-driver.png" alt="Driver">
                        <div class="driver-details">
                            <p>Driver's Name</p>
                            <h2>Carlos John Tingson</h2>
                        </div>
                    </div>
                    
                    <div class="driver-section">
                        <img src="../images/DriverLogo.png" alt="Assistant">
                        <div class="driver-details">
                            <p>Driver's Assistant</p>
                            <h2>Joemire Dave Loremas</h2>
                        </div>
                    </div>
                </div>
                
                <div class="driver-bottom">
                    <div class="truck-section">
                        <img src="../images/Trucklogo.png" alt="Truck">
                        <div class="driver-details">
                            <p>Plate Number</p>
                            <h2>ABX 1245</h2>
                        </div>
                    </div>
                    
                    <div class="phone-section">
                        <img src="../images/phoneLogo.png" alt="Phone">
                        <div class="driver-details">
                            <p>Driver/Assistant Contact Number</p>
                            <h2>09204206464</h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Delivery Details Section -->
            <div class="delivery-details">
                <div class="details-container">
                    <!-- Left Details Column -->
                    <div class="details-left">
                        <div class="location-section">
                            <img src="../images/roadLogo.png" alt="Location">
                            <div>
                                <p>Current Location</p>
                                <h2>Pagadian</h2>
                            </div>
                        </div>
                        
                        <div class="date-time-grid">
                            <div class="date-time-item">
                                <p>Departure Date</p>
                                <h2>May 11, 2025</h2>
                            </div>
                            
                            <div class="date-time-item">
                                <p>Departure Time</p>
                                <h2>3:30 PM</h2>
                            </div>
                        </div>
                        
                        <div class="address-section">
                            <p>Departure Address</p>
                            <p>456 Sampaguita Street, Barangay Matina Apiaya, Davao City</p>
                        </div>
                        
                        <div class="address-section">
                            <p>Arrival Address</p>
                            <p>789 Basilan Loop, Barangay Tetuan, Zamboanga City, Zamboanga del Sur</p>
                        </div>
                    </div>
                    
                    <!-- Right Details Column -->
                    <div class="details-right">
                        <div class="status-section">
                            <div class="status-label">Status</div>
                            <div class="status-value">In Transit</div>
                        </div>
                        
                        <div class="date-time-item">
                            <p>Expected Date to Arrive</p>
                            <h2>May 13, 2025</h2>
                        </div>
                        
                        <div class="cargo-section">
                            <div class="cargo-item">
                                <img src="../images/Weight_Logo.png" alt="Weight">
                                <div class="cargo-details">
                                    <p>Cargo Weight</p>
                                    <h2>15 tons</h2>
                                </div>
                            </div>
                            
                            <div class="cargo-item">
                                <img src="../images/boxes 2.png" alt="Boxes">
                                <div class="cargo-details">
                                    <p>Amount of Boxes</p>
                                    <h2>588</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>