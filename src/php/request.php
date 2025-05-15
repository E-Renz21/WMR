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
        <div class="panel-wrapper">
            <section class="left-panel">
                <div class="request-header">
                    <h2>Request Delivery</h2>
                </div>
                
               <div class="product-section">
                    <h6>Products</h6>
                    <div class="product-container">
                        <input type="text" id="productInput" placeholder="Enter product name">
                        <button class="addProductBTN" onclick="addProduct()">+</button>
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
                        <input type="number" placeholder="Enter number of boxes">
                    </div>
                    
                    <div class="input-group">
                        <div class="weight-icon">
                            <img src="../images/Weight_Logo-removebg-preview 1.png" alt="">
                            <h4>Estimated Weight</h4>
                        </div>
                        <div class="weight-container">
                            <input type="number" placeholder="Enter weight">
                            <select>
                                <option value="kg">Kg</option>
                                <option value="tons">Tons</option>
                            </select>
                        </div>
                    </div>
                    <p>Minimum of 20 Tons or 18144 Kilograms</p>
                </div>
            </section>

            <section class="right-panel">
                <div class="address-section">
                    <div class="address-header">
                        <img class="pickupLogo" src="../images/PICK UP 1.png" alt="Pickup icon">
                        <h4>Pick-up Address</h4>
                    </div>
                    
                    <div class="address-field">
                        <label>City/Municipality/Town</label>
                        <input type="text" placeholder="Enter city/municipality/town">
                    </div>
                    
                    <div class="address-field">
                        <label>Full Address</label>
                        <input type="text" placeholder="Enter full address">
                    </div>
                </div>
                
                <div class="address-section">
                    <div class="address-header">
                        <img class="locationLogo" src="../images/location.png" alt="Delivery icon">
                        <h4>Deliver to</h4>
                    </div>
                    
                    <div class="address-field">
                        <label>City/Municipality/Town</label>
                        <input type="text" placeholder="Enter city/municipality/town">
                    </div>
                    
                    <div class="address-field">
                        <label>Full Address</label>
                        <input type="text" placeholder="Enter full address">
                    </div>
                </div>
                
                <div class="date-group">
                    <div class="date-header">
                        <img src="../images/calendar_date-removebg-preview 1.png" alt="Calendar icon">
                        <h4>Pick-up Date</h4>
                    </div>
                    <input type="date">
                    
                    <div class="date-header">
                        <img src="../images/calendar_date-removebg-preview 1.png" alt="Calendar icon">
                        <h4>Estimated Cargo Arrival Date</h4>
                    </div>
                    <input type="date">
                </div>
                
                <div class="button-group">
                    <button class="back-btn" onclick="window.location.href='index.php'">Back</button>
                    <button class="proceed-btn">Proceed</button>
                </div>
            </section>
        </div>
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