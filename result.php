<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'quiz');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$student_id = $_SESSION['user_id'];

// Fetch results for the logged-in student
$result_sql = "SELECT qr.quiz_id, q.subject, qr.score 
                FROM results qr 
                JOIN quizzes q ON qr.quiz_id = q.quiz_id 
                WHERE qr.student_id = '$student_id' 
                ";
$result_query = mysqli_query($conn, $result_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="result.css"> <!-- Link to your CSS file -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
</head>

<body>
    <nav>
        <h3>ONLINE QUIZ</h3>
        <h1>Quiz Results</h1>
        <div class="options">
            <ul>
                <li><a href="userdash.php">Back to Dashboard</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </nav>
    <div class="section1">
        <div class="maincontents">
            <h2>Your Quiz Results</h2>
            <table border="1">
                <tr>
                    <th>Quiz ID</th>
                    <th>Subject</th>
                    <th>Score</th>
                </tr>
                <?php
                if ($result_query && mysqli_num_rows($result_query) > 0) {
                    while ($row = mysqli_fetch_assoc($result_query)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['quiz_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['subject']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['score']) . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4">No quiz results found.</td></tr>';
                }
                mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>
</body>

</html>
