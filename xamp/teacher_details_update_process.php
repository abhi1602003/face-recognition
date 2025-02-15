<?php
// Include database connection
include 'database_connection.php';

// Check if teacher ID is provided
if (isset($_GET['teacherId'])) {
    // Sanitize input
    $teacherId = mysqli_real_escape_string($conn, $_GET['teacherId']);

    // Query to select teacher details by ID
    $sql = "SELECT * FROM Teacher WHERE teacher_id = '$teacherId'";

    // Execute query
    $result = mysqli_query($conn, $sql);

    // Check if query was successful
    if ($result) {
        // Check if teacher exists
        if (mysqli_num_rows($result) > 0) {
            // Fetch teacher details
            $teacherDetails = mysqli_fetch_assoc($result);

            // Construct the path to the teacher's image based on teacher_id
           

            // Return JSON response with teacher details
            echo json_encode(array('status' => 'success', 'teacherDetails' => $teacherDetails));
        } else {
            // Return error message if teacher not found
            echo json_encode(array('status' => 'error', 'message' => 'Teacher not found.'));
        }
    } else {
        // Return error message if query fails
        echo json_encode(array('status' => 'error', 'message' => 'Error: ' . mysqli_error($conn)));
    }
} else {
    // Return error message if teacher ID is not provided
    echo json_encode(array('status' => 'error', 'message' => 'Teacher ID not provided.'));
}
?>
