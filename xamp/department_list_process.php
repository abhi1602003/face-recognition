<?php
require_once 'database_connection.php';

$response = array();

$sql = "SELECT department_no, department_name FROM Department";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $departments = array();
    while($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }
    $response['status'] = 'success';
    $response['departments'] = $departments;
} else {
    $response['status'] = 'error';
    $response['message'] = 'No departments found';
}

$conn->close();

echo json_encode($response);
?>
