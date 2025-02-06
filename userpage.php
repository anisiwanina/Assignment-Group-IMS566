<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>user page</title>
   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<div class="container">

   <div class="content">
      <h3>Hi and Welcome!</h3>
      <h1><?php echo $_SESSION['user_name'] ?></h1>
      <p>What Are You Going To Do Today?</p>
      <a href="employeeprofile.php" class="btn">Update Profile</a>
      <a href="viewprofile.php" class="btn">View Profile</a>
      <a href="requestform.php" class="btn">Office Leave Request</a>
      <a href="viewrequest.php" class="btn">View Request</a>
      <a href="updaterequest.php" class="btn">Update Request</a>
      <a href="logout.php" class="btn">logout</a>
   </div>

</div>

</body>
</html>