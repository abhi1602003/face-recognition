<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance</title>
    <link rel="stylesheet" href="static/student_attendance_new_styles.css">
    
</head>
<body>
    <div class="header">
        <img src="image/logo.png" alt="University Logo">
        <h1>University Name</h1>
    </div>
    <div class="content">
        <h2>Student Attendance Details</h2>
        <div class="filter-section">
            <label for="semester">Filter by Semester:</label>
            <select id="semester">
                <option value="Semester 1">Semester 1</option>
                <option value="Semester 2">Semester 2</option>
                <option value="Semester 3">Semester 3</option>
                <option value="Semester 4">Semester 4</option>
                <option value="Semester 5">Semester 5</option>
                <option value="Semester 6">Semester 6</option>
                <option value="Semester 7">Semester 7</option>
                <option value="Semester 8">Semester 8</option>
            </select>
            <label for="attendanceDate">Filter by Date:</label>
            <input type="date" id="attendanceDate">
            <button onclick="filterAttendance()" class="button">Filter</button>
        </div>
        <br>
        <div class="attendance-table">
            <?php
            // Include database connection file
            include 'database_connection.php';

            // Initialize variables
            $tableOutput = '';

            // Fetch student attendance details
            $query = "SELECT sa.student_usn, s.student_name, sa.attendance_date, sa.attendance_time, s.semester 
                      FROM Student_Attendance sa 
                      INNER JOIN student s ON sa.student_usn = s.student_usn";

            $result = mysqli_query($conn, $query);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    $tableOutput .= '<table>';
                    $tableOutput .= '<tr><th>USN</th><th>Name</th><th>Attendance Date</th><th>Attendance Time</th><th>Semester</th></tr>';
                    while ($row = mysqli_fetch_assoc($result)) {
                        $tableOutput .= '<tr>';
                        $tableOutput .= '<td>' . htmlspecialchars($row['student_usn']) . '</td>';
                        $tableOutput .= '<td>' . htmlspecialchars($row['student_name']) . '</td>';
                        $tableOutput .= '<td>' . htmlspecialchars($row['attendance_date']) . '</td>';
                        $tableOutput .= '<td>' . htmlspecialchars($row['attendance_time']) . '</td>';
                        $tableOutput .= '<td>' . htmlspecialchars($row['semester']) . '</td>';
                        $tableOutput .= '</tr>';
                    }
                    $tableOutput .= '</table>';
                }
                 else 
                {
                    $tableOutput = 'No attendance records found.';
                }
            } else {
                // Query execution error
                $tableOutput = 'Error fetching attendance data: ' . mysqli_error($conn);
            }

            // Close the database connection
            mysqli_close($conn);
            echo $tableOutput;
            ?>
        </div>
    </div>
    <footer>
        <p>Developed by Mahesh A V</p>
    </footer>
    <script src="script/student_attendance_new_script.js"></script>
</body>
</html>
