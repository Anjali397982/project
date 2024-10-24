<?php
session_start(); // Start the session

$con = mysqli_connect("localhost", "root", "", "quiz");
if (!$con) {
    die("Database not connected");
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM `login` WHERE `email`='$email' AND `password`='$password'";
    $data = mysqli_query($con, $sql);
    echo "$sql";

    if ($data && mysqli_num_rows($data) > 0) {
        echo "hi";
        $user = mysqli_fetch_assoc($data);

            $usercode = $user['usercode'];

            if ($usercode == '0') {
                $student_sql = "SELECT `stud_id` FROM `student` WHERE `email`='$email'";
                $student_data = mysqli_query($con, $student_sql);

                if ($student_data && mysqli_num_rows($student_data) > 0) {
                    $student = mysqli_fetch_assoc($student_data);
                    $_SESSION['user_id'] = $student['stud_id']; // Store student ID in session
                    $_SESSION['email'] = $email; // Store email in session
                    header('Location: userdash.php'); // Redirect for students
                } else {
                    echo "<script>alert('Student record not found')</script>";
                }
            } elseif ($usercode == '1') {
                $staff_sql = "SELECT `staff_id` FROM `staff` WHERE `email`='$email'";
                $staff_data = mysqli_query($con, $staff_sql);

                if ($staff_data && mysqli_num_rows($staff_data) > 0) {
                    $staff = mysqli_fetch_assoc($staff_data);
                    $_SESSION['staffid'] = $staff['staff_id']; // Store staff ID in session
                    $_SESSION['staff_email'] =  $staff['email']; // Store email in session
                    header('Location: staff.html'); // Redirect for staff
                } else {
                    echo "<script>alert('Staff record not found')</script>";
                }
            } else {
                $_SESSION['email'] = $email; // Store email in session
                header('Location: admin.php'); // Redirect for admin
            }
            exit();
        } 
    } 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ONLINE QUIZ SYSTEM</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="form">
        <form action="" method="POST">
            <h1>Login</h1>
            <input name="email" type="email" placeholder="Email" required><br>
            <input name="password" type="password" placeholder="Password" required><br>
            <button type="submit" name="submit">SUBMIT</button>
        </form>
    </div>
</body>
</html>
