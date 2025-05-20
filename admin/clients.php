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
$sql = "SELECT * FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">  
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Lists</title>
  <link rel="stylesheet" href="clients.css">
</head>
<body>
  <div class="header-wrapper">
    <div class="header">
      <img src="WMRLOGO.png" alt="WMR Logo" />
      <h1>ADMIN</h1>
    </div>
  </div>

  <div class="content-container">
    <h1>Client Lists</h1>
    
    <div class="clients-table-container">
      <table class="clients-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Nickname</th>
            <th>Residence</th>
            <th>Birthdate</th>
            <th>Company/Business Name</th>
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
                    <?= htmlspecialchars($row['profile_picture']) ?>
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
