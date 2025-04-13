<?php
include '../includes/connect.php';

if (!isset($_POST['student_id'])) {
    echo json_encode(["status" => "error", "message" => "No student_id received"]);
    exit();
}

$student_id = $_POST['student_id'];

if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
    $fileName = uniqid() . "_" . basename($_FILES["profile_pic"]["name"]);
    $targetDir = "../uploads/";
    $targetFile = $targetDir . $fileName;

    // Move uploaded file
    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFile)) {
        $relativePath = "uploads/" . $fileName;

        // Update in DB
        $stmt = $conn->prepare("UPDATE students SET profile_pic = ? WHERE student_id = ?");
        $stmt->bind_param("ss", $relativePath, $student_id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "path" => $relativePath]);
        } else {
            echo json_encode(["status" => "error", "message" => "DB update failed"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "File move failed"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No file uploaded or upload error"]);
}
?>
