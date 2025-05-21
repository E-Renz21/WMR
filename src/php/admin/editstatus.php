<?php
$host = 'localhost';
$db   = 'wmr_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get ID from GET or POST
$id = isset($_GET['id']) ? (int)$_GET['id'] : (int)($_POST['id'] ?? 1);

// Save if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $driverName = $_POST['driver_name'];
    $plateNumber = $_POST['plate_number'];
    $currentLocation = $_POST['current_location'];
    $departureDate = $_POST['departure_date'];
    $departureTime = $_POST['departure_time'];
    $driverAssistant = $_POST['driver_assistant'];
    $contactNumber = $_POST['contact_number'];
    $status = $_POST['status'];
    $estimatedArrivalDate = $_POST['estimated_arrival_date'];

    $sqlUpdate = "UPDATE delivery_requests SET 
        driver_name = ?, 
        plate_number = ?, 
        current_location = ?, 
        departure_date = ?, 
        departure_time = ?, 
        driver_assistant = ?, 
        contact_number = ?, 
        status = ?, 
        estimated_arrival_date = ?
        WHERE id = ?";

    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("sssssssssi", 
        $driverName, $plateNumber, $currentLocation, 
        $departureDate, $departureTime, $driverAssistant, 
        $contactNumber, $status, $estimatedArrivalDate, $id);

    if ($stmt->execute()) {
        $message = "Saved successfully!";
    } else {
        $message = "Error saving data: " . $stmt->error;
    }

    $stmt->close();
}

// Load existing data
$sql = "SELECT * FROM delivery_requests WHERE id = $id";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $driverName = $row['driver_name'];
    $plateNumber = $row['plate_number'];
    $currentLocation = $row['current_location'];
    $departureDate = $row['departure_date'];
    $departureTime = $row['departure_time'];
    $driverAssistant = $row['driver_assistant'];
    $contactNumber = $row['contact_number'];
    $status = $row['status'];
    $estimatedArrivalDate = $row['estimated_arrival_date'];
} else {
    echo "Error loading data: " . $conn->error;
    exit;
}
?>

<header>
  <link rel="stylesheet" href="../../css/admincss/editstatus.css">
</header>

  <div class="content-container">
    <h2>Edit Delivery Status</h2>
    
    <div class="form-group">
      <div class="form-row">
        <div class="form-col">
          <label>Driver's Name</label>
          <input type="text" value="<?= htmlspecialchars($driverName) ?>" id="driver_name" name="driver_name">
        </div>
        <div class="form-col">
          <label>Plate Number</label>
          <input type="text" value="<?= htmlspecialchars($plateNumber) ?>" id="plate_number">
        </div>
      </div>
      
    <div class="form-row">
  <div class="form-col" style="max-width: 300px;">  <!-- Added max-width -->
    <label>Current Location</label>
    <input type="text" value="<?= htmlspecialchars($currentLocation) ?>" id="current_location">
  </div>
</div>
      
      <div class="form-row">
        <div class="form-col">
          <label>Departure Date</label>
          <input type="date" value="<?= htmlspecialchars($departureDate) ?>" id="departure_date">
        </div>
        <div class="form-col">
          <label>Departure Time</label>
          <input type="time" value="<?= htmlspecialchars($departureTime) ?>" id="departure_time">
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-col">
          <label>Arrival Date</label>
          <input type="date">
        </div>
        <div class="form-col">
          <label>Arrival Time</label>
          <input type="time">
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-col">
          <label>Drive Assistant</label>
          <input type="text" value="<?= htmlspecialchars($driverAssistant) ?>" id="driver_assistant">
        </div>
        <div class="form-col">
          <label>Driver/Assistant Contact Number</label>
          <input type="text" value="<?= htmlspecialchars($contactNumber) ?>" id="contact_number">
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-col">
          <label>Status</label>
          <div class="status-dropdown">
            <div class="status-select status-in-transit" id="status" onclick="toggleStatusDropdown()">
              <div class="status-icon"></div>
              <span><?= htmlspecialchars($status) ?></span>
            </div>
            <div class="status-options" id="statusOptions">
              <div class="status-option status-in-transit" onclick="selectStatus('In Transit', 'status-in-transit')">
                <div class="status-icon"></div>
                <span>In Transit</span>
              </div>
              <div class="status-option status-arrived" onclick="selectStatus('Arrived', 'status-arrived')">
                <div class="status-icon"></div>
                <span>Arrived</span>
              </div>
              <div class="status-option status-for-pickup" onclick="selectStatus('For Pick-up', 'status-for-pickup')">
                <div class="status-icon"></div>
                <span>For Pick-up</span>
              </div>
              <div class="status-option status-delayed" onclick="selectStatus('Delayed', 'status-delayed')">
                <div class="status-icon"></div>
                <span>Delayed</span>
              </div>
              <div class="status-option status-pending" onclick="selectStatus('Pending', 'status-pending')">
                <div class="status-icon"></div>
                <span>Pending</span>
              </div>
            </div>
          </div>
        </div>
        <div class="form-col">
          <label>Expected Date to Arrive</label>
          <input type="date" value="<?= htmlspecialchars($estimatedArrivalDate) ?>" id="estimated_arrival_date">
        </div>
      </div>
      
      <div class="form-row">
        <div class="form-col">
          <label>Note</label>
          <input type="text">
        </div>
      </div>
    </div>
    
    <div class="button-group">
      <button class="btn btn-back" onclick="showPanel('requests')">Back</button>
      <div>
        <button class="btn btn-edit">Edit</button>
        <button class="btn btn-save">Save</button>
      </div>
    </div>
  </div>