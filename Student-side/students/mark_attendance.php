
<?php
// api/markAttendance.php
include '../includes/connect.php';

$student_id = $_POST['student_id'];
$meeting_id = $_POST['meeting_id'];
$status = 'present';

$sql = "INSERT INTO attendance (student_id, meeting_id, status) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $student_id, $meeting_id, $status);
if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}
?>
