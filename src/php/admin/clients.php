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

<div class="content-container">
  <h1>Client List</h1>
  <div class="clients-table-container">
    <table class="clients-table">
      <thead>
        <tr>
          <th>Date</th>
          <th>Name</th>
          <th>Nickname</th>
          <th>Residence</th>
          <th>Birthdate</th>
          <th>Company/Business</th>
          <th>Email</th>
          <th>Contact No.</th>
          <th>Profile Picture</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['created_at']) ?></td>
              <td><?= htmlspecialchars($row['full_name']) ?></td>
              <td><?= htmlspecialchars($row['nickname']) ?></td>
              <td><?= htmlspecialchars($row['residence']) ?></td>
              <td><?= htmlspecialchars($row['birthday']) ?></td>
              <td><?= htmlspecialchars($row['business_name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['phone_number']) ?></td>
              <td>
                <div class="profile-pic-placeholder">
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
            <td colspan="9">No users found.</td>
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