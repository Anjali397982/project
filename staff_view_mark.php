<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'quiz');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$quiz_id = $_GET['quiz_id']; // Get the quiz ID from the URL

// Fetch marks for the specified quiz
$marks_sql = "SELECT student_id, score FROM results WHERE quiz_id = '$quiz_id'";
$marks_result = mysqli_query($conn, $marks_sql);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="staff_view_rank.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks for Quiz ID: <?php echo htmlspecialchars($quiz_id); ?></title>
</head>

<body>
    <nav>
        <h3>ONLINE QUIZ</h3>
        <h1>Marks Details</h1>
        <div class="options">
            <ul>
                <li><a href="staff_view_rank.php">Back to Quizzes</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </nav>
    <div class="section1">
        <div class="maincontents">
            <h1>Marks for Quiz ID: <?php echo htmlspecialchars($quiz_id); ?></h1>
            <table>
                <tr>
                    <th>Student ID</th>
                    <th>Score</th>
                </tr>
                <?php
                if ($marks_result && mysqli_num_rows($marks_result) > 0) {
                    while ($marks_row = mysqli_fetch_assoc($marks_result)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($marks_row['student_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($marks_row['score']) . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="2">No marks available for this quiz.</td></tr>';
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>
