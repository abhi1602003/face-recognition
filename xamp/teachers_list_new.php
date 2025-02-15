<?php
require_once 'database_connection.php'; // Ensure this file correctly sets up $servername, $username, $password, $dbname

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize filters
$filter_post = isset($_GET['teacher_post']) ? $_GET['teacher_post'] : '';
$filter_department = isset($_GET['department_no']) ? $_GET['department_no'] : '';

// Fetch unique teacher posts for the filter dropdown
$post_query = "SELECT DISTINCT teacher_post FROM teacher";
$post_result = $conn->query($post_query);

// Fetch unique department numbers for the filter dropdown
$department_query = "SELECT DISTINCT department_no FROM teacher";
$department_result = $conn->query($department_query);

// Fetch teacher data with filters
$sql = "SELECT teacher_id, teacher_name, teacher_post, teacher_phone, department_no FROM teacher WHERE 1=1";
if ($filter_post) {
    $sql .= " AND teacher_post = '" . $conn->real_escape_string($filter_post) . "'";
}
if ($filter_department) {
    $sql .= " AND department_no = '" . $conn->real_escape_string($filter_department) . "'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Details</title>
    <link rel="stylesheet" href="static/teachers_list_styles.css">
    <script src="script/teachers_list_script.js"></script>
</head>
<body>

<div class="header">
    <img src="image/logo.png" alt="University Logo">
    <h1>University Name</h1>
</div>

<div class="content">
    <div class="filter-box">
        <form method="GET" action="">
            <label for="teacher_post">Filter by Post:</label>
            <select name="teacher_post" id="teacher_post">
                <option value="">All</option>
                <?php while ($row = $post_result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['teacher_post']) ?>" <?= $filter_post == $row['teacher_post'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['teacher_post']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="department_no">Filter by Department:</label>
            <select name="department_no" id="department_no">
                <option value="">All</option>
                <?php while ($row = $department_result->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($row['department_no']) ?>" <?= $filter_department == $row['department_no'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['department_no']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Apply Filters</button>
        </form>
    </div>

    <div id="teachersTableContainer">
        <table>
            <thead>
            <tr>
                <th>Teacher ID</th>
                <th>Teacher Name</th>
                <th>Teacher Post</th>
                <th>Teacher Phone</th>
                <th>Department No</th>
                <th>Teacher Image</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['teacher_id']) ?></td>
                        <td><?= htmlspecialchars($row['teacher_name']) ?></td>
                        <td><?= htmlspecialchars($row['teacher_post']) ?></td>
                        <td><?= htmlspecialchars($row['teacher_phone']) ?></td>
                        <td><?= htmlspecialchars($row['department_no']) ?></td>
                        <td>
                            <?php
                            $teacher_id = $row['teacher_id'];
                            $image_path = "uploads/{$teacher_id}.png"; // Assuming images are in PNG format

                            if (file_exists($image_path)) {
                                echo '<img src="' . $image_path . '" alt="Teacher Image" class="teacher-image">';
                            } else {
                                echo 'No Image';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No records found</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<footer>
    <p>Developed by Mahesh A V</p>
</footer>

<?php
$conn->close();
?>
</body>
</html>
