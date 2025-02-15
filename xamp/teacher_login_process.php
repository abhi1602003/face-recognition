<?php
session_start();
include('database_connection.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teacher_id = $_POST['teacher_id'];
    $teacher_password = $_POST['teacher_password'];

    // Query to check login credentials
    $query = "SELECT * FROM Teacher_Login WHERE teacher_id = ? AND teacher_password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $teacher_id, $teacher_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Successful login
        $_SESSION['teacher_id'] = $teacher_id;
        header("Location: student_home.html"); // Redirect to student home page
        exit(); // Make sure to exit after redirection
    } else {
        // Failed login
        echo "<script>alert('Invalid Teacher ID or Password'); window.location.href='teacher_login.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
