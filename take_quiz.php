<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'quiz');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$quiz_id = $_GET['quiz_id']; // Get the quiz ID from the URL

// Fetch quiz details including time limit
$quiz_sql = "SELECT time_limit FROM quizzes WHERE quiz_id = '$quiz_id'";
$quiz_result = mysqli_query($conn, $quiz_sql);
$quiz_row = mysqli_fetch_assoc($quiz_result);
$time_limit = $quiz_row['time_limit']; // Time limit in minutes
$time_limit_seconds = $time_limit * 60; // Convert minutes to seconds

// Fetch questions for the quiz
$question_sql = "SELECT question_id, question, option1, option2, option3, option4 FROM questions WHERE quiz_id = '$quiz_id'";
$question_result = mysqli_query($conn, $question_sql);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="take_quiz.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Quiz</title>
    <script>
        // Timer function
        let timeLeft = <?php echo $time_limit_seconds; ?>; // Total time in seconds
        let submitted = false; // Flag to check if the quiz is submitted

        function startTimer() {
            const timerDisplay = document.getElementById("timer");
            const interval = setInterval(() => {
                if (timeLeft <= 0) {
                    clearInterval(interval);
                    document.getElementById("quizForm").elements['submitted'].value = 'false'; // Mark as timed out
                    document.getElementById("quizForm").submit(); // Submit the form when time is up
                } else {
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    timerDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`; // Update display
                    timeLeft--;
                }
            }, 1000);
        }

        window.onload = startTimer; // Start the timer when the page loads
    </script>
</head>

<body>
    <nav>
        <h3>ONLINE QUIZ</h3>
        <h1>Take Quiz</h1>
        <div class="options">
            <ul>
                <li><a href="user_dashboard.php">Back to Dashboard</a></li>
            </ul>
        </div>
    </nav>
    <div class="section1">
        <div class="maincontents">
            <h2>Quiz ID: <?php echo htmlspecialchars($quiz_id); ?></h2>
            <div>
                <strong>Time Remaining: <span id="timer">00:00</span></strong>
            </div>
            <form id="quizForm" action="user_submit_quiz.php" method="post">
                <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quiz_id); ?>"> <!-- Hidden quiz_id field -->
                <input type="hidden" name="submitted" value="true"> <!-- Flag to check if quiz was submitted with answers -->
                <?php
                if ($question_result && mysqli_num_rows($question_result) > 0) {
                    while ($question_row = mysqli_fetch_assoc($question_result)) {
                        echo '<div>';
                        echo '<p>' . htmlspecialchars($question_row['question']) . '</p>';
                        echo '<label>';
                        echo '<input type="radio" name="answer[' . htmlspecialchars($question_row['question_id']) . ']" value="1" required>'; // Option 1
                        echo htmlspecialchars($question_row['option1']);
                        echo '</label><br>';
                        echo '<label>';
                        echo '<input type="radio" name="answer[' . htmlspecialchars($question_row['question_id']) . ']" value="2" required>'; // Option 2
                        echo htmlspecialchars($question_row['option2']);
                        echo '</label><br>';
                        echo '<label>';
                        echo '<input type="radio" name="answer[' . htmlspecialchars($question_row['question_id']) . ']" value="3" required>'; // Option 3
                        echo htmlspecialchars($question_row['option3']);
                        echo '</label><br>';
                        echo '<label>';
                        echo '<input type="radio" name="answer[' . htmlspecialchars($question_row['question_id']) . ']" value="4" required>'; // Option 4
                        echo htmlspecialchars($question_row['option4']);
                        echo '</label><br>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No questions found for this quiz.</p>';
                }
                ?>
                <input type="submit" value="Submit Quiz">
            </form>
        </div>
    </div>
</body>

</html>
