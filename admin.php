<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'quiz');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch total students
$total_students_sql = "SELECT COUNT(*) AS total_students FROM student";
$total_students_result = mysqli_query($conn, $total_students_sql);
$total_students_row = mysqli_fetch_assoc($total_students_result);
$total_students = $total_students_row['total_students'];

// Fetch total quizzes
$total_quizzes_sql = "SELECT COUNT(*) AS total_quizzes FROM quizzes";
$total_quizzes_result = mysqli_query($conn, $total_quizzes_sql);
$total_quizzes_row = mysqli_fetch_assoc($total_quizzes_result);
$total_quizzes = $total_quizzes_row['total_quizzes'];

// Fetch total staff
$total_staff_sql = "SELECT COUNT(*) AS total_staff FROM staff"; // Replace 'staff' with your actual staff table name
$total_staff_result = mysqli_query($conn, $total_staff_sql);
$total_staff_row = mysqli_fetch_assoc($total_staff_result);
$total_staff = $total_staff_row['total_staff'];

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="admin.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Quiz Competition</title>
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
                <a href="manage_quiz.php">Manage Quiz</a>
                <a href="managestudent.php">Manage Students</a>
                <a href="managestaff.php">Manage Staff</a>
                <a href="manage_department.php">Manage Department</a>
                <a href="logout.php">Log Out</a>
            </div>
        </div>
        <div class="maincontents">
            <h1>Welcome to the Admin Dashboard</h1>
            <p>This dashboard allows you to oversee and manage all aspects of the quiz competition. Here, you can add, edit, or remove quizzes, manage student registrations, and handle staff and parent communications. Use the links on the left to navigate to different sections and ensure everything runs smoothly.</p>
            <h2>Overview</h2>
            <ul>
                <li>Total Students: <?php echo $total_students; ?></li>
                <li>Total Quizzes: <?php echo $total_quizzes; ?></li>
                <li>Total Staff: <?php echo $total_staff; ?></li> <!-- Updated to show total staff -->
            </ul>
            <h2>Actions</h2>
            <p>From this dashboard, you can manage quizzes, students, staff, and departments. Use the sidebar to navigate to the respective sections.</p>
        </div>
    </div>
</body>

</html>
