<?php
// Include database connection file
include('database_connection.php');

if (isset($_GET['studentUSN'])) {
    $studentUSN = $_GET['studentUSN'];

    // Delete student details
    $query = "DELETE FROM Student WHERE student_usn = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $studentUSN);
    if ($stmt->execute()) {
        $response = array('status' => 'success', 'message' => 'Student details deleted successfully.');
    } else {
        $response = array('status' => 'error', 'message' => 'Failed to delete student details.');
    }
    $stmt->close();
    echo json_encode($response);
}

$conn->close();
?>
