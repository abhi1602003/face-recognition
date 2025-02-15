<?php
require_once 'database_connection.php';

$response = array();

$postFilter = isset($_GET['post']) ? $_GET['post'] : '';
$departmentFilter = isset($_GET['department']) ? $_GET['department'] : '';

$sql = "SELECT teacher_id, teacher_name, teacher_post, teacher_phone, department_name, teacher_image FROM Teacher WHERE 1";

if ($postFilter !== '') {
    $sql .= " AND teacher_post = '" . $conn->real_escape_string($postFilter) . "'";
}

if ($departmentFilter !== '') {
    $sql .= " AND department_name = '" . $conn->real_escape_string($departmentFilter) . "'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $teachers = array();
    while($row = $result->fetch_assoc()) {
        $teachers[] = $row;
    }
    $response['status'] = 'success';
    $response['teachers'] = $teachers;
} else {
    $response['status'] = 'error';
    $response['message'] = 'No teachers found';
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
