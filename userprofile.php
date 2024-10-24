<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'quiz');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$student_id = $_SESSION['user_id']; // Assuming user_id is stored in session

// Fetch the student's current profile information
$profile_sql = "SELECT * FROM student WHERE stud_id = '$student_id'";
$profile_result = mysqli_query($conn, $profile_sql);
$profile_row = mysqli_fetch_assoc($profile_result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update profile logic
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $age = (int)$_POST['age'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phoneno = $_POST['phoneno'];
    $year = (int)$_POST['year'];
    $department = $_POST['department'];
    
    // Optional: Update password logic if provided
    if (!empty($_POST['password'])) {
        $password = $_POST['password'];
        $update_sql = "UPDATE student SET firstname='$firstname', lastname='$lastname', age='$age', DOB='$dob', gender='$gender', password='$password', email='$email', phoneno='$phoneno', year='$year', department='$department' WHERE stud_id='$student_id'";
    } else {
        $update_sql = "UPDATE student SET firstname='$firstname', lastname='$lastname', age='$age', DOB='$dob', gender='$gender', email='$email', phoneno='$phoneno', year='$year', department='$department' WHERE stud_id='$student_id'";
    }
    
    if (mysqli_query($conn, $update_sql)) {
        echo "Profile updated successfully.";
        // Refresh profile data after update
        $profile_row = mysqli_fetch_assoc(mysqli_query($conn, $profile_sql));
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="userprofile.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
</head>
<body>
    <nav>
        <h3>ONLINE QUIZ</h3>
        <h1>Your Profile</h1>
        <div class="options">
            <ul>
                <li><a href="userdash.php">Dashboard</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </nav>
    <div class="section1">
        <div class="maincontents">
            <h2>Profile Information</h2>
            <form action="" method="post">
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo $profile_row['firstname']; ?>" required><br>

                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo $profile_row['lastname']; ?>" required><br>

                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo $profile_row['age']; ?>" required><br>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo $profile_row['DOB']; ?>" required><br>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="Male" <?php echo ($profile_row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($profile_row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo ($profile_row['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Leave blank to keep current password"><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $profile_row['email']; ?>" required><br>

                <label for="phoneno">Phone Number:</label>
                <input type="text" id="phoneno" name="phoneno" value="<?php echo $profile_row['phoneno']; ?>" required><br>

                <label for="year">Year:</label>
                <input type="number" id="year" name="year" value="<?php echo $profile_row['year']; ?>" required><br>

                <label for="department">Department:</label>
                <input type="text" id="department" name="department" value="<?php echo $profile_row['department']; ?>" required><br>

                <input type="submit" value="Update Profile">
            </form>
        </div>
    </div>
</body>
</html>
