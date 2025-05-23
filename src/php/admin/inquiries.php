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
          <th class="inquiry-date">Date of Request</th>
          <th class="inquiry-lastname">Last Name</th>
          <th class="inquiry-firstname">First Name</th>
          <th class="inquiry-phone">Contact No.</th>
          <th class="inquiry-email">Email</th>
          <th class="inquiry-message">Message</th>
          <th class="inquiry-actions">Action</th>
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
              <td class="inquiry-actions">
                <form method="POST" action="delete_inquiry.php" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                  <button onclick="window.location.href='index.php'" type="submit" class="delete-btn">Delete</button>
                </form>
              </td>
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
<script src="delete_inquiry.php">
  
</script>
</body>
</html>
<?php $conn->close(); ?>