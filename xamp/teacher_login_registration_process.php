<?php
// Include database connection script
include 'database_connection.php';

// Set header for JSON response
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate incoming POST data
    if (isset($_POST['teacherId'], $_POST['newPassword'])) {
        // Sanitize input (if necessary)
        $teacherId = $_POST['teacherId'];
        $newPassword = $_POST['newPassword'];

        // Hash the password
        $teacher_password = $newPassword;

        // Prepare SQL statement
        $sql = "INSERT INTO Teacher_Login (teacher_id, teacher_password) VALUES (?, ?)";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $teacherId, $teacher_password);

        // Execute SQL statement
        if ($stmt->execute()) {
            // Successful registration
            echo json_encode(['status' => 'success']);
        } else {
            // Error in executing SQL statement
            echo json_encode(['status' => 'error', 'message' => 'Failed to register teacher login: ' . $conn->error]);
        }

        // Close statement
        $stmt->close();
    } else {
        // Missing parameters error
        echo json_encode(['status' => 'error', 'message' => 'Missing teacherId or newPassword']);
    }
} else {
    // Invalid request method error
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

// Close database connection
$conn->close();
?>
