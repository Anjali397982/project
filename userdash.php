<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'quiz');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$student_id = $_SESSION['user_id']; 

// Fetch the student's department and year
$student_sql = "SELECT department, year FROM student WHERE stud_id = '$student_id'";
$student_result = mysqli_query($conn, $student_sql);
$student_row = mysqli_fetch_assoc($student_result);
$student_department = $student_row['department'];
$student_year = $student_row['year'];

// Fetch available quizzes for the student's department and year
$quiz_sql = "SELECT quiz_id, subject, time_limit FROM quizzes WHERE department = '$student_department' AND year = '$student_year'";
$quiz_result = mysqli_query($conn, $quiz_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="userdash.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
</head>

<body>
    <nav>
        <h3>ONLINE QUIZ</h3>
        <h1>Student Dashboard</h1>
        <div class="options">
            <ul>
                <li><a href="result.php">Result</a></li>
                <li><a href="userprofile.php">Profile</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </nav>
    <div class="section1">
        <div class="maincontents">
            <h2>Available Quizzes for Department: <?php echo htmlspecialchars($student_department); ?>, Year: <?php echo htmlspecialchars($student_year); ?></h2>
            <table border="1">
                <tr>
                    <th>Quiz ID</th>
                    <th>Subject</th>
                    <th>Time Limit (min)</th>
                    <th>Action</th>
                </tr>
                <?php
                if ($quiz_result && mysqli_num_rows($quiz_result) > 0) {
                    while ($quiz_row = mysqli_fetch_assoc($quiz_result)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($quiz_row['quiz_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($quiz_row['subject']) . '</td>';
                        echo '<td>' . htmlspecialchars($quiz_row['time_limit']) . '</td>';
                        
                        // Check if the student has already submitted this quiz
                        $quiz_id = htmlspecialchars($quiz_row['quiz_id']);
                        $submission_sql = "SELECT * FROM results WHERE student_id = '$student_id' AND quiz_id = '$quiz_id'";
                        $submission_result = mysqli_query($conn, $submission_sql);

                        if (mysqli_num_rows($submission_result) > 0) {
                            // Already submitted, show rank link
                            echo '<td><a href="rank.php?quiz_id=' . $quiz_id . '">View Rank</a></td>';
                        } else {
                            // Not submitted, show take quiz link
                            echo '<td><a href="take_quiz.php?quiz_id=' . $quiz_id . '">Take Quiz</a></td>';
                        }
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4">No quizzes available for your department and year.</td></tr>';
                }
                mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>
</body>

</html>
