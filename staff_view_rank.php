<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'quiz');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all quizzes
$quiz_sql = "SELECT quiz_id, subject, department FROM quizzes";
$quiz_result = mysqli_query($conn, $quiz_sql);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="staff_view_rank.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff View Quiz Ranks</title>
</head>

<body>
    <nav>
        <h3>ONLINE QUIZ</h3>
        <h1>Staff Dashboard</h1>
        <div class="options">
            <ul>
                <li><a href="staff.html">Home</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </nav>
    <div class="section1">
        <div class="maincontents">
            <h1>All Quizzes</h1>
            <table>
                <tr>
                    <th>Quiz ID</th>
                    <th>Subject</th>
                    <th>Department</th>
                    <th>Action</th>
                    <th>Marks</th> <!-- New column for Marks -->
                </tr>
                <?php
                if ($quiz_result && mysqli_num_rows($quiz_result) > 0) {
                    while ($quiz_row = mysqli_fetch_assoc($quiz_result)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($quiz_row['quiz_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($quiz_row['subject']) . '</td>';
                        echo '<td>' . htmlspecialchars($quiz_row['department']) . '</td>';
                        echo '<td><a href="staff_rank.php?quiz_id=' . htmlspecialchars($quiz_row['quiz_id']) . '">View Rank</a></td>';
                        echo '<td><a href="staff_view_mark.php?quiz_id=' . htmlspecialchars($quiz_row['quiz_id']) . '">View Marks</a></td>'; 
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">No quizzes available.</td></tr>'; // Adjusted colspan to 5
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>
