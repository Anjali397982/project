<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "quiz";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle department deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM departments WHERE department_id='$delete_id'");
}

// Handle department addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_department'])) {
    $department_name = $_POST['department_name'];
    
    $conn->query("INSERT INTO departments (department_name) VALUES ('$department_name')");
}

$sql = "SELECT department_id, department_name FROM departments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="manage_department.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Departments - Admin Dashboard</title>
</head>

<body>
    <nav>
        <h3>ONLINE QUIZ</h3>
        <h1>Admin Dashboard</h1>
        <div class="options">
            <ul>
                <li><a href="dashboard.html">Home</a></li>
                <li><a href="managestudent.php">Manage Students</a></li>
                <li><a href="managestaff.php">Manage Staff</a></li>
                <li><a href="manage_department.php">Manage Departments</a></li>
                <li><a href="logout.html">Log Out</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="section1">
        <div class="sidebar">
            <div class="options2">
                <a href="manage_quiz.html">Manage Quiz</a>
                <a href="managestudent.php">Manage Students</a>
                <a href="managestaff.php">Manage Staff</a>
                <a href="manage_department.php">Manage Departments</a>
                <a href="logout.html">Log Out</a>
            </div>
        </div>
        
        <div class="maincontents">
            <h1>Manage Departments</h1>
            
            <h2>Add New Department</h2>
            <form method="POST" action="">
                <input type="text" name="department_name" placeholder="Department Name" required>
                <button type="submit" name="add_department">Add Department</button>
            </form>

            <h2>Current Departments</h2>
            <table>
                <thead>
                    <tr>
                        <th>Department ID</th>
                        <th>Department Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['department_id']}</td>
                                    <td>{$row['department_name']}</td>
                                    <td>
                                        <a href='manage_department.php?delete_id={$row['department_id']}' onclick='return confirm(\"Are you sure you want to delete this department?\");'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No departments found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
