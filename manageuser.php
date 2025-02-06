<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="mr_mu_style.css">
</head>
<body>
    <div class="content">
        <h2>Manage Users</h2>
        <div class="tabs">
            <button class="tablink" onclick="openTab(event, 'Read')">Read Users</button>
            <button class="tablink" onclick="openTab(event, 'Update')">Update Users</button>
            <button class="tablink" onclick="openTab(event, 'Delete')">Delete Users</button>
        </div>

        <div class="content">    
            <a href="adminpage.php" class="btn">Admin Page</a>
            <link rel="stylesheet" href="style.css">
        </div>
   
        <div id="Update" class="tabcontent">
    <h3>Update Users</h3>
    <form action="updateuser.php" method="post">
                <label for="user_id">User ID:</label>
                <input type="number" id="user_id" name="user_id" required><br><br>

                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" required><br><br>

                <label for="email">Email:</label>
                <input type="text" id="email" name="email" required><br><br>

                <label for="password_hash">Password:</label>
                <input type="text" id="password_hash" name="password_hash" required><br><br>
                
                 <input type="submit" value="Submit">
    </form>
</div>


        <div id="Delete" class="tabcontent">
            <h3>Delete Users</h3>
            <form action="deleteuser.php" method="post">
                <label for="user_id">User ID:</label>
                <input type="number" id="user_id" name="user_id" required><br><br>
                <input type="submit" value="Delete">
            </form>
        </div>
    </div>
    <div id="Read" class="tabcontent">
            <h3>Read Users</h3>
            <?php
            $conn = new mysqli("localhost", "root", "", "officeleaverequests");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<table><tr><th>ID</th><th>Full name</th><th>Email</th><th>Password</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>".$row["user_id"]."</td><td>".$row["full_name"]."</td><td>".$row["email"]."</td><td>".$row["password_hash"]."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</body>
</html>