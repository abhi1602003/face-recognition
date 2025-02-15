<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Details</title>
    <style>
        /* Basic CSS for styling */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
        .teacher-img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Teacher Details</h2>

    <?php
    // Include database connection
    include 'database_connection.php';

    // Define the teacher ID you want to check
    $teacherId = 'ISE_01'; // Replace with the actual teacher ID you want to check

    // Sanitize input (though in this case, it's hard-coded and not user input)
    $teacherId = mysqli_real_escape_string($conn, $teacherId);

    // Query to select teacher details by ID
    $sql = "SELECT * FROM Teacher WHERE teacher_id = '$teacherId'";

    // Execute query
    $result = mysqli_query($conn, $sql);

    // Check if query was successful
    if ($result) {
        // Check if teacher exists
        if (mysqli_num_rows($result) > 0) {
            // Teacher exists
            $teacherDetails = mysqli_fetch_assoc($result);
            ?>
            <div class="success">
                <p>Teacher found:</p>
                <ul>
                    <li><strong>Teacher ID:</strong> <?php echo $teacherDetails['teacher_id']; ?></li>
                    <li><strong>Name:</strong> <?php echo $teacherDetails['teacher_name']; ?></li>
                    <li><strong>Phone:</strong> <?php echo $teacherDetails['teacher_phone']; ?></li>
                    <li><strong>Post:</strong> <?php echo $teacherDetails['teacher_post']; ?></li>
                    <li><strong>Dep No:</strong> <?php echo $teacherDetails['department_no']; ?></li>
                </ul>
                <?php
                // Display the image if it exists
                if (!empty($teacherDetails['teacher_image'])) {
                    $imagePath = $teacherDetails['teacher_image'];
                    ?>
                    <div>
                        <img src="<?php echo $imagePath; ?>" alt="Teacher Image" class="teacher-img">
                    </div>
                    <?php
                } else {
                    ?>
                    <p>No image available</p>
                    <?php
                }
                ?>
            </div>
            <?php
        } else {
            // Teacher not found
            ?>
            <div class="error">
                <p>Teacher not found.</p>
            </div>
            <?php
        }
    } else {
        // Query failed
        ?>
        <div class="error">
            <p>Error: <?php echo mysqli_error($conn); ?></p>
        </div>
        <?php
    }
    ?>

</div>

</body>
</html>
