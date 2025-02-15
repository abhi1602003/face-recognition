<?php
// Include database connection file
include('database_connection.php');

if (isset($_GET['studentUSN'])) {
    $studentUSN = $_GET['studentUSN'];
    
    // Search for student details
    $query = "SELECT * FROM Student WHERE student_usn = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $studentUSN);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $response = array('status' => 'success', 'student' => $student);
    } else {
        $response = array('status' => 'error', 'message' => 'Student not found.');
    }
    $stmt->close();
    echo json_encode($response);
}

$conn->close();
?>
