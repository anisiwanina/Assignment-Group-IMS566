<?php
session_start();
include('config.php'); 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM employees WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$employee = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $supervisor_id = mysqli_real_escape_string($conn, $_POST['supervisor_id']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    if ($employee) {
        $sql = "UPDATE employees SET 
                full_name='$full_name', position='$position', department='$department', 
                supervisor_id='$supervisor_id', phone='$phone', address='$address' 
                WHERE user_id='$user_id'";
    } else {
        $sql = "INSERT INTO employees (user_id, full_name, position, department, supervisor_id, phone, address) 
                VALUES ('$user_id', '$full_name', '$position', '$department', '$supervisor_id', '$phone', '$address')";
    }

    if (mysqli_query($conn, $sql)) {
        header('Location: userpage.php'); 
        exit();
    } else {
        $error = "Error updating profile: " . mysqli_error($conn);
    }
}

$supervisor_query = "SELECT admin_id, full_name FROM admins";
$supervisor_result = mysqli_query($conn, $supervisor_query);
$supervisors = mysqli_fetch_all($supervisor_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
    <form action="" method="post">
        <h3>Complete Your Profile</h3>
        <?php if (isset($error)) { echo '<span class="error-msg">'.$error.'</span>'; } ?>
        
        <input type="text" name="full_name" value="<?php echo $employee['full_name'] ?? ''; ?>" required placeholder="Full Name">
        <input type="text" name="position" value="<?php echo $employee['position'] ?? ''; ?>" required placeholder="Position">
        <input type="text" name="department" value="<?php echo $employee['department'] ?? ''; ?>" required placeholder="Department">
        
        <select name="supervisor_id" id="supervisor_id">
            <option value="">Select Supervisor</option>
            <?php foreach ($supervisors as $supervisor): ?>
                <option value="<?php echo $supervisor['admin_id']; ?>" 
                        <?php echo (isset($employee['supervisor_id']) && $employee['supervisor_id'] == $supervisor['admin_id']) ? 'selected' : ''; ?>>
                    <?php echo $supervisor['full_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="phone" value="<?php echo $employee['phone'] ?? ''; ?>" required placeholder="Phone Number">
        <input type="text" name="address" value="<?php echo $employee['address'] ?? ''; ?>" required placeholder="Address">

        <input type="submit" value="Save & Proceed" class="form-btn">
    </form>
</div>

</body>
</html>
