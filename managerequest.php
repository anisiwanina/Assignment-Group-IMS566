<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Requests</title>
    <link rel="stylesheet" href="mr_mu_style.css">
</head>
<body>
    <div class="content">
        <h2>Manage Request</h2>
        <div class="tabs">
            <button class="tablink" onclick="openTab(event, 'Read')">Read Request</button>
            <button class="tablink" onclick="openTab(event, 'Update')">Update Request</button>
            <button class="tablink" onclick="openTab(event, 'Delete')">Delete Request</button>
            </div>
            
            <div class="content">    
            <a href="adminpage.php" class="btn">Admin Page</a>
            <link rel="stylesheet" href="style.css">
        </div>

        <div id="Update" class="tabcontent">
    <h3>Update Requests</h3>
    <form action="updaterequest1.php" method="post">

                <label for="request_id">Request ID:</label>
                <input type="text" id="request_id" name="request_id" required><br><br>

                <label for="status">Status:</label>
                <input type="text" id="status" name="status" required><br><br>
        <input type="submit" value="Submit">
    </form>
</div>


        <div id="Delete" class="tabcontent">
            <h3>Delete Requests</h3>
            <form action="deleterequest.php" method="post">
                <label for="request_id">Request ID:</label>
                <input type="number" id="request_id" name="request_id" required><br><br>
                <input type="submit" value="Delete">
            </form>
        </div>
    </div>
    <div id="Read" class="tabcontent">
            <h3>Read Requests</h3>
            <?php
            $conn = new mysqli("localhost", "root", "", "officeleaverequests");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT * FROM leave_requests";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<table><tr><th>RequestID</th><th>Employee ID</th><th>Purpose</th><th>Start Time</th><th>End Time</th><th>Request Date</th><th>Date of Leave</th><th>Status</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>".$row["request_id"]."</td><td>".$row["employee_id"]."</td><td>".$row["purpose"]."</td><td>".$row["start_time"]."</td><td>".$row["end_time"]."</td><td>".$row["request_date"]."</td><td>".$row["date_of_leave"]."</td><td>".$row["status"]."</td></tr>";
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