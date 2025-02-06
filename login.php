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
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query_user = "SELECT * FROM users WHERE email = '$email'";
    $result_user = mysqli_query($conn, $query_user);

    $query_admin = "SELECT * FROM admins WHERE email = '$email'";
    $result_admin = mysqli_query($conn, $query_admin);

    if (mysqli_num_rows($result_user) > 0) {
        $row = mysqli_fetch_assoc($result_user);

        if (strlen($row['password_hash']) < 60) {
            $password_hash = password_hash($row['password_hash'], PASSWORD_DEFAULT);

            $update_sql = "UPDATE users SET password_hash = '$password_hash' WHERE email = '$email'";
            mysqli_query($conn, $update_sql);
            $row['password_hash'] = $password_hash;  
        }

        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['full_name'];
            header('Location: userpage.php'); 
            exit();
        } else {
            $error[] = 'Incorrect email or password!';
        }
    } elseif (mysqli_num_rows($result_admin) > 0) {
        $row = mysqli_fetch_assoc($result_admin);

        if (strlen($row['password_hash']) < 60) {
            $password_hash = password_hash($row['password_hash'], PASSWORD_DEFAULT);

            $update_sql = "UPDATE admins SET password_hash = '$password_hash' WHERE email = '$email'";
            mysqli_query($conn, $update_sql);
            $row['password_hash'] = $password_hash;  
        }

        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['admin_name'] = $row['full_name'];
            header('Location: adminpage.php'); 
            exit();
        } else {
            $error[] = 'Incorrect email or password!';
        }
    } else {
        $error[] = 'Incorrect email or password!';
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
    <title>Login Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
    <form action="" method="post">
        <h3>Login Now</h3>
        <?php
        if (isset($error)) {
            foreach ($error as $msg) {
                echo '<span class="error-msg">' . $msg . '</span>';
            }
        }
        ?>
        <input type="email" name="email" required placeholder="Enter your email">
        <input type="password" name="password" required placeholder="Enter your password">
        <input type="submit" name="submit" value="Login Now" class="form-btn">
        <p>Don't have an account? <a href="register.php">Register now</a></p>
    </form>
</div>

</body>
</html>
