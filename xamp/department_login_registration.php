<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Login Registration</title>
    <link rel="stylesheet" href="static/department_login_registration_styles.css">

</head>
<body>
    <div class="header">
        <img src="image/logo.png" alt="University Logo">
        <h1>University Name</h1>
    </div>
    <div class="content">
        <h2>Department Login Registration</h2>
        <form id="departmentLoginRegistrationForm" action="department_login_registration_process.php" method="POST">
            <div class="form-group">
                <label for="departmentNo">Department No:</label>
                <select id="departmentNo" name="departmentNo" required>
                    <!-- Options will be populated by PHP -->
                    <?php include('fetch_departments.php'); ?>
                </select>
            </div>
            <div class="form-group">
                <label for="departmentPassword">Create Password:</label>
                <input type="password" id="departmentPassword" name="departmentPassword" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>
            <button type="submit" class="submit-button">Register</button>
        </form>
    </div>
    <footer>
        <p>Developed by Mahesh A V</p>
    </footer>
    <script src="script/department_login_registration_script.js"></script>
</body>
</html>
