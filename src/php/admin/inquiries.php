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

<body>

<div class="inquiries-container">
  <h1 class="inquiries-title">Client Inquiries</h1>
  <div class="inquiries-table-wrapper">
    <table class="inquiries-data-table">
      <thead>
        <tr>
          <th class="inquiry-date">Date</th>
          <th class="inquiry-lastname">Last Name</th>
          <th class="inquiry-firstname">First Name</th>
          <th class="inquiry-phone">Contact No.</th>
          <th class="inquiry-email">Email</th>
          <th class="inquiry-message">Message</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="inquiry-row">
              <td class="inquiry-date"><?= htmlspecialchars($row['submitted_at']) ?></td>
              <td class="inquiry-lastname"><?= htmlspecialchars($row['last_name']) ?></td>
              <td class="inquiry-firstname"><?= htmlspecialchars($row['first_name']) ?></td>
              <td class="inquiry-phone"><?= htmlspecialchars($row['phone_number']) ?></td>
              <td class="inquiry-email"><?= htmlspecialchars($row['email']) ?></td>
              <td class="inquiry-message"><?= nl2br(htmlspecialchars($row['message'])) ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="inquiries-empty">No inquiries found.</td>
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