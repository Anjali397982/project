<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="add_question.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question</title>
</head>

<body>
<nav>
        <h3>ONLINE QUIZ</h3>
        <h1>STAFF Dashboard</h1>
        <div class="options">
            <ul>
                <li><a href="staff_dashboard.php">Home</a></li>
            </ul>
        </div>
    </nav>
    <div class="section1">
    <div class="sidebar">
            <div class="options2">
                <a href="staff.html">Dashboard</a>
                <a href="managequiz.php">Manage Quiz</a>
                <a href="addquiz.php">Add Quiz</a>
                <a href="staff_manage_student.php">Manage Students</a>
                <a href="logout.php">Log Out</a>
            </div>
        </div>
        <div class="maincontents">
            <h1>Add a Question to Quiz</h1>
            <?php
            session_start();
            $quiz_id = $_GET['quiz_id']; // Get quiz ID from URL

            // Connect to database
            $conn = new mysqli('localhost', 'root', '', 'quiz');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            ?>

            <form action="submit_question.php" method="post">
                <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quiz_id); ?>">

                <label for="question">Question:</label><br>
                <textarea id="question" name="question" required></textarea>
                <br><br>

                <label for="option1">Option 1:</label><br>
                <input type="text" id="option1" name="option1" required>
                <br><br>

                <label for="option2">Option 2:</label><br>
                <input type="text" id="option2" name="option2" required>
                <br><br>

                <label for="option3">Option 3:</label><br>
                <input type="text" id="option3" name="option3" required>
                <br><br>

                <label for="option4">Option 4:</label><br>
                <input type="text" id="option4" name="option4" required>
                <br><br>

                <label for="correct_option">Correct Option (1-4):</label><br>
                <input type="number" id="correct_option" name="correct_option" required min="1" max="4">
                <br><br>

                <input type="submit" value="Add Question">
            </form>
        </div>
    </div>
</body>

</html>
