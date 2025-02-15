<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "UniversityDB"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debugging: Check POST data received
    var_dump($_POST);

    // Get the selected semester, date, and time from the form
    $semester = $_POST['semester'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Prepare SQL query to fetch attendance data
    $query = "SELECT sa.student_name, sa.student_usn, sa.attendance_date, sa.attendance_time, s.semester
              FROM student_attendance sa
              JOIN student s ON sa.student_usn = s.student_usn
              WHERE s.semester = ? AND sa.attendance_date = ? AND sa.attendance_time = ?";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $semester, $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch data from the result set
    $attendanceData = array();
    while ($row = $result->fetch_assoc()) {
        $attendanceData[] = $row;
    }

    // Close statement
    $stmt->close();

    // Close database connection
    $conn->close();

    // Output the attendance data as JSON
    header('Content-Type: application/json');
    echo json_encode($attendanceData);
}
?>
