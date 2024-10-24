<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'quiz');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all quizzes with their respective department and subject
$quiz_sql = "SELECT * FROM quizzes"; // Adjust table names and field names as necessary
$quiz_result = mysqli_query($conn, $quiz_sql);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="manage_quiz.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Quizzes - Admin</title>
</head>

<body>
    <nav>
        <h3>ONLINE QUIZ</h3>
        <h1>Manage Quizzes</h1>
        <div class="options">
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Log Out</a></li>
                <a href="admin.php">Home</a>
            </ul>
        </div>
    </nav>
    <div class="section1">
        <div class="maincontents">
            <h2>All Quizzes</h2>
            <table border="1">
                <tr>
                    <th>Quiz ID</th>
                    <th>Subject</th>
                    <th>Time Limit (min)</th>
                    <th>Department</th>
                </tr>
                <?php
                if ($quiz_result && mysqli_num_rows($quiz_result) > 0) {
                    while ($quiz_row = mysqli_fetch_assoc($quiz_result)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($quiz_row['quiz_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($quiz_row['subject']) . '</td>';
                        echo '<td>' . htmlspecialchars($quiz_row['time_limit']) . '</td>';
                        echo '<td>' . htmlspecialchars($quiz_row['department']) . '</td>'; // Display department name
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4">No quizzes found.</td></tr>';
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>
