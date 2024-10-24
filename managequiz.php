<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="managequiz.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Quiz</title>
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
                <a href="manage_quiz.php">Manage Quiz</a>
                <a href="addquiz.php">Add Quiz</a>
                <a href="staff_manage_student.php">Manage Students</a>
                <a href="logout.php">Log Out</a>
            </div>
        </div>
        <div class="maincontents">
            <h1>Manage Quizzes</h1>
            
            <h2>Your Department: 
                <?php
                session_start();
                $staff_id = $_SESSION['staffid']; 
                $conn = new mysqli('localhost', 'root', '', 'quiz'); 
                
                // Fetch department of the staff
                $staff_sql = "SELECT department_name FROM staff WHERE staff_id = $staff_id"; 
                $staff_result = mysqli_query($conn, $staff_sql);
                if ($staff_result && mysqli_num_rows($staff_result) > 0) {
                    $staff_row = mysqli_fetch_assoc($staff_result);
                    echo htmlspecialchars($staff_row['department_name']);
                } else {
                    echo "Department not found.";
                }
                ?>
            </h2>

            <h2>Quizzes in Your Department:</h2>
            <table border="1">
                <tr>
                    <th>Quiz ID</th>
                    <th>Subject</th>
                    <th>Time Limit (min)</th>
                    <th>Action</th>
                    <th>Manage Questions</th>
                </tr>
                <?php
                // Fetch quizzes for the department
                $department = isset($staff_row['department_name']) ? $staff_row['department_name'] : '';
                if ($department) {
                    $quiz_sql = "SELECT quiz_id, subject, time_limit FROM quizzes WHERE department = '$department'";
                    $quiz_result = mysqli_query($conn, $quiz_sql);
                    if ($quiz_result && mysqli_num_rows($quiz_result) > 0) {
                        while ($quiz_row = mysqli_fetch_assoc($quiz_result)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($quiz_row['quiz_id']) . '</td>';
                            echo '<td>' . htmlspecialchars($quiz_row['subject']) . '</td>';
                            echo '<td>' . htmlspecialchars($quiz_row['time_limit']) . '</td>';
                            echo '<td><a href="add_question.php?quiz_id=' . htmlspecialchars($quiz_row['quiz_id']) . '">Add Question</a></td>'; // Link to add questions
                            echo '<td><a href="manage_questions.php?quiz_id=' . htmlspecialchars($quiz_row['quiz_id']) . '">Manage Questions</a></td>'; // Link to manage questions
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">No quizzes found for your department.</td></tr>';
                    }
                }
                mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>
</body>

</html>
