<?php
include('database_connection.php');

$query = "SELECT department_no, department_name FROM Department";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Department No</th><th>Department Name</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['department_no'] . "</td><td>" . $row['department_name'] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No departments found.";
}

$conn->close();
?>
