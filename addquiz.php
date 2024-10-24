<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="addquiz.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Quiz</title>
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
            <h1>Add a New Quiz</h1>
            <form action="submit_quiz.php" method="post">
                <?php
                session_start();
                $staff_id = $_SESSION['staffid']; // Assuming you have stored staff id in session

                // Connect to database
                $conn = new mysqli('localhost', 'root', '', 'quiz');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch department based on logged-in teacher
                $staff_sql = "SELECT department_name FROM staff WHERE staff_id = '$staff_id'";
                $staff_result = $conn->query($staff_sql);
                if ($staff_result && $staff_row = $staff_result->fetch_assoc()) {
                    $department = htmlspecialchars($staff_row['department_name']);
                } else {
                    die("Staff information not found.");
                }
                ?>

                <input type="hidden" name="department" value="<?php echo $department; ?>">

                <label for="subject">Subject Name:</label>
                <input type="text" id="subject" name="subject" required>
                <br><br>

                <label for="year">Select Sem:</label>
                <select id="year" name="year" required>
                    <option value="" disabled selected>Select Sem</option>
                    <option value="1">1st Sem</option>
                    <option value="2">2nd Sem</option>
                    <option value="3">3rd Sem</option>
                    <option value="1">4th Sem</option>
                    <option value="2">5th Sem</option>
                    <option value="3">6th Sem</option>
                    

                </select>
                <br><br>

                <label for="time">Time Limit (in minutes):</label>
                <input type="number" id="time" name="time" required min="1">
                <br><br>

                <input type="submit" value="Create Quiz">
            </form>
        </div>
    </div>
</body>

</html>
