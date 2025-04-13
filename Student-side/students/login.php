<?php
// api/login.php
include '../includes/connect.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM students WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $student = $result->fetch_assoc();
    if (password_verify($password, $student['password'])) {
        echo json_encode(["status" => "success", "student" => $student]);
    } else {
        echo json_encode(["status" => "error", "message" => "Incorrect password"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User not found"]);
}
?>
