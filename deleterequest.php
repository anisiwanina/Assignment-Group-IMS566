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
    $request_id = $conn->real_escape_string($_POST['request_id']);

    $sql = "DELETE FROM leave_requests WHERE request_id='$request_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Booking deleted successfully'); window.location.href = 'managerequest.php';</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "'); window.location.href = 'managerequest.php';</script>";
    }

    $conn->close();
}
?>
