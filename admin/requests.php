<?php
$host = 'localhost';
$db   = 'wmr_db';
$user = 'root'; 
$pass = '';

$id = 1;

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get all users, not just one
$sql = "SELECT * FROM delivery_requests ORDER BY id DESC";
$result = $conn->query($sql);

$modal_sql = "SELECT * FROM delivery_requests WHERE id = $id";
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
        <?php if ($result && $result->num_rows > 0): ?>
  <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['id']) ?></td>
      <td><?= htmlspecialchars($row['expected_arrival']) ?></td>
      <td><?= htmlspecialchars($row['driver_name']) ?></td>
      <td><?= htmlspecialchars($row['product_description']) ?></td>
      <td><?= htmlspecialchars($row['estimated_weight']) ?></td>
      <td><?= htmlspecialchars($row['estimated_boxes']) ?></td> 
      <td class="address-cell">
        <div class="address-actions">
          <button class="more-btn" data-id="<?= $row['id'] ?>">⋮</button>
        </div>
      </td>
      <td><?= htmlspecialchars($row['contact_number']) ?></td>
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
  <?php endwhile; ?>
<?php else: ?>
  <tr><td colspan="10">No delivery requests found.</td></tr>
<?php endif; ?>
      </tbody>
    </table>
  </div>
  
  <!-- Delivery Details Modal -->
  <!-- Delivery Details Modal -->
<div id="deliveryDetailsModal" class="modal">
  <div class="modal-content">
    <span class="close-btn">&times;</span>
    <h3>Delivery Details</h3>
    <div class="details-container">
      <div class="detail-row">
        <span class="detail-label">Date:</span>
        <span class="detail-value" id="expected_arrival"></span>
      </div>git 
      <div class="detail-row">
        <span class="detail-label">Pickup Address:</span>
        <span class="detail-value" id="modal-pickup-address"></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Full Address:</span>
        <span class="detail-value" id="modal-pickup-full"></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Deliver To:</span>
        <span class="detail-value" id="modal-destination"></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Full Address:</span>
        <span class="detail-value" id="modal-destination-full"></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Expected Date:</span>
        <span class="detail-value" id="modal-expected-date"></span>
      </div>
    </div>
  </div>
</div>