<?php
// Include database connection file
include('database_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $date = $_GET['date'];

    $query = "SELECT teacher_id, teacher_name, attendance_date, attendance_time 
              FROM Teacher_Attendance 
              WHERE attendance_date = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $attendance = array();
        while ($row = $result->fetch_assoc()) {
            $attendance[] = $row;
        }
        $response = array('status' => 'success', 'attendance' => $attendance);
    } else {
        $response = array('status' => 'error', 'message' => 'No attendance records found.');
    }

    $stmt->close();
    echo json_encode($response);
    exit;
}

$conn->close();
?>
