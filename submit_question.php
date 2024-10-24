<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'quiz');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from POST request
$quiz_id = $_POST['quiz_id'];
$question = $_POST['question'];
$option1 = $_POST['option1'];
$option2 = $_POST['option2'];
$option3 = $_POST['option3'];
$option4 = $_POST['option4'];
$correct_option = $_POST['correct_option'];

// Insert the new question into the database
$sql = "INSERT INTO questions (quiz_id, question, option1, option2, option3, option4, correct_option) VALUES ('$quiz_id', '$question', '$option1', '$option2', '$option3', '$option4', '$correct_option')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            setTimeout(function() {
                window.location.href = 'managequiz.php';
            }, 0); 
          </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
