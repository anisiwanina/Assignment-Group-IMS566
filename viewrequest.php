<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');  
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

$user_name = $_SESSION['user_name'];

$query = "SELECT employee_id FROM employees WHERE user_id = (SELECT user_id FROM users WHERE full_name = ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_name);  
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Employee record not found!";
    exit();
}

$row = $result->fetch_assoc();
$employee_id = $row['employee_id'];
$stmt->close();

$query = "SELECT * FROM leave_requests WHERE employee_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$leave_requests = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>View Leave Requests</title>
   <link rel="stylesheet" href="vrstyle.css">
      <h2>Your Leave Requests</h2>

      <?php if ($leave_requests->num_rows > 0): ?>
         <table>
            <tr>
               <th>Leave Purpose</th>
               <th>Start Time</th>
               <th>End Time</th>
               <th>Status</th>
               <th>Request Date</th>
               <th>Date of Leave</th>
               <th>Approval Date</th>
            </tr>
            <?php while ($row = $leave_requests->fetch_assoc()): ?>
               <tr>
                  <td><?php echo htmlspecialchars($row['purpose']); ?></td>
                  <td><?php echo htmlspecialchars($row['start_time']); ?></td>
                  <td><?php echo htmlspecialchars($row['end_time']); ?></td>
                  <td><?php echo htmlspecialchars($row['status']); ?></td>
                  <td><?php echo htmlspecialchars($row['request_date']); ?></td>
                  <td><?php echo htmlspecialchars($row['date_of_leave']); ?></td>
                  <td><?php echo $row['approval_date'] ? htmlspecialchars($row['approval_date']) : 'N/A'; ?></td>
               </tr>
            <?php endwhile; ?>
         </table>
      <?php else: ?>
         <p>You haven't made any leave requests yet.</p>
      <?php endif; ?>
   </div>
</div>

<div class="content">    
            <a href="userpage.php" class="btn">User Page</a>
            <link rel="stylesheet" href="style.css">
        </div>


</body>
</html>

<?php
$conn->close();
?>
