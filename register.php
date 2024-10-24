<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ONLINE QUIZ SYSTEM</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="form">
        <form action="" method="post">
            <h1>REGISTER</h1>
            <input name="FIRSTNAME" type="text" placeholder="firstname" required><br>
            <input name="LASTNAME" type="text" placeholder="lastname" required><br>
            <input name="AGE" type="text" placeholder="age" required><br>
            <input name="DOB" type="date" placeholder="DOB" required><br>
            <input name="GENDER" type="text" placeholder="gender" required><br>
            <input name="EMAIL" type="email" placeholder="email" required><br>
            <input name="PHONENO" type="text" placeholder="phoneno" required><br>
            <input name="PASSWORD" type="password" placeholder="password" required><br>
            
            <label for="department">Select Department:</label>
            <select name="DEPARTMENT" id="department" required>
                <option value="" disabled selected>Select your department</option>
                <?php
                $con = mysqli_connect("localhost", "root", "", "quiz");
                if (!$con) {
                    die("Database not found");
                }

                $dept_sql = "SELECT * FROM departments"; // Adjust table name if necessary
                $dept_result = mysqli_query($con, $dept_sql);

                while ($row = mysqli_fetch_assoc($dept_result)) {
                    echo "<option value='{$row['department_name']}'>{$row['department_name']}</option>";
                }
                ?>
            </select><br>

            <label for="year">Select Year:</label>
            <select name="YEAR" id="year" required>
                <option value="" disabled selected>Select your Sem</option>
                <option value="1">1st Sem</option>
                <option value="2">2nd Sem</option>
                <option value="3">3rd Sem</option>
                <option value="4">4th Sem</option>
                <option value="5">5th Sem</option>
                <option value="6">6th Sem</option>

            </select><br>

            <button type="submit" name="submit">REGISTER</button>
            <p>Already Have an account? <a href="login.php">Sign up</a></p>
        </form>
    </div>
</body>
</html>

<?php
$con = mysqli_connect("localhost", "root", "", "quiz");
if (!$con) {
    die("Database not found");
}

if (isset($_POST['submit'])) {
    $firstname = $_POST['FIRSTNAME'];
    $lastname = $_POST['LASTNAME'];
    $age = $_POST['AGE'];
    $dob = $_POST['DOB'];
    $gender = $_POST['GENDER'];
    $password = $_POST['PASSWORD'];
    $email = $_POST['EMAIL'];
    $phone_number = $_POST['PHONENO'];
    $department = $_POST['DEPARTMENT'];
    $year = $_POST['YEAR'];

    // Validating the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
        exit;
    }

    // Validating the phone number (10 digits starting with 7, 8, or 9)
    if (!preg_match('/^[789]\d{9}$/', $phone_number)) {
        echo "<script>alert('Please enter a valid Indian phone number (10 digits starting with 7, 8, or 9).');</script>";
        exit;
    }

    // Validating the password (at least 8 characters, including a number and a special character)
    if (!preg_match('/^(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        echo "<script>alert('Password must be at least 8 characters long, including at least one number and one special character.');</script>";
        exit;
    }


    $sql = "INSERT INTO `student`(`firstname`, `lastname`, `age`, `DOB`, `gender`, `password`, `email`, `phoneno`, `department`, `year`) 
            VALUES('$firstname','$lastname','$age','$dob','$gender', '$password', '$email', '$phone_number', '$department', '$year')";
    
    $sql1 = "INSERT INTO `login`(`email`, `Password`, `usercode`) VALUES ('$email','$password',0)";

    $data = mysqli_query($con, $sql);
    $data1 = mysqli_query($con, $sql1);
    
    if ($data && $data1) {
        echo "<script>alert('Registration successful');</script>";
    } else {
        echo "<script>alert('Failed to register. Please try again.');</script>";
    }
}
?>
