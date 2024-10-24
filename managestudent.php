<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "quiz";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle student deletion
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['stud_id'])) {
    $stud_id = $_GET['stud_id']; // Directly get the stud_id

    $sql = "DELETE FROM student WHERE stud_id = $stud_id"; // Basic query without prepared statements

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Student deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting student: " . $conn->error . "');</script>";
    }
}

// Fetch students
$sql = "SELECT stud_id, firstname, lastname, age, DOB, gender, email, phoneno FROM student";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="managestudent.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
</head>
<body>
    <nav>
        <h3>ONLINE QUIZ</h3>
        <h1>Admin Dashboard</h1>
        <div class="options">
            <ul>
                <li><a href="dashboard.html">Home</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="section1">
        <div class="sidebar">
            <div class="options2">
                <a href="admin.html">Home</a>
                <a href="manage_quiz.html">Manage Quiz</a>
                <a href="manage_students.php">Manage Students</a>
                <a href="manage_staff.html">Manage Staff</a>
                <a href="manage_parent.html">Manage Parent</a>
                <a href="logout.html">Log Out</a>
            </div>
        </div>
        
        <div class="maincontents">
            <h1>Manage Students</h1>
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Age</th>
                        <th>DOB</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Phone No</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['stud_id']}</td>
                                    <td>{$row['firstname']}</td>
                                    <td>{$row['lastname']}</td>
                                    <td>{$row['age']}</td>
                                    <td>{$row['DOB']}</td>
                                    <td>{$row['gender']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['phoneno']}</td>
                                    <td>
                                        <a href='manage_students.php?action=delete&stud_id={$row['stud_id']}' onclick=\"return confirm('Are you sure you want to delete this student?');\">Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No students found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
