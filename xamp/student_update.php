<?php
// Include database connection file
include('database_connection.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve POST data
    $studentUSN = mysqli_real_escape_string($conn, $_POST['studentUSN']);

    // Initialize arrays to store updated details and update query parts
    $updatedDetails = [];
    $updates = [];

    // Check if fields are selected for update
    $updateQuery = "UPDATE Student SET ";

    // Process each field for update
    if (!empty($_POST['studentName'])) {
        $studentName = mysqli_real_escape_string($conn, $_POST['studentName']);
        $updates[] = "student_name = '$studentName'";
        $updatedDetails['student_name'] = $studentName;
    }
    if (!empty($_POST['studentPhone'])) {
        $studentPhone = mysqli_real_escape_string($conn, $_POST['studentPhone']);
        $updates[] = "student_phone = '$studentPhone'";
        $updatedDetails['student_phone'] = $studentPhone;
    }
    if (!empty($_POST['semester'])) {
        $semester = mysqli_real_escape_string($conn, $_POST['semester']);
        $updates[] = "semester = '$semester'";
        $updatedDetails['semester'] = $semester;
    }
    if (!empty($_POST['departmentNo'])) {
        $departmentNo = mysqli_real_escape_string($conn, $_POST['departmentNo']);
        $updates[] = "department_no = '$departmentNo'";
        $updatedDetails['department_no'] = $departmentNo;
    }

    // Handle image upload if checkbox is selected
    if (!empty($_FILES['image']['name'])) {
        // Image upload directory (adjust as needed)
        $uploadDirectory = 'uploads/';

        // Generate a new filename based on student USN and file extension
        $studentImage = $_FILES['image'];
        $imageFileType = strtolower(pathinfo($studentImage['name'], PATHINFO_EXTENSION));
        $newFileName = $studentUSN . '.' . $imageFileType; // Rename file to studentUSN.ext
        $targetFilePath = $uploadDirectory . basename($newFileName);

        // Upload image to server
        if (move_uploaded_file($studentImage['tmp_name'], $targetFilePath)) {
            $updates[] = "student_image = '$targetFilePath'";
            $updatedDetails['student_image'] = $targetFilePath;
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to upload image.'));
            exit;
        }
    }

    // Construct the update query
    if (!empty($updates)) {
        $updateQuery .= implode(', ', $updates);
        $updateQuery .= " WHERE student_usn = '$studentUSN'";

        // Execute update query
        if (mysqli_query($conn, $updateQuery)) {
            echo json_encode(array('status' => 'success', 'message' => 'Student details updated successfully.', 'updatedDetails' => $updatedDetails));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Error updating student details: ' . mysqli_error($conn)));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'No fields selected for update.'));
    }

} else {
    // Return error message if not a POST request
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method.'));
}

?>
