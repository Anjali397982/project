<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "quiz";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get staff ID from URL
if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];
    
    // Fetch existing staff details
    $sql = "SELECT * FROM staff WHERE staff_id='$staff_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $staff = $result->fetch_assoc();
    } else {
        echo "Staff not found.";
        exit();
    }
}

// Handle staff update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_staff'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phoneno = $_POST['phoneno'];

    $conn->query("UPDATE staff SET firstname='$firstname', lastname='$lastname', email='$email', phoneno='$phoneno' WHERE staff_id='$staff_id'");
    header("Location: managestaff.php"); // Redirect to the staff management page
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="managestaff.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff - Admin Dashboard</title>
</head>

<body>
    <nav>
        <h3>ONLINE QUIZ</h3>
        <h1>Edit Staff</h1>
        <div class="options">
            <ul>
                <li><a href="dashboard.html">Home</a></li>
                <li><a href="managestudent.php">Manage Students</a></li>
                <li><a href="managestaff.php">Manage Staff</a></li>
                <li><a href="manage_parent.html">Manage Parents</a></li>
                <li><a href="logout.html">Log Out</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="section1">
        <div class="maincontents">
            <h1>Edit Staff</h1>
            
            <form method="POST" action="">
                <input type="text" name="firstname" value="<?php echo htmlspecialchars($staff['firstname']); ?>" placeholder="First Name" required>
                <input type="text" name="lastname" value="<?php echo htmlspecialchars($staff['lastname']); ?>" placeholder="Last Name" required>
                <input type="email" name="email" value="<?php echo htmlspecialchars($staff['email']); ?>" placeholder="Email" required>
                <input type="text" name="phoneno" value="<?php echo htmlspecialchars($staff['phoneno']); ?>" placeholder="Phone No" required>
                <button type="submit" name="update_staff">Update Staff</button>
            </form>
        </div>
    </div>

</body>

</html>
