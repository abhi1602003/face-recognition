<?php
include 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM Admin_Login WHERE username = ? AND password = ?"; // Missing semicolon added here
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Successful login
        session_start(); // Start the session before setting session variables
        $_SESSION['username'] = $username;
        header("Location: admin_home.html"); // Redirect to admin home page
        exit(); // Make sure to exit after redirection
    } else {
        // Failed login
        echo "<script>alert('Invalid username or Password'); window.location.href='admin_login.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
