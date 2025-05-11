<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Delivery</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/request.css">



    

</head>
<body>

    <?php include('header.php'); ?> <!-- Includes your nav and logo -->

    <section class="hero">
        <div class="hero-background"></div>
        <div class="form-container">
            <h2>Request Delivery</h2>
            <form>
                <div class="form-row">
                    <div class="form-group">
                        <label>Type of Products</label>
                        <select>
                            <option>Organic</option>
                            <option>Non Organic</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Birthdate</label>
                        <input type="date" required>
                    </div>
                </div>
                <div class="button-group">
                    <button type="button" onclick="window.history.back()">Back</button>
                    <button type="submit">Create an Account</button>
                </div>
            </form>
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
