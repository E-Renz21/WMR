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

<div class="content-container">
  <h1>Delivery Requests & Status</h1>
  <div class="clients-table-container">
    <table class="clients-table">
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
              <td><?= htmlspecialchars($row['pickup_date']) ?></td>
              <td><?= htmlspecialchars($row['pickup_city']) ?></td>
              <td><?= htmlspecialchars($row['pickup_address']) ?></td>
              <td><?= htmlspecialchars($row['delivery_city']) ?></td>
              <td><?= htmlspecialchars($row['delivery_address']) ?></td>
              <td><?= htmlspecialchars($row['expected_arrival']) ?></td>
              <td><?= htmlspecialchars($row['contact_number']) ?></td>
              <td>
                <?php
                  $status = strtolower($row['status']);
                  $class = match($status) {
                    'arrived'     => 'status-arrived',
                    'delayed'     => 'status-delayed',
                    'in transit'  => 'status-in-transit',
                    'for pickup'  => 'status-for-pickup',
                    default       => 'status-pending',
                  };
                ?>
                <span class="status-tag <?= $class ?>"><?= ucfirst($status) ?></span>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="14">No delivery requests found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>

<?php $conn->close(); ?>