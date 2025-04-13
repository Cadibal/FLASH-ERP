<?php
include '../includes/connect.php';

header("Content-Type: application/json");

if (!isset($_GET['student_id'])) {
  echo json_encode(["status" => "error", "message" => "Missing student_id"]);
  exit;
}

$student_id = $_GET['student_id'];

// Get the latest meeting
$meetingSql = "SELECT * FROM meetings ORDER BY meeting_id DESC LIMIT 1";
$meetingResult = $conn->query($meetingSql);

if ($meetingResult->num_rows > 0) {
  $meeting = $meetingResult->fetch_assoc();
  $meeting_id = $meeting['meeting_id'];
  $link = $meeting['link'];

  // Check if student attended this meeting
  $attendSql = "SELECT * FROM attendance WHERE student_id = '$student_id' AND meeting_id = '$meeting_id'";
  $attendResult = $conn->query($attendSql);
  $attended = $attendResult->num_rows > 0;

  // Calculate attendance percentage
  $totalSql = "SELECT COUNT(*) as total FROM meetings";
  $presentSql = "SELECT COUNT(*) as present FROM attendance WHERE student_id = '$student_id'";

  $totalMeetings = $conn->query($totalSql)->fetch_assoc()['total'];
  $presentMeetings = $conn->query($presentSql)->fetch_assoc()['present'];

  $percentage = $totalMeetings > 0 ? round(($presentMeetings / $totalMeetings) * 100) : 0;

  echo json_encode([
    "meeting_id" => $meeting_id,
    "link" => $link,
    "attended" => $attended,
    "percentage" => $percentage
  ]);
} else {
  echo json_encode([
    "meeting_id" => null,
    "link" => null,
    "attended" => false,
    "percentage" => 0
  ]);
}
?>
