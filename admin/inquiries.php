<?php
$host = 'localhost';
$db   = 'wmr_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 3;

$sql = "SELECT * FROM contact_messages WHERE id = $id";

$result = $conn->query($sql);

if ($result) {
    if ($row = $result->fetch_assoc()) {
      $id = $row['id'];
      $date = $row["submitted_at"];
      $lastName = $row['last_name'];
      $firstName = $row['first_name'];
      $phoneNumber = $row['phone_number'];
      $email = $row['email'];
      $message = $row['message'];
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
  <title>Client Inquiries</title>
  <link rel="stylesheet" href="inquiries.css">
</head>
<body>
  <div class="header-wrapper">
    <div class="header">
      <img src="WMRLOGO.png" alt="WMR Logo" />
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
          <tr>
            <td><?= htmlspecialchars($date) ?></td>
            <td><?= htmlspecialchars($lastName) ?></td>
            <td><?= htmlspecialchars($firstName) ?></td>
            <td><?= htmlspecialchars($phoneNumber) ?></td>
            <td><?= htmlspecialchars($email) ?></td>
            <td><?= htmlspecialchars($message) ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <script src="inquiries.js"></script>
</body>
</html>