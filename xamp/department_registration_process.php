<?php
include 'database_connection.php';

header('Content-Type: application/json');

$departmentNo = $_POST['departmentNo'];
$departmentName = $_POST['departmentName'];

$sql = "INSERT INTO Department (department_no, department_name) VALUES (?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $departmentNo, $departmentName);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to register department']);
}

$stmt->close();
$conn->close();
?>
