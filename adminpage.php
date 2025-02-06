<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<div class="container">

   <div class="content">
      <h3>Hi and Welcome Admin</span></h3>
      <h1><?php echo $_SESSION['admin_name'] ?></h1>
      <p>What Are You Going To Do Today?</p>
      <a href="managerequest.php" class="btn">Manage Request</a>
      <a href="manageuser.php" class="btn">Manage Users</a>
      <a href="logout.php" class="btn">logout</a>
   </div>

</div>

</body>
</html>