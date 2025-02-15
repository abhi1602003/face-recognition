<?php
// Include database connection
include 'database_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data (escape them later if needed)
    $studentName = mysqli_real_escape_string($conn, $_POST['studentName']);
    $studentUsn = mysqli_real_escape_string($conn, $_POST['studentUSN']);
    $studentPhone = mysqli_real_escape_string($conn, $_POST['studentPhone']);
    $studentSemester = mysqli_real_escape_string($conn, $_POST['semester']);
    $studentDepartment = mysqli_real_escape_string($conn, $_POST['departmentNo']); // Corrected key here
    $studentImage = $_FILES['studentImage'];

    // Handle file upload
    $targetDirectory = "uploads/";
    $imageFileType = strtolower(pathinfo($studentImage["name"], PATHINFO_EXTENSION));
    $newFileName = $studentUsn . '.' . $imageFileType;
    $targetFile = $targetDirectory . basename($newFileName);

    // Check if image file is a valid image
    $check = getimagesize($studentImage["tmp_name"]);
    if ($check === false) {
        echo json_encode(array('status' => 'error', 'message' => 'File is not an image.'));
        exit;
    }

    // Check file size (30MB max)
    if ($studentImage["size"] > 30000000) {
        echo json_encode(array('status' => 'error', 'message' => 'Sorry, your file is too large.'));
        exit;
    }

    // Allow certain file formats
    $allowedExtensions = array('jpg', 'jpeg', 'png');
    if (!in_array($imageFileType, $allowedExtensions)) {
        echo json_encode(array('status' => 'error', 'message' => 'Sorry, only JPG, JPEG, and PNG files are allowed.'));
        exit;
    }

    // Check if the department number exists in the 'department' table
    $checkDepartmentQuery = "SELECT department_no FROM department WHERE department_no = '$studentDepartment'";
    $checkDepartmentResult = mysqli_query($conn, $checkDepartmentQuery);

    if (mysqli_num_rows($checkDepartmentResult) > 0) {
        // Department number exists, proceed with insertion
        $sql = "INSERT INTO student (student_usn, student_name, student_phone, semester, department_no, student_image) 
                VALUES ('$studentUsn','$studentName', '$studentPhone','$studentSemester', '$studentDepartment', '$targetFile')";

        if (mysqli_query($conn, $sql)) {
            // File upload
            if (move_uploaded_file($studentImage["tmp_name"], $targetFile)) {
                echo json_encode(array('status' => 'success', 'message' => 'New record created successfully'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Error uploading file.'));
            }
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Error: ' . mysqli_error($conn)));
        }
    } else {
        // Department number doesn't exist in 'department' table
        echo json_encode(array('status' => 'error', 'message' => 'Error: Department number does not exist.'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method.'));
}

// Close the database connection
mysqli_close($conn);
?>
