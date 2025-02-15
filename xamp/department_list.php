<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department List</title>
    <link rel="stylesheet" href="static/department_list_styles.css">
    
</head>
<body>
    <div class="header">
        <img src="image/logo.png" alt="University Logo">
        <h1>University Name</h1>
    </div>
    <div class="content">
        <h2>Department List</h2>
        <div id="departmentList">
            <?php include('fetch_department_list.php'); ?>
        </div>
    </div>
    <footer>
        <p>Developed by Mahesh A V</p>
    </footer>
</body>
</html>
