<?php
$host = 'localhost';
$db   = 'wmr_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

$sql = "SELECT * FROM contact_messages WHERE id = $id";

$result = $conn->query($sql);

if ($result) {
    if ($row = $result->fetch_assoc()) {
      $id = $row["id"];
      echo json_encode($row);
    }
  } else {
    echo "Error running query: " . $conn->error;
  }
?>

<div class="delivery-requests">
  <h2>Delivery Requests & Status</h2>
  
  <div class="requests-table-container">
    <table class="requests-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Date</th>
          <th>Name</th>
          <th>Products</th>
          <th>Estimated Kg/Tons</th>
          <th>Boxes</th>
          <th>Delivery Date & Address</th>
          <th>Contact No.</th>
          <th>Actions</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>May 19, 2025</td>
          <td>Earl Lawrence Obguia</td>
          <td>Gins, Softdrinks, Beers, Beverages</td>
          <td>20 Tons</td>
          <td>56</td> 
          <td class="address-cell">
            <div class="address-actions">
              <button class="more-btn">⋮</button>
            </div>
          </td>
          <td>09202313282</td>
          <td class="actions-cell">
            <div class="action-buttons">
              <button class="edit-btn" onclick="showPanel('editstatus')">Edit Status</button>
            </div>
          </td>
          <td class="actions-cell">
            <div class="action-buttons">
              <button class="status-btn status-for-pickup">Pending</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  
  <!-- Delivery Details Modal -->
  <div id="deliveryDetailsModal" class="modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>
      <h3>Delivery Details</h3>
      <div class="details-container">
        <div class="detail-row">
          <span class="detail-label">Date:</span>
          <span class="detail-value">May 20, 2025</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Pickup Address:</span>
          <span class="detail-value">Davao City</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Full Address:</span>
          <span class="detail-value">Matina Crossing, Davao City, Davao Del Sur, Philippines</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Deliver To:</span>
          <span class="detail-value">Cagayan De Oro</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Full Address:</span>
          <span class="detail-value">Barangay Dimaguiba, Cagayan De Oro, Philippines</span>
        </div>
        <div class="detail-row">
          <span class="detail-label">Expected Date:</span>
          <span class="detail-value">May 22, 2025</span>
        </div>
      </div>
    </div>
  </div>