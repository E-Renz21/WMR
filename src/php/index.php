<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WMR Trucking - Home</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/header.css">

</head>
<body>

    <?php include('header.php'); ?> <!-- Includes your nav and logo -->

    <section id="hero" class="hero">
        <div class="hero-background"></div>
        <h1 class="home-text">TRUST WMR FOR YOUR DELIVERY NEEDS.</h1>
        <button onclick="window.location.href='request.php'" class="cta-btn">REQUEST DELIVERY NOW</button>

    </section>

    <section class="features">
        <div class="features-grid">
            <div class="feature-item">
                <div class="logo-container">
                    <img src="../images/Trucklogo.png" alt="Truck Logo" class="truckLogo">
                </div>
                <p>FAST AND RELIABLE DELIVERIES</p>
            </div>
            <div class="feature-item">
                <div class="logo-container">
                    <img src="../images/laptopLogo.png" alt="Laptop Logo">
                </div>
                <p>EASY ONLINE BOOKING</p>
            </div>
            <div class="feature-item">
                <div class="logo-container">
                    <img src="../images/CPlogo.png" alt="CP Logo">
                </div>
                <p>REAL-TIME UPDATES</p>
            </div>
        </div>
    </section>

    <section class="trucks" id="trucks">
        <h1>OUR TRUCKS</h1>
        <div class="truck-gallery">
            <img src="../images/truck1.png" alt="Truck 1">
            <img src="../images/Truck2.png" alt="Truck 2">
            <img src="../images/truck3.png" alt="Truck 3">
            <img src="../images/truck4.jpg" alt="Truck 4">
            <img src="../images/truck5.jpg" alt="Truck 5">
            <img src="../images/Truck6.png" alt="Truck 6">
            <img src="../images/Truck7.png" alt="Truck 7">
        </div>
        <div class="truck-description">
            <h2>Built for the Road, Trusted for the Load</h2>
            <h3>Our trucks are strong, reliable, and ready for any delivery task. 
                They are well-maintained to ensure safe and on-time transport of 
                your goods. With WMR, you can trust that your cargo is in good hands.</h3>
        </div>
    </section>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('nav-menu');
            menu.classList.toggle('show');
        }
    </script>

</body>
</html>