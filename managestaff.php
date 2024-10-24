<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "quiz";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle staff deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM staff WHERE staff_id='$delete_id'");
}

// Handle staff addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_staff'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phoneno = $_POST['phoneno'];
    $password = $_POST['password'];
    $department_id = $_POST['department_id'];

    // Insert staff with department
    $conn->query("INSERT INTO staff (firstname, lastname, email, phoneno, password, department_name) VALUES ('$firstname', '$lastname', '$email', '$phoneno', '$password', '$department_id')");
    $conn->query("INSERT INTO login (email, password, usercode) VALUES ('$email', '$password', 1)");
}

// Fetch departments
$departments_sql = "SELECT department_id, department_name FROM departments";
$departments_result = $conn->query($departments_sql);

$sql = "SELECT * FROM staff";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="managestaff.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Staff - Admin Dashboard</title>
</head>

<body>
    <nav>
        <h3>ONLINE QUIZ</h3>
        <h1>Admin Dashboard</h1>
        <div class="options">
            <ul>
                <li><a href="dashboard.html">Home</a></li>
                <li><a href="managestudent.php">Manage Students</a></li>
                <li><a href="managestaff.php">Manage Staff</a></li>
                <li><a href="manage_department.php">Manage Department</a></li>
                <li><a href="logout.html">Log Out</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="section1">
        <div class="sidebar">
            <div class="options2">
                <a href="manage_quiz.html">Manage Quiz</a>
                <a href="managestudent.php">Manage Students</a>
                <a href="managestaff.php">Manage Staff</a>
                <a href="managedepartment.php">Manage Department</a>
                <a href="logout.html">Log Out</a>
            </div>
        </div>
        
        <div class="maincontents">
            <h1>Manage Staff</h1>
            
            <h2>Add New Staff</h2>
            <form method="POST" action="">
                <input type="text" name="firstname" placeholder="First Name" required>
                <input type="text" name="lastname" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phoneno" placeholder="Phone No" required>
                <input type="password" name="password" placeholder="Password" required>

                <label for="department">Select Department:</label>
                <select name="department_id" required>
                    <option value="">Select a department</option>
                    <?php
                    if ($departments_result->num_rows > 0) {
                        while ($dept = $departments_result->fetch_assoc()) {
                            echo "<option value='{$dept['department_name']}'>{$dept['department_name']}</option>";
                        }
                    } else {
                        echo "<option value=''>No departments available</option>";
                    }
                    ?>
                </select>

                <button type="submit" name="add_staff">Add Staff</button>
            </form>

            <h2>Current Staff</h2>
            <table>
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone No</th>
                        <th>Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['staff_id']}</td>
                                    <td>{$row['firstname']}</td>
                                    <td>{$row['lastname']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['phoneno']}</td>
                                    <td>{$row['department_name']}</td>
                                    <td>
                                        <a href='edit_staff.php?id={$row['staff_id']}'>Edit</a>
                                        <a href='managestaff.php?delete_id={$row['staff_id']}' onclick='return confirm(\"Are you sure you want to delete this staff member?\");'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No staff found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>

        </div>
    </div>

</body>

</html>
