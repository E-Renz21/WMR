<?php
$host = 'localhost';
$db   = 'wmr_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : (int)($_POST['id'] ?? 0);
$message = '';

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $driverName = $_POST['driver_name'];
    $plateNumber = $_POST['plate_number'];
    $currentLocation = trim($_POST['current_location']) !== '' ? $_POST['current_location'] : null;
    $departureDate = $_POST['departure_date'];
    $departureTime = $_POST['departure_time'];
    $driverAssistant = $_POST['driver_assistant'];
    $contactNumber = $_POST['contact_number'];
    $status = $_POST['status'];
    $estimatedArrivalDate = $_POST['estimated_arrival_date'];
    $arrivalDate = $_POST['arrival_date'];
    $arrivalTime = $_POST['arrival_time'];
    $adminNote = $_POST['admin_note'];

    // Check if a status entry already exists
    $checkSql = "SELECT id FROM delivery_status WHERE delivery_request_id = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $id);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        // Update existing
        $sqlUpdate = "UPDATE delivery_status SET 
            driver_name = ?, 
            plate_number = ?, 
            current_location = ?, 
            departure_date = ?, 
            departure_time = ?, 
            driver_assistant = ?, 
            driver_contact_number = ?, 
            status = ?, 
            expected_arrival = ?, 
            arrival_date = ?, 
            arrival_time = ?, 
            admin_note = ?
        WHERE delivery_request_id = ?";


        $stmt = $conn->prepare($sqlUpdate);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}


        // cast NULLs explicitly
        $currentLocation = $currentLocation ?? null;

        $stmt->bind_param("ssssssssssssi", 
    $driverName, $plateNumber, $currentLocation,
    $departureDate, $departureTime, $driverAssistant,
    $contactNumber, $status, $estimatedArrivalDate,
    $arrivalDate, $arrivalTime, $adminNote, $id
);



    } else {
        // Insert new
        $sqlInsert = "INSERT INTO delivery_status 
            (delivery_request_id, driver_name, plate_number, current_location, 
             departure_date, departure_time, driver_assistant, driver_contact_number, 
             status, expected_arrival, arrival_date, arrival_time, admin_note) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sqlInsert);
        $stmt->bind_param("issssssssssss", 
            $id, $driverName, $plateNumber, $currentLocation,
            $departureDate, $departureTime, $driverAssistant,
            $contactNumber, $status, $estimatedArrivalDate,
            $arrivalDate, $arrivalTime, $adminNote
        );
    }

if ($stmt->execute()) {
    header("Location: index.php?success=1");
    exit;
}
 else {
        $message = "Error saving data: " . $stmt->error;
    }

    $stmt->close();
    $checkStmt->close();
}

// Load existing data if available
$sql = "SELECT * FROM delivery_status WHERE delivery_request_id = $id";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $driverName = $row['driver_name'];
    $plateNumber = $row['plate_number'];
    $currentLocation = $row['current_location'];
    $departureDate = $row['departure_date'];
    $departureTime = $row['departure_time'];
    $driverAssistant = $row['driver_assistant'];
    $contactNumber = $row['driver_contact_number'];
    $status = $row['status'];
    $estimatedArrivalDate = $row['expected_arrival'];
    $arrivalDate = $row['arrival_date'];
    $arrivalTime = $row['arrival_time'];
    $adminNote = $row['admin_note'];
} else {
    // Default values
    $driverName = $plateNumber = $currentLocation = $departureDate = $departureTime = '';
    $driverAssistant = $contactNumber = $status = $estimatedArrivalDate = '';
    $arrivalDate = $arrivalTime = $adminNote = '';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Delivery Status</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/admincss/editstatus.css">
    <link rel="stylesheet" href="../../css/header.css">
</head>
<body class="edit-status-page">
    <?php include('header.php'); ?>
    
    <div class="status-edit-container">
        <h2 class="status-edit-title">Edit Delivery Status</h2>

        <?php if (!empty($message)): ?>
            <p class="status-form-message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" class="status-edit-form">
            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="form-section">
                <div class="form-row">
                    <div class="form-group">
                        <label>Driver's Name</label>
                        <input type="text" name="driver_name" value="<?= htmlspecialchars($driverName) ?>">
                    </div>
                    <div class="form-group">
                        <label>Plate Number</label>
                        <input type="text" name="plate_number" value="<?= htmlspecialchars($plateNumber) ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Current Location</label>
                        <input type="text" name="current_location" value="<?= htmlspecialchars($currentLocation) ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Departure Date</label>
                        <input type="date" name="departure_date" value="<?= htmlspecialchars($departureDate) ?>">
                    </div>
                    <div class="form-group">
                        <label>Departure Time</label>
                        <input type="time" name="departure_time" value="<?= htmlspecialchars($departureTime) ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Arrival Date</label>
                        <input type="date" name="arrival_date" value="<?= htmlspecialchars($arrivalDate) ?>">
                    </div>
                    <div class="form-group">
                        <label>Arrival Time</label>
                        <input type="time" name="arrival_time" value="<?= htmlspecialchars($arrivalTime) ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Driver Assistant</label>
                        <input type="text" name="driver_assistant" value="<?= htmlspecialchars($driverAssistant) ?>">
                    </div>
                    <div class="form-group">
                        <label>Contact Number</label>
                        <input type="text" name="contact_number" value="<?= htmlspecialchars($contactNumber) ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option <?= $status === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option <?= $status === 'In Transit' ? 'selected' : '' ?>>In Transit</option>
                            <option <?= $status === 'Arrived' ? 'selected' : '' ?>>Arrived</option>
                            <option <?= $status === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Expected Arrival Date</label>
                        <input type="date" name="estimated_arrival_date" value="<?= htmlspecialchars($estimatedArrivalDate) ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full-width">
                        <label>Admin Note</label>
                        <textarea name="admin_note"><?= htmlspecialchars($adminNote) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn btn-back">Back</a>
                <button  type="submit" class="btn btn-save" >Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>

