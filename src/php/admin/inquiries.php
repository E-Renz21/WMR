<?php
$host = 'localhost';
$db   = 'wmr_db';
$user = 'root'; 
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM contact_messages ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Inquiries</title>
  <link rel="stylesheet" href="../../css/inquiries.css">
    <link rel="stylesheet" href="../../css/indexAdmin.css">
</head>
<body>
  <div class="header-wrapper">
    <div class="header">
      <img src="../../images/logo.png" alt="WMR Logo" />
      <h1>ADMIN</h1>
    </div>
  </div>
  <div class="content-container">
    <h1>Client Inquiries</h1>
    <div class="inquiries-table-container">
      <table class="inquiries-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Contact No.</th>
            <th>Email</th>
            <th>Message</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['submitted_at']) ?></td>
                <td><?= htmlspecialchars($row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['first_name']) ?></td>
                <td><?= htmlspecialchars($row['phone_number']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="6">No inquiries found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <script src="inquiries.js"></script>
</body>
</html>
<?php $conn->close(); ?>