<?php
// Include database connection file
include('database_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $department_no = $_POST['department_no'];
    $department_password = $_POST['department_password'];

    // Fetch the department login details from the database
    $query = "SELECT * FROM Department_Login WHERE department_no = ? AND department_password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $department_no, $department_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION['department_no'] = $department_no;
        header("Location: Department_home.html"); // Redirect to student home page
        exit(); // Make sure to exit after redirection
    } else {
        // Failed login
        echo "<script>alert('Invalid Department No or Password'); window.location.href='department_login.html';</script>";
    }
    
    $stmt->close();
    echo json_encode($response);
    exit;
}

$conn->close();
?>
