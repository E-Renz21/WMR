
<?php
$host = 'localhost';
$db   = 'wmr_db';
$user = 'root'; 
$pass = '';

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
<<<<<<< HEAD
        <tr>
          <td>1</td>
          <td>May 19, 2025</td>
          <td>Earl Lawrence Obguia</td>
          <td>Gins, Softdrinks, Beers, Beverages</td>
          <td>20 Tons</td>
          <td>56</td>
          <td>May 20, 2025</td>
          <td>Davao City</td>
          <td>Matina Crossing, Davao City, Davao Del Sur, Philippines</td>
          <td>Cagayan De Oro</td>
          <td>Barangay Dimaguiba, Cagayan De Oro, Philippines</td>
          <td>May 22, 2025</td>
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
</div>
=======
        <?php if ($result && $result->num_rows > 0): ?>
  <?php while($row = $modalresult_result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['id']) ?></td>
      <td><?= htmlspecialchars($row['expected_arrival']) ?></td>
      <td><?= htmlspecialchars($row['driver_name']) ?></td>
      <td><?= htmlspecialchars($row['product_description']) ?></td>
      <td><?= htmlspecialchars($row['estimated_weight']) ?></td>
      <td><?= htmlspecialchars($row['estimated_boxes']) ?></td> 
      <td class="address-cell">
        <div class="address-actions">
          <button class="more-btn"  >⋮</button>
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
  <div id="deliveryDetailsModal" class="modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>
      <h3>Delivery Details</h3>
      <div class="details-container">
        <div class="detail-row">
          <span class="detail-label">Date:</span>
          <span class="detail-value"></span>
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
          <span class="detail-lab el">Expected Date:</span>
          <span class="detail-value">May 22, 2025</span>
        </div>
      </div>
    </div>
  </div>
>>>>>>> c4a64a9f40dec75edd66c5dd267cb1f4db3353f3
