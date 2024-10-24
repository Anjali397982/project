<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'quiz');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from POST request
$question_id = $_POST['question_id'];
$question = $_POST['question'];

// Update the question in the database
$sql = "UPDATE questions SET question = '$question' WHERE question_id = '$question_id'";
if (mysqli_query($conn, $sql)) {
    echo "Question updated successfully.";
    echo '<script>window.location.href="manage_questions.php?quiz_id=' . htmlspecialchars($_GET['quiz_id']) . '";</script>';
} else {
    echo "Error updating question: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
