<?php
include('database_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $department_no = $_POST['departmentNo'];
    $department_password = $_POST['departmentPassword'];
    $confirm_password = $_POST['confirmPassword'];

    if ($department_password === $confirm_password) {
        $hashed_password = $department_password;

        // Fetch the department_name based on department_no
        $query = "SELECT department_name FROM Department WHERE department_no = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $department_no);
        $stmt->execute();
        $stmt->bind_result($department_name);
        $stmt->fetch();
        $stmt->close();

        if ($department_name) {
            $query = "INSERT INTO Department_Login (department_no, department_name, department_password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $department_no, $department_name, $hashed_password);
            
            if ($stmt->execute()) {
                echo "<script>alert('Registration successful!'); window.location.href='admin_home.html';</script>";
            } else {
                echo "<script>alert('Error: Could not register.'); window.location.href='department_login_registration.html';</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Invalid department number.'); window.location.href='department_login_registration.html';</script>";
        }
    } else {
        echo "<script>alert('Passwords do not match.'); window.location.href='department_login_registration.html';</script>";
    }
}

$conn->close();
?>
