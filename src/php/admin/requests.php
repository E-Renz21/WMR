<?php
$host = 'localhost';
$db   = 'wmr_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM delivery_requests ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Delivery Requests</title>
  <link rel="stylesheet" href="../../css/header.css"/>
  <link rel="stylesheet" href="../../css/admincss/requestsadmin.css"/>
</head>
<body>

<?php include('header.php'); ?>

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
          <th class="request-pickup-date">Pickup Date</th>
          <th class="request-pickup-location">Pickup Location</th>
          <th class="request-pickup-address">Pickup Address</th>
          <th class="request-delivery-to">Deliver To</th>
          <th class="request-delivery-address">Delivery Address</th>
          <th class="request-expected-date">Expected Date</th>
          <th class="request-contact">Contact No.</th>
          <th class="request-status">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr class="delivery-request-row">
              <td class="request-id"><?= htmlspecialchars($row['id']) ?></td>
              <td class="request-date"><?= htmlspecialchars($row['expected_arrival']) ?></td>
              <td class="request-name"><?= htmlspecialchars($row['driver_name']) ?></td>
              <td class="request-products"><?= htmlspecialchars($row['product_description']) ?></td>
              <td class="request-weight"><?= htmlspecialchars($row['estimated_weight']) ?></td>
              <td class="request-boxes"><?= htmlspecialchars($row['estimated_boxes']) ?></td>
              <td class="request-pickup-date"><?= htmlspecialchars($row['pickup_date']) ?></td>
              <td class="request-pickup-location"><?= htmlspecialchars($row['pickup_city']) ?></td>
              <td class="request-pickup-address"><?= htmlspecialchars($row['pickup_address']) ?></td>
              <td class="request-delivery-to"><?= htmlspecialchars($row['delivery_city']) ?></td>
              <td class="request-delivery-address"><?= htmlspecialchars($row['delivery_address']) ?></td>
              <td class="request-expected-date"><?= htmlspecialchars($row['expected_arrival']) ?></td>
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
                <span class="delivery-status-tag <?= $class ?>"><?= ucfirst($status) ?></span>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="14" class="delivery-requests-empty">No delivery requests found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>

<?php $conn->close(); ?>