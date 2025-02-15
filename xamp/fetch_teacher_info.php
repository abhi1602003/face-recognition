<?php
include 'database_connection.php';

header('Content-Type: application/json');

$teacherId = $_GET['teacherId'];

$sql = "SELECT * FROM Teacher WHERE teacher_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $teacherId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $teacher = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'teacher' => $teacher]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Teacher not found']);
}

$stmt->close();
$conn->close();
?>
