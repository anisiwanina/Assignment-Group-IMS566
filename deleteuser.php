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
    $user_id = $conn->real_escape_string($_POST['user_id']);

    $sql = "DELETE FROM users WHERE user_id='$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Users deleted successfully'); window.location.href = 'manageuser.php';</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "'); window.location.href = 'manageuser.php';</script>";
    }

    $conn->close();
}
?>
