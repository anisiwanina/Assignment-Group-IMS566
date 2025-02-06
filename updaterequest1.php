<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "officeleaverequests";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = $_POST['request_id'];
    $status = $conn->real_escape_string($_POST['status']); 

    $check_stmt = $conn->prepare("SELECT * FROM leave_requests WHERE request_id=?");
    $check_stmt->bind_param("i", $request_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<script>alert('No record found with that Request ID'); window.location.href = 'managerequest.php';</script>";
        exit;
    }

    $stmt = $conn->prepare("UPDATE leave_requests SET status=?, approval_date=NOW() WHERE request_id=?");
    $stmt->bind_param("si", $status, $request_id); 

    if ($stmt->execute()) {
        echo "<script>alert('The information updated successfully'); window.location.href = 'managerequest.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'managerequest.php';</script>";
    }

    $stmt->close();
    $check_stmt->close();
    $conn->close();
}
?>