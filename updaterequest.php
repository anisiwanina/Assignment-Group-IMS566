<?php
session_start();
include('config.php'); 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT employee_id FROM employees WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$employee = mysqli_fetch_assoc($result);

if (!$employee) {
    die("Employee record not found.");
}
$employee_id = $employee['employee_id'];

$request_query = "SELECT * FROM leave_requests WHERE employee_id = '$employee_id'";
$request_result = mysqli_query($conn, $request_query);

if (!$request_result || mysqli_num_rows($request_result) == 0) {
    die("No leave request found for this employee.");
}

$leave_request = mysqli_fetch_assoc($request_result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
    $start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($conn, $_POST['end_time']);
    $date_of_leave = mysqli_real_escape_string($conn, $_POST['date_of_leave']);

    $update_query = "UPDATE leave_requests SET 
                     purpose = '$purpose', 
                     start_time = '$start_time', 
                     end_time = '$end_time', 
                     date_of_leave = '$date_of_leave' 
                     WHERE employee_id = '$employee_id' AND request_id = '" . $leave_request['request_id'] . "'";
    
    if (mysqli_query($conn, $update_query)) {
        header('Location: userpage.php');
        exit();
    } else {
        $error = "Error updating request: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Leave Request</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
    <form action="updaterequest.php" method="post">
        <h3>Update Leave Request</h3>
        <?php if (isset($error)) { echo '<span class="error-msg">'.$error.'</span>'; } ?>

        <textarea name="purpose" rows="4" placeholder="Enter leave purpose" required><?php echo htmlspecialchars($leave_request['purpose']); ?></textarea>
        <input type="date" name="date_of_leave" value="<?php echo htmlspecialchars($leave_request['date_of_leave']); ?>" required placeholder="Date of Leave">
        <input type="time" name="start_time" value="<?php echo htmlspecialchars($leave_request['start_time']); ?>" required placeholder="Start Time">
        <input type="time" name="end_time" value="<?php echo htmlspecialchars($leave_request['end_time']); ?>" required placeholder="End Time">

        <input type="submit" value="Update Request" class="form-btn">
    </form>
</div>

</body>
</html>
