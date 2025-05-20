<?php
$host = 'localhost';
$db   = 'wmr_db';
$user = 'root'; 
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get all delivery requests
$sql = "SELECT * FROM delivery_requests ORDER BY id DESC";
$result = $conn->query($sql);
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
          <th>Pickup Date</th>
          <th>Pickup Location</th>
          <th>Pickup Address</th>
          <th>Deliver To</th>
          <th>Delivery Address</th>
          <th>Expected Date</th>
          <th>Contact No.</th>
          <th>Actions</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo htmlspecialchars($row['pickup_date']); ?></td>
              <td><?php echo isset($row['client_name']) ? htmlspecialchars($row['client_name']) : ''; ?></td>
              <td><?php echo htmlspecialchars($row['product_description']); ?></td>
              <td>
                <?php
                  $weight = $row['estimated_weight'];
                  echo ($weight >= 1000) ? ($weight/1000 . ' Tons') : ($weight . ' Kg');
                ?>
              </td>
              <td><?php echo htmlspecialchars($row['estimated_boxes']); ?></td>
              <td><?php echo htmlspecialchars($row['pickup_date']); ?></td>
              <td><?php echo htmlspecialchars($row['pickup_city']); ?></td>
              <td><?php echo htmlspecialchars($row['pickup_address']); ?></td>
              <td><?php echo htmlspecialchars($row['delivery_city']); ?></td>
              <td><?php echo htmlspecialchars($row['delivery_address']); ?></td>
              <td><?php echo htmlspecialchars($row['estimated_arrival_date']); ?></td>
              <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
              <td class="actions-cell">
                <div class="action-buttons">
                  <button class="edit-btn" onclick="showPanel('editstatus')">Edit Status</button>
                </div>
              </td>
              <td class="actions-cell">
                <div class="action-buttons">
                  <button class="status-btn status-for-pickup">
                    <?php echo isset($row['status']) ? htmlspecialchars($row['status']) : 'Pending'; ?>
                  </button>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="15">No delivery requests found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
