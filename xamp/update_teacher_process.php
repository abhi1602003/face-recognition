<?php
// Include database connection
include 'database_connection.php';

// Check if teacher ID is provided
if (isset($_POST['teacherId'])) {
    // Sanitize input
    $teacherId = mysqli_real_escape_string($conn, $_POST['teacherId']);

    // Array to store updated details
    $updatedDetails = array();

    // Check if any fields are selected for update
    $updateQuery = "UPDATE Teacher SET ";
    $updates = array();

    if (!empty($_POST['teacherName'])) {
        $teacherName = mysqli_real_escape_string($conn, $_POST['teacherName']);
        $updates[] = "teacher_name = '$teacherName'";
        $updatedDetails['teacher_name'] = $teacherName;
    }
    if (!empty($_POST['teacherPhone'])) {
        $teacherPhone = mysqli_real_escape_string($conn, $_POST['teacherPhone']);
        $updates[] = "teacher_phone = '$teacherPhone'";
        $updatedDetails['teacher_phone'] = $teacherPhone;
    }
    if (!empty($_POST['teacherPost'])) {
        $teacherPost = mysqli_real_escape_string($conn, $_POST['teacherPost']);
        $updates[] = "teacher_post = '$teacherPost'";
        $updatedDetails['teacher_post'] = $teacherPost;
    }
    if (!empty($_POST['departmentNo'])) {
        $departmentNo = mysqli_real_escape_string($conn, $_POST['departmentNo']);
        $updates[] = "department_no = '$departmentNo'";
        $updatedDetails['department_no'] = $departmentNo;
    }

    // Handle image upload if checkbox is selected
    if (!empty($_FILES['teacherImage']['name'])) {
        // Image upload directory (adjust as needed)
        $uploadDirectory = 'uploads/';

        // Generate a new filename based on teacher ID and file extension
        $teacherImage = $_FILES['teacherImage'];
        $imageFileType = strtolower(pathinfo($teacherImage['name'], PATHINFO_EXTENSION));
        $newFileName = $teacherId . '.' . 'png'; // Rename file to teacherID.ext
        $targetFilePath = $uploadDirectory . basename($newFileName);
        $uploadOk = 1;

        // Check file type
        $allowedExtensions = array('jpg', 'jpeg', 'png');
        if (in_array($imageFileType, $allowedExtensions)) {
            // Upload image to server
            if (move_uploaded_file($teacherImage['tmp_name'], $targetFilePath)) {
                // Update image path in database
                $updates[] = "teacher_image = '$targetFilePath'";
                $updatedDetails['teacher_image'] = $targetFilePath;
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Failed to upload image.'));
                exit;
            }
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Only JPG, JPEG, and PNG files are allowed.'));
            exit;
        }
    }

    // Construct the update query
    if (!empty($updates)) {
        $updateQuery .= implode(', ', $updates);
        $updateQuery .= " WHERE teacher_id = '$teacherId'";

        // Execute update query
        if (mysqli_query($conn, $updateQuery)) {
            echo json_encode(array('status' => 'success', 'message' => 'Teacher details updated successfully.', 'updatedDetails' => $updatedDetails));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Error updating teacher details: ' . mysqli_error($conn)));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'No fields selected for update.'));
    }

} else {
    // Return error message if teacher ID is not provided
    echo json_encode(array('status' => 'error', 'message' => 'Teacher ID not provided.'));
}

?>
