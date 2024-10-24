<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'quiz');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$quiz_id = $_GET['quiz_id'];

$quiz_sql = "SELECT subject FROM quizzes WHERE quiz_id = '$quiz_id'";
$quiz_result = mysqli_query($conn, $quiz_sql);
$quiz_row = mysqli_fetch_assoc($quiz_result);
$quiz_subject = htmlspecialchars($quiz_row['subject']);

// Fetch rankings based on scores for the selected quiz
$rank_sql = "SELECT sr.student_id, s.firstname, sr.score 
             FROM results sr 
             JOIN student s ON sr.student_id = s.stud_id 
             WHERE sr.quiz_id = '$quiz_id' 
             ORDER BY sr.score DESC";

$rank_query = mysqli_query($conn, $rank_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="rank.css"> <!-- Link to your CSS file -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Rankings</title>
</head>

<body>
    <nav>
        <h3>ONLINE QUIZ</h3>
        <h1>Rankings for Quiz: <?php echo $quiz_subject; ?></h1>
        <div class="options">
            <ul>
                <li><a href="userdash.php">Back to Dashboard</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </nav>
    <div class="section1">
        <div class="maincontents">
            <h2>Ranking List</h2>
            <table border="1">
                <tr>
                    <th>Rank</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Score</th>
                </tr>
                <?php
                if ($rank_query && mysqli_num_rows($rank_query) > 0) {
                    $rank = 1;
                    while ($row = mysqli_fetch_assoc($rank_query)) {
                        echo '<tr>';
                        echo '<td>' . $rank . '</td>';
                        echo '<td>' . htmlspecialchars($row['student_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['firstname']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['score']) . '</td>';
                        echo '</tr>';
                        $rank++;
                    }
                } else {
                    echo '<tr><td colspan="4">No rankings available for this quiz.</td></tr>';
                }
                mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>
</body>

</html>
