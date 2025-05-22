<?php
$host = 'localhost';
$db   = 'wmr_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
SELECT 
  dr.id,
  dr.product_description,
  dr.estimated_boxes,
  dr.estimated_weight,
  dr.pickup_address,
  dr.delivery_address,
  dr.pickup_date,
  dr.estimated_arrival_date,
  dr.created_at,
  dr.contact_number,
  u.full_name AS user_name,
  ds.driver_name,
  ds.driver_assistant,
  ds.plate_number,
  ds.driver_contact_number,
  ds.current_location,
  ds.departure_date,
  ds.departure_time,
  ds.arrival_date,
  ds.arrival_time,
  ds.expected_arrival,
  ds.admin_note AS admin_notes,
  ds.status
FROM 
  delivery_requests dr
LEFT JOIN 
  users u ON dr.created_by = u.id
LEFT JOIN 
  delivery_status ds ON dr.id = ds.delivery_request_id
ORDER BY 
  dr.id DESC
";

$result = $conn->query($sql);

// Debugging: check if SQL query succeeded
if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>
<div class="delivery-requests-container">
  <h1 class="delivery-requests-title">Delivery Requests & Status</h1>
  <div class="delivery-requests-table-wrapper">
    <table class="delivery-requests-table">
      <thead>
        <tr>
          <th class="request-id">ID</th>
          <th class="request-date">Requested Date</th>
          <th class="request-name">Name</th>
          <th class="request-products">Products</th>
          <th class="request-weight">Estimated Kg/Tons</th>
          <th class="request-boxes">Boxes</th>
          <th class="request-logistics">Logistics request</th>
          <th class="request-contact">Contact No.</th>
          <th class="request-status">Status</th>
          <th class="request-action">Action</th>

        </tr>
      </thead>
      <tbody>
  <?php if ($result && $result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
  <tr class="delivery-request-row">
    <td class="request-id"><?= htmlspecialchars($row['id']) ?></td>
    <td class="request-date"><?= htmlspecialchars($row['created_at']) ?></td>
    <td class="request-name"><?= htmlspecialchars($row['user_name']) ?></td>
    <td class="request-products"><?= htmlspecialchars($row['product_description']) ?></td>
    <td class="request-weight"><?= htmlspecialchars($row['estimated_weight']) ?></td>
    <td class="request-boxes"><?= htmlspecialchars($row['estimated_boxes']) ?></td>
    <td class="request-logistics">
      <button 
        type="button" 
        class="toggle-details-btn" 
        onclick="showDetailsModal(
          '<?= htmlspecialchars($row['pickup_date']) ?>',
          '<?= htmlspecialchars($row['pickup_address']) ?>',
          '<?= htmlspecialchars($row['delivery_address']) ?>',
          '<?= htmlspecialchars($row['estimated_arrival_date']) ?>'
        )"
        title="Show Logistics Details"
      >⋮</button>

    </td>
    <td class="request-contact"><?= htmlspecialchars($row['contact_number']) ?></td>
    <td class="request-status">
      <?php
        $status = strtolower($row['status']);
        $class = match($status) {
          'arrived'     => 'delivery-status-arrived',
          'delayed'     => 'delivery-status-delayed',
          'in transit'  => 'delivery-status-in-transit',
          'for pickup'  => 'delivery-status-for-pickup',
          default       => 'delivery-status-pending',
        };
      ?>
      
      <br><span class="delivery-status-tag <?= $class ?>"><?= ucfirst($status) ?></span>
    </td>
      <td class="request-action">
    <a href="editstatus.php?id=<?= $row['id'] ?>" class="edit-status-btn">Edit</a>
    <button 
  type="button" 
  class="edit-status-btn view-status-btn"
  onclick='showStatusModal(
    <?= json_encode([
      'driver_name' => $row['driver_name'],
      'plate_number' => $row['plate_number'],
      'current_location' => $row['current_location'],
      'departure_date' => $row['departure_date'],
      'departure_time' => $row['departure_time'],
      'arrival_date' => $row['arrival_date'],
      'arrival_time' => $row['arrival_time'],
      'driver_assistant' => $row['driver_assistant'],
      'contact_number' => $row['driver_contact_number'],
      'status' => $row['status'],
      'expected_arrival' => $row['expected_arrival'],
      'admin_note' => $row['admin_notes'],
    ]) ?>)'
>View</button>

    </td>
    
  </tr>
        


  <?php endwhile; ?>

  <?php else: ?>
    <tr><td colspan="9" class="delivery-requests-empty">No delivery requests found.</td></tr>
  <?php endif; ?>


</tbody>  


    </table>
  </div>
</div>
    <div id="detailsModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close-btn" onclick="closeDetailsModal()">&times;</span>
    <h2>Logistics Details</h2>
    <div id="modalDetailsBody">
      <!-- Details will be injected here -->
    </div>
  </div>
</div>
<div id="statusModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close-btn" onclick="closeStatusModal()">&times;</span>
    <h2>Delivery Status Details</h2>
    <div id="statusModalBody" class="modal-body">
      <!-- Injected details -->
    </div>
  </div>
</div>




<?php $conn->close(); ?>