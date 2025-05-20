<?php
$host = 'localhost';
$db   = 'wmr_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

$sql = "SELECT * FROM contact_messages WHERE id = $id";

$result = $conn->query($sql);

if ($result) {
    if ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $date = $row["date"];
      $lastName = $row['last_name'];
      $firstName = $row['first_name'];
      $phoneNumber = $row['phone_number'];
      $email = $row['email'];
      $message = $row['message'];

      echo json_encode($row);
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
            <td><?= htmlspecialchars($date) ?></td>
            <td><?= htmlspecialchars($firstName) ?></td>
            <td>Brest</td>
            <td>Boys' Grandma Bowlake Trail (BRL, District City)</td>
            <td>August 8, 2004</td>
            <td>Ex Price</td>
            <td>&lt;extrionale@moul.com&gt;</td>
            <td>09800393552</td>
            <td>
              <div class="profile-pic-placeholder"></div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <script src="clients.js"></script>
</body>
</html>

