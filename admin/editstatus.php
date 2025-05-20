<?php
$host = 'localhost';
$db   = 'wmr_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

$sql = "SELECT * FROM delivery_requests WHERE id = $id";

$result = $conn->query($sql);

if ($result) {
    if ($row = $result->fetch_assoc()) {
      $driverName = $row['driver_name'];
      $plateNumber = $row['plate_number'];
      $currentLocation = $row['current_location'];
      $departureDate = $row['departure_date'];
      $departureTime = $row['departure_time'];
      $driverAssistant = $row['driver_assistant'];
      $contactNumber = $row['contact_number'];
      $status = $row['status'];
      $estimatedArrivalDate = $row['estimated_arrival_date'];
    }
  } else {
    echo "Error running query: " . $conn->error;
  }
?>

<style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    body, html {
      height: 100%;
    }

    body {
      background-image: url('background-truck.png');
      background-size: cover;
      background-position: center;
      display: flex;
      flex-direction: column;
      color: #000;
      padding-top: 76px; /* Space for fixed header */
    }

    /* Header styles */
    .header-wrapper {
      background: #ffffff;
      width: 100%;
      padding: 15px 0;
      border-bottom: 1px solid #e0e0e0;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1000;
    }

    .header {
      display: flex;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 30px;
    }

    .header img {
      height: 60px;
      margin-right: 15px;
    }

    .header h1 {
      font-size: 32px;
      font-weight: bold;
      color: #000;
      margin: 0;
    }

    /* Main content container */
    .content-container {
      background: white;
      border-radius: 10px;
      padding: 30px;
      margin: 20px auto;
      width: 90%;
      max-width: 800px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    h2 {
      font-size: 24px;
      margin-bottom: 20px;
      color: #333;
      border-bottom: 2px solid #f2f2f2;
      padding-bottom: 10px;
    }

    /* Form styles */
    .form-group {
      margin-bottom: 20px;
      display: flex;
      flex-wrap: wrap;
    }

    .form-row {
      display: flex;
      width: 100%;
      margin-bottom: 15px;
    }

    .form-col {
      flex: 1;
      padding: 0 10px;
    }

    .form-col:first-child {
      padding-left: 0;
    }

    .form-col:last-child {
      padding-right: 0;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      color: #555;
    }

    input[type="text"],
    input[type="date"],
    input[type="time"],
    select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 16px;
    }

    /* Status dropdown */
    .status-dropdown {
      position: relative;
      width: 100%;
    }

    .status-select {
      display: flex;
      align-items: center;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      cursor: pointer;
      background-color: #f9f9f9;
    }

    .status-icon {
      width: 20px;
      height: 20px;
      margin-right: 10px;
      background-color: #ffc107; /* Default in-transit color */
      border-radius: 50%;
    }

    .status-options {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      width: 100%;
      background: white;
      border: 1px solid #ddd;
      border-radius: 4px;
      z-index: 10;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .status-option {
      padding: 10px;
      display: flex;
      align-items: center;
      cursor: pointer;
    }

    .status-option:hover {
      background-color: #f5f5f5;
    }

    .status-option .status-icon {
      margin-right: 10px;
    }

    /* Button styles */
    .button-group {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
      padding-top: 20px;
      border-top: 1px solid #eee;
    }

    .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
      transition: background 0.3s;
    }

    .btn-back {
      background-color: #f5f5f5;
      color: #333;
    }

    .btn-back:hover {
      background-color: #e0e0e0;
    }

    .btn-edit {
      background-color: #2196F3;
      color: white;
    }

    .btn-edit:hover {
      background-color: #0b7dda;
    }

    .btn-save {
      background-color: #4CAF50;
      color: white;
    }

    .btn-save:hover {
      background-color: #45a049;
    }

    /* Status icon colors - UPDATED TO MATCH YOUR REQUEST */
.status-in-transit .status-icon {
  background-color: #2196F3; /* Blue */
}

.status-arrived .status-icon {
  background-color: #4CAF50; /* Green */
}

.status-for-pickup .status-icon {
  background-color: #FFC107; /* Yellow */
}

.status-delayed .status-icon {
  background-color: #F44336; /* Red */
}

.status-pending .status-icon {
  background-color: #9E9E9E; /* Gray */
}
  </style>
  <div class="header-wrapper">
    <div class="header">
      <img src="WMRLOGO.png" alt="WMR Logo" />
      <h1>ADMIN</h1>
    </div>
  </div>

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