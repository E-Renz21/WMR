<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in.']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit();
}

$conn = new mysqli("localhost", "root", "", "wmr_db");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB connection failed.']);
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("UPDATE users SET full_name=?, nickname=?, residence=?, birthday=?, business_name=?, type_of_business=?, email=?, phone_number=? WHERE id=?");
$stmt->bind_param(
    "ssssssssi",
    $data['name'],
    $data['nickname'],
    $data['residencefulladdress'],
    $data['birthdate'],
    $data['companybusinessname'],
    $data['typeofbusiness'],
    $data['email'],
    $data['phonenumber'],
    $user_id
);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Update failed.']);
}

$stmt->close();
$conn->close();
?>
