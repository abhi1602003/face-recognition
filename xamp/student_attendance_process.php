<?php
// Include database connection file
include 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['semester']) && isset($_GET['attendanceDate'])) {
        $semester = $_GET['semester'];
        $attendanceDate = $_GET['attendanceDate'];

        // Prepare query to fetch attendance data based on filters
        $query = "SELECT sa.student_usn, s.student_name, sa.attendance_date, sa.attendance_time, s.semester 
                  FROM student_attendance sa
                  INNER JOIN student s ON sa.student_usn = s.student_usn
                  WHERE s.semester = ? AND sa.attendance_date = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $semester, $attendanceDate);
        $stmt->execute();
        $result = $stmt->get_result();

        $attendanceData = array();
        while ($row = $result->fetch_assoc()) {
            $attendanceData[] = $row;
        }

        $stmt->close();

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($attendanceData);
        exit;
    }
}

// Default case if parameters are missing or invalid
$response = array('status' => 'error', 'message' => 'Invalid parameters.');
echo json_encode($response);

$conn->close();
?>
