<?php
$host = 'localhost';
$db   = 'wmr_db';
$user = 'root'; 
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 14;

$sql = "SELECT * FROM users WHERE id = $id";

$result = $conn->query($sql);

if ($result) {
    if ($row = $result->fetch_assoc()) {
      echo json_encode($row);

      $id = $row['id'];
      $date = $row["created_at"];
      $name = $row['full_name'];
      $nickname = $row['nickname'];
      $residence = $row['residence'];
      $birthdate = $row['birthday'];
      $businessName = $row['business_name'];
      $email = $row['email'];
      $contactNumber = $row['phone_number'];
      $profilePicture = $row['profile_picture'];
    }
  } else {
    echo "Error running query: " . $conn->error;
  }
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
          <tr>
            <td><?= htmlspecialchars(string: $date) ?></td>
            <td><?= htmlspecialchars($name) ?></td>
            <td><?= htmlspecialchars(string: $nickname) ?></td>
            <td><?= htmlspecialchars(string: $residence) ?></td>
            <td><?= htmlspecialchars(string: $birthdate) ?></td>
            <td><?= htmlspecialchars(string: $businessName) ?></td>
            <td>&lt;<?= htmlspecialchars(string: $email) ?>&gt;</td>
            <td><?= htmlspecialchars(string: $contactNumber) ?></td>
            <td>
              <div class="profile-pic-placeholder"><?= htmlspecialchars(string: $profilePicture) ?></div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <script src="clients.js"></script>
</body>
</html>

