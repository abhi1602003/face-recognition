<?php
// Include database connection file
include('database_connection.php');

$response = array('status' => '', 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST data
    $teacherName = $_POST['teacherName'];
    $teacherID = $_POST['teacherID'];
    $teacherPhone = $_POST['teacherPhone'];
    $teacherPost = $_POST['teacherPost'];
    $departmentNo = $_POST['departmentNo'];
    $teacherImage = $_FILES['teacherImage'];

    // Example validation (add more as needed)
    if (empty($teacherName) || empty($teacherID) || empty($teacherPhone) || empty($teacherPost) || empty($departmentNo) || empty($teacherImage)) {
        $response['status'] = 'error';
        $response['message'] = 'All fields are required';
        echo json_encode($response);
        exit();
    }

    // Example file upload handling
    $targetDirectory = "uploads/";
    $imageFileType = strtolower(pathinfo($teacherImage["name"], PATHINFO_EXTENSION));
    $newFileName = $teacherID . '.' . $imageFileType; // Rename file to teacherID.ext
    $targetFile = $targetDirectory . basename($newFileName);
    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    $check = getimagesize($teacherImage["tmp_name"]);
    if ($check === false) {
        $response['status'] = 'error';
        $response['message'] = 'File is not an image.';
        echo json_encode($response);
        exit();
    }

    // Check file size
    if ($teacherImage["size"] > 3000000) { // Adjust size limit as per your requirement
        $response['status'] = 'error';
        $response['message'] = 'Sorry, your file is too large.';
        echo json_encode($response);
        exit();
    }

    // Allow certain file formats
    if ($imageFileType != "png") { // Adjust allowed file formats as needed
        $response['status'] = 'error';
        $response['message'] = 'Sorry, only PNG files are allowed.';
        echo json_encode($response);
        exit();
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $response['status'] = 'error';
        $response['message'] = 'Sorry, your file was not uploaded.';
        echo json_encode($response);
        exit();
    } else {
        // Attempt to move uploaded file to destination
        if (move_uploaded_file($teacherImage["tmp_name"], $targetFile)) {
            // Example database insertion (replace with your actual database logic)
            $query = "INSERT INTO Teacher (teacher_name, teacher_id, teacher_phone, teacher_post, department_no, teacher_image) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssss", $teacherName, $teacherID, $teacherPhone, $teacherPost, $departmentNo, $targetFile);

            if ($stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = 'Teacher registered successfully!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Error: Could not register teacher.';
            }

            $stmt->close();
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Sorry, there was an error uploading your file.';
        }
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

$conn->close(); // Close database connection

echo json_encode($response);
?>
