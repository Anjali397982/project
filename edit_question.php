<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'quiz');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$question_id = $_GET['question_id']; // Get the question ID from the URL

// Fetch the existing question details and options
$question_sql = "SELECT question, option1, option2, option3, option4 FROM questions WHERE question_id = '$question_id'";
$question_result = mysqli_query($conn, $question_sql);

if ($question_result && mysqli_num_rows($question_result) > 0) {
    $question_row = mysqli_fetch_assoc($question_result);
    $question = htmlspecialchars($question_row['question']);
    $options = [
        htmlspecialchars($question_row['option1']),
        htmlspecialchars($question_row['option2']),
        htmlspecialchars($question_row['option3']),
        htmlspecialchars($question_row['option4'])
    ];
} else {
    die("Question not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="managequiz.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
</head>

<body>
    <nav>
        <h3>ONLINE QUIZ</h3>
        <h1>Edit Question</h1>
        <div class="options">
            <ul>
                <li><a href="staff_dashboard.php">Home</a></li>
            </ul>
        </div>
    </nav>
    <div class="section1">
        <div class="maincontents">
            <h2>Edit Question ID: <?php echo htmlspecialchars($question_id); ?></h2>
            <form action="update_question.php" method="post">
                <input type="hidden" name="question_id" value="<?php echo htmlspecialchars($question_id); ?>">
                <label for="question">Question:</label>
                <textarea id="question" name="question" required><?php echo $question; ?></textarea>
                <br><br>

                <h3>Edit Options:</h3>
                <?php foreach ($options as $index => $option): ?>
                    <label for="option<?php echo $index + 1; ?>">Option <?php echo $index + 1; ?>:</label>
                    <input type="text" id="option<?php echo $index + 1; ?>" name="option<?php echo $index + 1; ?>" value="<?php echo $option; ?>" required>
                    <br><br>
                <?php endforeach; ?>
                
                <input type="submit" value="Update Question">
            </form>
            <a href="manage_questions.php?quiz_id=<?php echo htmlspecialchars($_GET['question_id']); ?>">Back to Questions</a> <!-- Corrected Link -->
        </div>
    </div>
</body>

</html>

<?php
mysqli_close($conn);
?>
