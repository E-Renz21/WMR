<?php
$host = 'localhost';
$db   = 'wmr_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Client List</title>
  <link rel="stylesheet" href="../../css/header.css"/>
  <link rel="stylesheet" href="../../css/admincss/clients.css"/>
</head>
<body>

<?php include('header.php'); ?>

<div class="client-list-container">
  <h1 class="client-list-title">Client List</h1>
  <div class="client-list-table-wrapper">
    <table class="client-list-table">
      <thead>
        <tr>
          <th class="client-date">Date</th>
          <th class="client-name">Name</th>
          <th class="client-nickname">Nickname</th>
          <th class="client-residence">Residence</th>
          <th class="client-birthdate">Birthdate</th>
          <th class="client-business">Company/Business</th>
          <th class="client-email">Email</th>
          <th class="client-phone">Contact No.</th>
          <th class="client-avatar">Profile Picture</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="client-row">
              <td class="client-date"><?= htmlspecialchars($row['created_at']) ?></td>
              <td class="client-name"><?= htmlspecialchars($row['full_name']) ?></td>
              <td class="client-nickname"><?= htmlspecialchars($row['nickname']) ?></td>
              <td class="client-residence"><?= htmlspecialchars($row['residence']) ?></td>
              <td class="client-birthdate"><?= htmlspecialchars($row['birthday']) ?></td>
              <td class="client-business"><?= htmlspecialchars($row['business_name']) ?></td>
              <td class="client-email"><?= htmlspecialchars($row['email']) ?></td>
              <td class="client-phone"><?= htmlspecialchars($row['phone_number']) ?></td>
              <td class="client-avatar">
                <div class="client-avatar-img">
                  <?php if (!empty($row['profile_picture'])): ?>
                    <img src="../../uploads/<?= htmlspecialchars($row['profile_picture']) ?>" alt="Profile" width="40" height="40">
                  <?php else: ?>
                    <span>No image</span>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="9" class="client-list-empty">No users found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="clients.js"></script>
</body>
</html>

<?php $conn->close(); ?>