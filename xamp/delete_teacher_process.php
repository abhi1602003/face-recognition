<?php
// Include database connection
include 'database_connection.php';

// Check if teacher ID is provided
if (isset($_GET['teacherId'])) {
    // Sanitize input
    $teacherId = mysqli_real_escape_string($conn, $_GET['teacherId']);

    // Query to fetch image path from database
    $sql_select_image = "SELECT teacher_image FROM Teacher WHERE teacher_id = '$teacherId'";
    $result = mysqli_query($conn, $sql_select_image);

    if (mysqli_num_rows($result) > 0) {
        // Fetch image path
        $row = mysqli_fetch_assoc($result);
        $imagePath = $row['teacher_image'];

        // Check if the image file exists
        if (file_exists($imagePath)) {
            // Delete the image file from local PC
            if (unlink($imagePath)) {
                // Image file deleted successfully
                // Proceed to delete record from database

                // Query to delete teacher by ID
                $sql_delete_teacher = "DELETE FROM Teacher WHERE teacher_id = '$teacherId'";

                // Execute delete query
                if (mysqli_query($conn, $sql_delete_teacher)) {
                    // Return success message if deletion is successful
                    echo json_encode(array('status' => 'success', 'message' => 'Teacher and image deleted successfully.'));
                } else {
                    // Return error message if query fails
                    echo json_encode(array('status' => 'error', 'message' => 'Error: ' . mysqli_error($conn)));
                }
            } else {
                // Error deleting image file
                echo json_encode(array('status' => 'error', 'message' => 'Error deleting image file.'));
            }
        } else {
            // Image file does not exist
            // Proceed to delete record from database

            // Query to delete teacher by ID
            $sql_delete_teacher = "DELETE FROM Teacher WHERE teacher_id = '$teacherId'";

            // Execute delete query
            if (mysqli_query($conn, $sql_delete_teacher)) {
                // Return success message if deletion is successful
                echo json_encode(array('status' => 'success', 'message' => 'Teacher deleted successfully.'));
            } else {
                // Return error message if query fails
                echo json_encode(array('status' => 'error', 'message' => 'Error: ' . mysqli_error($conn)));
            }
        }
    } else {
        // No image found in database
        // Proceed to delete record from database only

        // Query to delete teacher by ID
        $sql_delete_teacher = "DELETE FROM Teacher WHERE teacher_id = '$teacherId'";

        // Execute delete query
        if (mysqli_query($conn, $sql_delete_teacher)) {
            // Return success message if deletion is successful
            echo json_encode(array('status' => 'success', 'message' => 'Teacher deleted successfully.'));
        } else {
            // Return error message if query fails
            echo json_encode(array('status' => 'error', 'message' => 'Error: ' . mysqli_error($conn)));
        }
    }
} else {
    // Return error message if teacher ID is not provided
    echo json_encode(array('status' => 'error', 'message' => 'Teacher ID not provided.'));
}

// Close database connection
mysqli_close($conn);
?>
