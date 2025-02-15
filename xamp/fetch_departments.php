<?php
include('database_connection.php');

$query = "SELECT department_no, department_name FROM Department";
$result = $conn->query($query);

$options = '';
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['department_no'] . "'>" . $row['department_no'] . " - " . $row['department_name'] . "</option>";
    }
} else {
    echo "Error in query execution";
}

echo $options;

$conn->close();
?>
