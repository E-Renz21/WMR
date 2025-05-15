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
     <section class="vision-mission">
        <div class="vm-container">
            <!-- Left: Journey Box -->
            <div class="vm-box journey">
                <h5>THE JOURNEY OF</h5>
                <img src="../images/logo.png" alt="WMR Logo" class="vm-logo">
                <p>
                    WMR Trucking Services began as a small, family-run business around 2008–2009 with just one truck. 
                    Through determination and effort, they were able to grow by adding more trucks over the years. 
                    In the beginning, they personally approached companies to offer their services.

                    Today, the company has earned the trust of clients who now reach out directly for their delivery needs.
                </p>
            </div>

            <!-- Right: Vision and Mission stacked -->
            <div class="right-column">
                <div class="vm-box vision">
                <h1>VISION</h1>
                <p>
                To expand our trucking services across the country and be known for providing fast,
                safe, and reliable deliveries that help businesses grow.
                </p>
            </div>

            <div class="vm-box mission">
                <h1>MISSION</h1>
                <p>
                To provide reliable, safe, and efficient trucking services that meet the delivery needs of our clients.
                We are committed to maintaining professional service, timely operations, and continuous improvement 
                to support business growth and customer satisfaction.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="contactUs">
    <div class="contact-container">
        <!-- Left: Black background with form -->
        <div class="contact-left">
            <h1>CONTACT US</h1>
            <div class="contact-form">
                <form action="">
                    <p>First Name</p>
                    <input type="text" required>
                    
                    <p>Last Name</p>
                    <input type="text" required>
                    
                    <p>Phone Number</p>
                    <input type="tel" required>
                    
                    <p>Email</p>
                    <input type="email" required>
                    
                    <p>Message</p>
                    <textarea rows="4" style="resize: none;"></textarea>
                    
                    <button class="submitBTN" type="submit">SEND MESSAGE</button>
                </form>
            </div>
        </div>
        
        <!-- Right: White background with address and map -->
        <div class="contact-right">
            <div class="address-box">
                <h5>Company Headquarters</h5>
                <p>Purok 8 Pagkakaisa, Barangay Lubogan, Toril, Davao City, Philippines</p>
            </div>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d665.3704300243431!2d125.49571120543497!3d7.028933784920923!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sPurok%208%20Pagkakaisa%2C%20Barangay%20Lubogan%2C%20Toril%2C%20Davao%20City%2C%20Philippines!5e1!3m2!1sen!2sph!4v1747214176585!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
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