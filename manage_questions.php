<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'quiz');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$quiz_id = $_GET['quiz_id']; // Get the quiz ID from the URL
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="managequiz.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Questions</title>
</head>

<body>
    <nav>
        <h3>ONLINE QUIZ</h3>
        <h1>Manage Questions</h1>
        <div class="options">
            <ul>
                <li><a href="staff_dashboard.php">Home</a></li>
            </ul>
        </div>
    </nav>
    <div class="section1">
        <div class="maincontents">
            <h2>Questions for Quiz ID: <?php echo htmlspecialchars($quiz_id); ?></h2>
            <table border="1">
                <tr>
                    <th>Question ID</th>
                    <th>Question</th>
                    <th>Action</th>
                </tr>
                <?php
                // Fetch questions for the selected quiz
                $question_sql = "SELECT question_id, question FROM questions WHERE quiz_id = '$quiz_id'";
                $question_result = mysqli_query($conn, $question_sql);
                if ($question_result && mysqli_num_rows($question_result) > 0) {
                    while ($question_row = mysqli_fetch_assoc($question_result)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($question_row['question_id']) . '</td>';
                        echo '<td>' . htmlspecialchars($question_row['question']) . '</td>';
                        echo '<td><a href="edit_question.php?question_id=' . htmlspecialchars($question_row['question_id']) . '">Edit</a> | <a href="delete_question.php?question_id=' . htmlspecialchars($question_row['question_id']) . '">Delete</a></td>'; // Links for edit and delete
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="3">No questions found for this quiz.</td></tr>';
                }
                mysqli_close($conn);
                ?>
            </table>
            <a href="add_question.php?quiz_id=<?php echo htmlspecialchars($quiz_id); ?>">Add New Question</a> <!-- Link to add new question -->
        </div>
    </div>
</body>

</html>
