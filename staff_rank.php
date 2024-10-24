<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'quiz');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$quiz_id = $_GET['quiz_id']; // Get the quiz ID from the URL

// Fetch ranks for the specified quiz
$rank_sql = "SELECT student_id, score FROM results WHERE quiz_id = '$quiz_id' ORDER BY score DESC";
$rank_result = mysqli_query($conn, $rank_sql);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="staff_rank.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rank for Quiz ID: <?php echo htmlspecialchars($quiz_id); ?></title>
</head>

<body>
    <nav>
        <h3>ONLINE QUIZ</h3>
        <h1>Rank Details</h1>
        <div class="options">
            <ul>
                <li><a href="staff_view_rank.php">Back to Quizzes</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </nav>
    <div class="section1">
        <div class="maincontents">
            <h1>Rankings for Quiz ID: <?php echo htmlspecialchars($quiz_id); ?></h1>
            <table>
                <tr>
                    <th>Rank</th>
                    <th>Student ID</th>
                    <th>Score</th>
                </tr>
                <?php
                if ($rank_result && mysqli_num_rows($rank_result) > 0) {
                    $rank = 1;
                    while ($rank_row = mysqli_fetch_assoc($rank_result)) {
                        echo '<tr>';
                        echo '<td>' . $rank . '</td>';
                        echo '<td>' . htmlspecialchars($rank_row['student_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($rank_row['score']) . '</td>';
                        echo '</tr>';
                        $rank++;
                    }
                } else {
                    echo '<tr><td colspan="3">No results available for this quiz.</td></tr>';
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>
