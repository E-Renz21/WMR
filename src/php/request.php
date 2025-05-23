<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = 'request.php'; // Save target page
    header("Location: login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "wmr_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $clientId = $_SESSION['user_id'];
    $productDescriptions = isset($_POST['products_hidden']) ? $_POST['products_hidden'] : '';
    $estimatedBoxes = $_POST['estimated_boxes'];
    $estimatedWeight = $_POST['estimated_weight'];
    $weightUnit = $_POST['weight_unit'];

    // Convert weight if needed
    if ($weightUnit === 'tons') {
        $estimatedWeight *= 1000; // convert tons to kilograms
    }

    $pickupCity = $_POST['pickup_city'];
    $pickupAddress = $_POST['pickup_address'];
    $deliveryCity = $_POST['delivery_city'];
    $deliveryAddress = $_POST['delivery_address'];
    $pickupDate = $_POST['pickup_date'];
    $arrivalDate = $_POST['estimated_arrival_date'];
    $contactNumber = $_POST['contact_number'];

$stmt = $conn->prepare("CALL insert_delivery_request(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sidsssssssi", 
    $productDescriptions, 
    $estimatedBoxes, 
    $estimatedWeight, 
    $pickupCity, 
    $pickupAddress, 
    $deliveryCity, 
    $deliveryAddress, 
    $pickupDate, 
    $arrivalDate, 
    $contactNumber, 
    $clientId
);



$stmt->bind_param("sidsssssssi", $productDescriptions, $estimatedBoxes, $estimatedWeight, $pickupCity, $pickupAddress, $deliveryCity, $deliveryAddress, $pickupDate, $arrivalDate, $contactNumber, $clientId);

    if ($stmt->execute()) {
        echo "<script>alert('Delivery request submitted successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Failed to submit delivery request.');</script>";
    }

    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Delivery</title>
    <link rel="stylesheet" href="../css/request.css">
    <link rel="stylesheet" href="../css/header.css">

</head>
<body>

    <?php include('header.php'); ?> <!-- Includes your nav and logo -->
        <div class="hero-background"></div>
    <div class="hero-background"></div>
    <main>
        <form action="request.php" method="POST">
            <input type="hidden" name="products_hidden" id="productsHidden">

            <div class="panel-wrapper">
             
            <section class="left-panel">
                <div class="request-header">
                    <h2>Request Delivery</h2>
                </div>
                
                    <div class="product-section">
                    <h6>Products</h6>
                    <div class="product-container">
                        <input type="text" id="productInput" name="products[]" placeholder="Enter product name" >
                        <button type="button" class="addProductBTN" onclick="addProduct()">+</button>
                    </div>

                    <div class="product-list" id="productList">
                        <!-- Products will be added here dynamically -->
                    </div>
                </div>


                <div class="content-section">
                    <p>Check of what kind of estimated amount for your cargo, whether by boxes, by weight or both.</p>
                    
                    <div class="input-group">
                        <div class="box-icon">
                            <img src="../images/boxes 2.png" alt="">
                            <h4>Estimated Boxes</h4>
                        </div>
                        <input type="number" name="estimated_boxes" placeholder="Enter number of boxes">
                    </div>
                    
                    <div class="input-group">
                        <div class="weight-icon">
                            <img src="../images/Weight_Logo-removebg-preview 1.png" alt="">
                            <h4>Estimated Weight</h4>
                        </div>
                        <div class="weight-container">
                            <input type="number" name="estimated_weight" placeholder="Enter weight" required>
                            <select name="weight_unit">
                                    <option value="kg">Kg</option>
                                    <option value="tons">Tons</option>
                            </select>
                        </div>
                    </div>
                    <p>Minimum of 20 Tons or 18144 Kilograms</p>
                </div>
               
            </section>

            <section class="right-panel">
                    <div class="address-field">
                        <label>Contact Number</label>
                        <input type="text" name="contact_number" placeholder="Enter contact number"  required>
                    </div>
                    <div class="address-section">
                    <div class="address-header">
                        <img class="pickupLogo" src="../images/PICK UP 1.png" alt="Pickup icon">
                        <h4>Pick-up Address</h4>
                        
                    </div>
                    
                    <div class="address-field">
                        <label>City/Municipality/Town</label>
                        <input type="text" name="pickup_city" placeholder="Enter city/municipality/town" required>
                        
                    </div>
                    
                    <div class="address-field">
                        <label>Full Address</label>
                        <input type="text" name="pickup_address" placeholder="Enter full address" required>
                    </div>
                </div>

                
                
                <div class="address-section">
                    <div class="address-header">
                        <img class="locationLogo" src="../images/location.png" alt="Delivery icon">
                        <h4>Deliver to</h4>
                    </div>
                    
                    <div class="address-field">
                        <label>City/Municipality/Town</label>
                        <input type="text" name="delivery_city" placeholder="Enter city/municipality/town" required>

                    </div>
                    
                    <div class="address-field">
                        <label>Full Address</label>
                        <input type="text" name="delivery_address" placeholder="Enter full address" required>


                    </div>
                </div>
                
                <div class="date-group">
                    <div class="date-header">
                        <img src="../images/calendar_date-removebg-preview 1.png" alt="Calendar icon">
                        <h4>Pick-up Date</h4>
                    </div>
                    <input type="date" name="pickup_date" required>

                    
                    <div class="date-header">
                        <img src="../images/calendar_date-removebg-preview 1.png" alt="Calendar icon">
                        <h4>Estimated Cargo Arrival Date</h4>
                    </div>
                    <input type="date" name="estimated_arrival_date" required>
                </div>
                
                <div class="button-group">
                     <button class="back-btn" type="button" onclick="window.location.href='index.php'">Back</button>
                      <button class="proceed-btn" type="submit">Proceed</button>
                </div>
            </section>
        </div>
        </form>
        
    </main>

        <script>
        function toggleMenu() {
            const menu = document.getElementById('nav-menu');
            menu.classList.toggle('show');
        }
    </script>

     <script>
        // Product management functionality
        let products = [];
        
        function addProduct() {
            const productInput = document.getElementById('productInput');
            const productName = productInput.value.trim();
            
            if (productName) {
                products.push(productName);
                renderProductList();
                productInput.value = ''; // Clear the input
                productInput.focus(); // Focus back on the input
            }
        }
        
        function removeProduct(index) {
            products.splice(index, 1);
            renderProductList();
        }
            // Sync products[] array to hidden input field
    function updateHiddenProductField() {
        const hiddenInput = document.getElementById('productsHidden');
        hiddenInput.value = products.join(", ");
    }

    // Update before form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        updateHiddenProductField();
    });
        function renderProductList() {
            const productList = document.getElementById('productList');
            productList.innerHTML = '';
            
            if (products.length === 0) {
                return;
            }
            
            products.forEach((product, index) => {
                const productItem = document.createElement('div');
                productItem.className = 'product-item';
                productItem.innerHTML = `
                    <span>${product}</span>
                    <button class="remove-product" onclick="removeProduct(${index})">×</button>
                `;
                productList.appendChild(productItem);
            });
        }
        
        // Allow adding product by pressing Enter key
        document.getElementById('productInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                addProduct();
            }
        });
        
        // Your existing menu toggle function
        function toggleMenu() {
            const menu = document.getElementById('nav-menu');
            menu.classList.toggle('show');
        }
    </script>
</body>


</html>