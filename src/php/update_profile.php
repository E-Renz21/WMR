<?php
session_start();
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "wmr";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'Not logged in']));
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die(json_encode(['success' => false, 'message' => 'Invalid data format']));
}

try {
    // Prepare the update statement
    $stmt = $conn->prepare("UPDATE users SET 
        name = ?,
        nickname = ?,
        residence = ?,
        birthdate = ?,
        company = ?,
        businesstype = ?,
        email = ?,
        phone = ?
        WHERE id = ?");
    
    // Bind parameters
    $stmt->bind_param("ssssssssi",
        $data['name'] ?? '',
        $data['nickname'] ?? '',
        $data['residencefulladdress'] ?? '',
        $data['birthdate'] ?? null,
        $data['companybusinessname'] ?? '',
        $data['typeofbusiness'] ?? '',
        $data['email'] ?? '',
        $data['phonenumber'] ?? '',
        $data['user_id']
    );
    
    // Execute and respond
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed']);
    }
    
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>