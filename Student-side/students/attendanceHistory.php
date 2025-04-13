<?php
include '../includes/connect.php';

$student_id = $_GET['student_id'];

$sql = "SELECT m.title, m.date, 
               CASE WHEN a.status = 1 THEN 'Present' ELSE 'Absent' END AS status 
        FROM meetings m
        LEFT JOIN attendance a ON m.meeting_id = a.meeting_id AND a.student_id = ?
        ORDER BY m.date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
