<?php
session_start();
include('config.php'); 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT e.*, a.full_name AS supervisor_name FROM employees e
          LEFT JOIN admins a ON e.supervisor_id = a.admin_id
          WHERE e.user_id = '$user_id'";

$result = mysqli_query($conn, $query);
$employee = mysqli_fetch_assoc($result);

if (!$employee) {
    header('Location: employeeprofile.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link rel="stylesheet" href="vpstyle.css">

</head>
<body>

<div class="profile-container">
    <h3>Your Profile</h3>
    <table class="profile-table">
        <tr>
            <th>Full Name:</th>
            <td><?php echo htmlspecialchars($employee['full_name']); ?></td>
        </tr>
        <tr>
            <th>Position:</th>
            <td><?php echo htmlspecialchars($employee['position']); ?></td>
        </tr>
        <tr>
            <th>Department:</th>
            <td><?php echo htmlspecialchars($employee['department']); ?></td>
        </tr>
        <tr>
            <th>Supervisor:</th>
            <td><?php echo htmlspecialchars($employee['supervisor_name']) ? $employee['supervisor_name'] : 'No supervisor assigned'; ?></td>
        </tr>
        <tr>
            <th>Phone:</th>
            <td><?php echo htmlspecialchars($employee['phone']); ?></td>
        </tr>
        <tr>
            <th>Address:</th>
            <td><?php echo htmlspecialchars($employee['address']); ?></td>
        </tr>
    </table>

    <a href="employeeprofile.php" class="edit-btn">Edit Profile</a>
    <a href="userpage.php" class="edit-btn">User Page</a>
</div>

</body>
</html>
