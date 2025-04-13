<?php
include '../includes/connect.php';

$student_id = $_GET['student_id'];

$sql = "SELECT name, mobile, profile_pic FROM students WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $row['profile_pic'] = '../uploads/' . $row['profile_pic'];
    echo json_encode($row);
} else {
    echo json_encode(["error" => "Student not found"]);
}
?>
