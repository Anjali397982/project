<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'quiz');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Assuming the student ID is stored in the session
$student_id = $_SESSION['user_id'] ?? null; // Get student ID from session
$quiz_id = $_POST['quiz_id'];
$submitted = $_POST['submitted'] ?? 'false'; 

if ($submitted === 'false') {
    $score = 0;
    // Include student ID in the results table
    $sql = "INSERT INTO results (quiz_id, student_id, score) VALUES ('$quiz_id', '$student_id', 0)";
    mysqli_query($conn, $sql);
    
    echo '<script>
            alert("Time\'s up! You scored 0.");
            setTimeout(function() {
                window.location.href = "userdash.php";
            }, 300);
          </script>';
} else {
    $score = 0;
    foreach ($_POST['answer'] as $question_id => $answer) {
        $score++; // Increment score for demonstration; replace this with actual scoring logic
    }

    // Include student ID in the results table
    $sql = "INSERT INTO results (quiz_id, student_id, score) VALUES ('$quiz_id', '$student_id', '$score')";
    mysqli_query($conn, $sql);

    echo '<script>
            alert("Quiz Completed! Your Score: ' . $score . '");
            setTimeout(function() {
                window.location.href = "userdash.php";
            }, 300);
          </script>';
}

mysqli_close($conn);
?>
