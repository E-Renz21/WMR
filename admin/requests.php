
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
      $id = $row["id"];
    }
  } else {
    echo "Error running query: " . $conn->error;
  }
?>

<div class="delivery-requests">
  <h2>Delivery Requests & Status</h2>
  
  <div class="requests-table-container">
    <table class="requests-table">
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
          <th>Actions</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>May 19, 2025</td>
          <td>Earl Lawrence Obguia</td>
          <td>Gins, Softdrinks, Beers, Beverages</td>
          <td>20 Tons</td>
          <td>56</td>
          <td>May 20, 2025</td>
          <td>Davao City</td>
          <td>Matina Crossing, Davao City, Davao Del Sur, Philippines</td>
          <td>Cagayan De Oro</td>
          <td>Barangay Dimaguiba, Cagayan De Oro, Philippines</td>
          <td>May 22, 2025</td>
          <td>09202313282</td>
          <td class="actions-cell">
            <div class="action-buttons">
              <button class="edit-btn" onclick="showPanel('editstatus')">Edit Status</button>
            </div>
          </td>
          <td class="actions-cell">
            <div class="action-buttons">
              <button class="status-btn status-for-pickup">Pending</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>