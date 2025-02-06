<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  
    exit();
}

$host = 'localhost'; 
$username = 'root';  
$password = '';  
$database = 'officeleaverequests';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

$query = "SELECT employee_id FROM employees WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Employee record not found!";
    exit();
}

$row = $result->fetch_assoc();
$employee_id = $row['employee_id'];
$stmt->close();

$admin_id = null; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $purpose = $_POST['purpose'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $date_of_leave = $_POST['date_of_leave'];  

    $insert_query = "INSERT INTO leave_requests (employee_id, admin_id, purpose, start_time, end_time, date_of_leave) 
                     VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("iissss", $employee_id, $admin_id, $purpose, $start_time, $end_time, $date_of_leave);

    if ($stmt->execute()) {
        header("Location: userpage.php");
        exit(); 
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request Form</title>
    <link rel="stylesheet" href="rfstyle.css"> 
</head>
<body>
    <div class="form-container">
        <form action="requestform.php" method="POST">
            <h3>Leave Request Form</h3>

            <label for="purpose">Leave Purpose:</label><br>
            <textarea id="purpose" name="purpose" rows="4" cols="50" required></textarea><br>
            <div class="separator"></div>

            <label for="date_of_leave">Date of Leave:</label><br>
            <input type="date" id="date_of_leave" name="date_of_leave" required><br>
            <div class="separator"></div>

            <label for="start_time">Start Time:</label><br>
            <input type="time" id="start_time" name="start_time" required><br>
            <div class="separator"></div>

            <label for="end_time">End Time:</label><br>
            <input type="time" id="end_time" name="end_time" required><br>
            <div class="separator"></div>

            <input type="submit" value="Submit Leave Request" class="form-btn">
        </form>
    </div>
</body>
</html>
