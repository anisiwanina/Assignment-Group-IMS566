<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "officeleaverequests"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start(); 

if (isset($_POST['submit'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $user_type = $_POST['user_type'];

    $check_user = "SELECT * FROM users WHERE email = '$email'";
    $result_user = mysqli_query($conn, $check_user);

    $check_admin = "SELECT * FROM admins WHERE email = '$email'";
    $result_admin = mysqli_query($conn, $check_admin);

    if (mysqli_num_rows($result_user) > 0 || mysqli_num_rows($result_admin) > 0) {
        $error[] = 'User already exists!';
    } else {
        if ($password != $cpassword) {
            $error[] = 'Passwords do not match!';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            if ($user_type == "user") {
                $insert = "INSERT INTO users (full_name, email, password_hash) VALUES ('$full_name', '$email', '$hashed_password')";
            } elseif ($user_type == "admin") {
                $insert = "INSERT INTO admins (full_name, email, password_hash) VALUES ('$full_name', '$email', '$hashed_password')";
            }

            if (mysqli_query($conn, $insert)) {
                header('Location: login.php'); 
                exit();
            } else {
                $error[] = 'Registration failed, please try again.';
            }
        }
    }
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
    <form action="" method="post">
        <h3>Register Now</h3>
        <?php
        if (isset($error)) {
            foreach ($error as $msg) {
                echo '<span class="error-msg">' . $msg . '</span>';
            }
        }
        ?>
        <input type="text" name="name" required placeholder="Enter your full name">
        <input type="email" name="email" required placeholder="Enter your email">
        <input type="password" name="password" required placeholder="Enter your password">
        <input type="password" name="cpassword" required placeholder="Confirm your password">
        <select name="user_type">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <input type="submit" name="submit" value="Register Now" class="form-btn">
        <p>Already have an account? <a href="login.php">Login now</a></p>
    </form>
</div>

</body>
</html>
