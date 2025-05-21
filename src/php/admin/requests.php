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
          <th class="request-date">Date</th>
          <th class="request-name">Name</th>
          <th class="request-products">Products</th>
          <th class="request-weight">Estimated Kg/Tons</th>
          <th class="request-boxes">Boxes</th>
          <th class="request-logistics">Logistics request</th>
          <th class="request-contact">Contact No.</th>
          <th class="request-status">Status</th>
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
      <button type="button" class="toggle-details-btn" onclick="toggleDetails(this)">⋮</button>

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
  </tr>

  <!-- Hidden Row for Logistics Details -->
  <tr class="details-row" style="display: none;">
    <td colspan="9">
      <div class="details-content">
        <strong>Pickup Date:</strong> <?= htmlspecialchars($row['pickup_date']) ?><br>
        <strong>Pickup Address:</strong> <?= htmlspecialchars($row['pickup_address']) ?><br>
        <strong>Delivery Address:</strong> <?= htmlspecialchars($row['delivery_address']) ?><br>
        <strong>Expected Arrival:</strong> <?= htmlspecialchars($row['expected_arrival']) ?>
      </div>
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
<script>
function toggleDetails(button) {
  const row = button.closest("tr");
  const nextRow = row.nextElementSibling;
  if (nextRow && nextRow.classList.contains("details-row")) {
    nextRow.style.display = nextRow.style.display === "none" ? "table-row" : "none";
  }
}

function toggleDetails(button) {
  console.log("Button clicked"); // Add this line
  const row = button.closest("tr");
  const nextRow = row.nextElementSibling;
  if (nextRow && nextRow.classList.contains("details-row")) {
    nextRow.style.display = nextRow.style.display === "none" ? "table-row" : "none";
  }
}

</script>




<?php $conn->close(); ?>