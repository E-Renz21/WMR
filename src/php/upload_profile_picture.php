<?php
session_start();

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

$response = ['success' => false, 'message' => ''];

// Check if file was uploaded
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/';
    
    // Create uploads directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Get file info
    $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
    $fileName = $_FILES['profile_picture']['name'];
    $fileSize = $_FILES['profile_picture']['size'];
    $fileType = $_FILES['profile_picture']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    
    // Sanitize file name
    $newFileName = 'profile_' . $_SESSION['user_id'] . '_' . md5(time()) . '.' . $fileExtension;
    
    // Check if the file is an image
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (in_array($fileType, $allowedTypes)) {
        // Check file size (max 2MB)
        if ($fileSize <= 2097152) {
            $destPath = $uploadDir . $newFileName;
            
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Delete old profile picture if exists
                if (isset($_SESSION['profile_picture'])) {
                    $oldFilePath = $uploadDir . $_SESSION['profile_picture'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                
                // Update database
                $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
                $stmt->bind_param("si", $newFileName, $_SESSION['user_id']);
                
                if ($stmt->execute()) {
                    $_SESSION['profile_picture'] = $newFileName;
                    $response = ['success' => true, 'filename' => $newFileName];
                } else {
                    $response['message'] = 'Database update failed';
                    unlink($destPath); // Remove the uploaded file if DB update failed
                }
                $stmt->close();
            } else {
                $response['message'] = 'File upload failed';
            }
        } else {
            $response['message'] = 'File size too large. Maximum 2MB allowed.';
        }
    } else {
        $response['message'] = 'Only JPG, PNG, GIF, and WEBP files are allowed.';
    }
} else {
    $response['message'] = 'No file uploaded or upload error occurred.';
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($response);
?>