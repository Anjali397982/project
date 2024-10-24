<?php
// Start the session
session_start();

// Database connection
$con = mysqli_connect("localhost", "root", "", "quiz");
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

$id = $_SESSION['staffid']; 

// Get staff department
$staff_query = "SELECT department_name FROM staff WHERE staff_id='$id'";
$staff_result = mysqli_query($con, $staff_query);
$staff_row = mysqli_fetch_assoc($staff_result);
$department = $staff_row['department_name'];

$student_query = "SELECT * FROM student WHERE department='$department'";
$student_result = mysqli_query($con, $student_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <link rel="stylesheet" href="staff_manage_students.css"> <!-- Link to your CSS file -->
</head>

<body>
    <nav>
        <h3>ONLINE QUIZ</h3>
        <h1>Manage Students</h1>
        <div class="options">
            <ul>
                <li><a href="staff_dashboard.php">Home</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </nav>

    <div class="section1">
        <div class="sidebar">
            <div class="options2">
            <a href="staff.html">Dashboard</a>
                <a href="managequiz.php">Manage Quiz</a>
                <a href="staff_manage_student.php">Manage Students</a>
                <a href="logout.php">Log Out</a>
            </div>
        </div>
        <div class="maincontents">
            <h1>Students in Your Department: <?php echo htmlspecialchars($department); ?></h1>

            <table border="1">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Age</th>
                        <th>Email</th>
                        <th>Phone No</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($student_result) > 0) {
                        while ($row = mysqli_fetch_assoc($student_result)) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['firstname']) . "</td>
                                    <td>" . htmlspecialchars($row['lastname']) . "</td>
                                    <td>" . htmlspecialchars($row['age']) . "</td>
                                    <td>" . htmlspecialchars($row['email']) . "</td>
                                    <td>" . htmlspecialchars($row['phoneno']) . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No students found in this department.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<?php
// Close the database connection
mysqli_close($con);
?>
