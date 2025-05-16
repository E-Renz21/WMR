<?php
session_start();
$conn = new mysqli("localhost", "root", "", "wmr_db");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $userId = $_SESSION['user_id'];
    $file = $_FILES['profile_picture'];
    $targetDir = "../uploads/";
    $filename = uniqid() . "_" . basename($file["name"]);
    $targetFile = $targetDir . $filename;

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        // Save filename in database
        $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
        $stmt->bind_param("si", $filename, $userId);
        if ($stmt->execute()) {
            $_SESSION['profile_picture'] = $filename;
            echo json_encode(['success' => true, 'filename' => $filename]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'File upload failed.']);
    }
}
$conn->close();
?>
