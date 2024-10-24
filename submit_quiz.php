<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'quiz');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from POST request
$department = $_POST['department'];
$subject = $_POST['subject'];
$time_limit = $_POST['time'] * 60; // Convert minutes to seconds
$year = $_POST['year']; // Get the year from POST request

// Insert the new quiz into the database
$sql = "INSERT INTO quizzes (department, subject, time_limit, year) VALUES ('$department', '$subject', '$time_limit', '$year')";

if ($conn->query($sql) === TRUE) {
    echo "New quiz created successfully.";
    header("Location: staff.html");
}
     else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
