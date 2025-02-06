<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "officeleaverequests";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$request_id = ''; // Initialize $request_id

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = $conn->real_escape_string($_POST['request_id']);

    // SQL query to fetch leave request details
    $sql = "SELECT s.employee_id, s.purpose, s.start_time, s.end_time, s.request_date, 
                   s.approval_date, s.date_of_leave, s.status
            FROM leave_requests s
            WHERE s.request_id = '$request_id'";

    $result = $conn->query($sql);
} else {
    $result = null;
}

// Generate PDF if requested
if (isset($_GET['export_pdf']) && $_GET['export_pdf'] == 1 && !empty($_GET['request_id'])) {
    // Include TCPDF library
    require_once('TCPDF-main/tcpdf.php'); 

    // Get request_id from URL
    $request_id = $_GET['request_id'];

    // SQL query to fetch only necessary fields
    $sql = "SELECT purpose, start_time, end_time, date_of_leave, status
            FROM leave_requests
            WHERE request_id = '$request_id'";

    $result = $conn->query($sql);

    // Create new PDF document
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);

    // Add a title
    $pdf->Cell(0, 10, 'Leave Request Details for Request ID: ' . $request_id, 0, 1, 'C');
    $pdf->Ln(10); // Space after title

    // Define column widths
    $colWidths = [60, 35, 35, 35, 40]; 

    // Set font for table header (bold)
    $pdf->SetFont('helvetica', 'B', 10);

    // Table headers
    $headers = ['Purpose', 'Start Time', 'End Time', 'Leave Date', 'Status'];
    foreach ($headers as $index => $header) {
        $pdf->Cell($colWidths[$index], 10, $header, 1, 0, 'C');
    }
    $pdf->Ln(); // Move to the next line after headers

    // Reset font for table data
    $pdf->SetFont('helvetica', '', 10);

    // Output the data rows
    while ($row = $result->fetch_assoc()) {
        $yStart = $pdf->GetY(); // Track row starting position

        // Purpose column (MultiCell for wrapping long text)
        $pdf->MultiCell($colWidths[0], 10, $row['purpose'], 1, 'L', false);
        $yEndPurpose = $pdf->GetY(); // End position after Purpose column

        // Move to the start of the row for the remaining columns
        $pdf->SetXY($pdf->GetX() + $colWidths[0], $yStart);

        // Other columns
        $pdf->Cell($colWidths[1], 10, $row['start_time'], 1, 0, 'C');
        $pdf->Cell($colWidths[2], 10, $row['end_time'], 1, 0, 'C');
        $pdf->Cell($colWidths[3], 10, $row['date_of_leave'], 1, 0, 'C');

        // Status column (MultiCell to prevent cut-off)
        $x = $pdf->GetX();
        $pdf->MultiCell($colWidths[4], 10, $row['status'], 1, 'C', false);
        
        // Adjust row height to avoid overlap
        $pdf->SetY(max($yEndPurpose, $pdf->GetY()));

        $pdf->Ln(); // Move to the next row
    }

    // Clean up the buffer before outputting the PDF
    ob_end_clean();

    // Output the PDF and force download
    $pdf->Output('leave_request_' . $request_id . '.pdf', 'D'); // 'D' for download
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quick Action</title>
    <link rel="stylesheet" href="qastyle.css">
</head>
<body>
    <div class="form-container">
        <div class="content">

            <?php if (!$result) { ?>
                <form action="quickaction.php" method="post">
                    <h3>Enter Request ID:</h3>
                    <input type="number" id="request_id" name="request_id" required>
                    <br><br>
                    <input type="submit" value="Get Request Details" class="form-btn">
                </form>
            <?php } else { ?>
                <?php
                if ($result->num_rows > 0) {
                    echo "<h3>Request Form for Request ID: $request_id</h3>";
                    echo "<table>
                            <tr>
                                <th>Employee ID</th>
                                <th>Purpose</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Request Date</th>
                                <th>Approval Date</th>
                                <th>Date of Leave</th>
                                <th>Status</th>
                            </tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row["employee_id"]."</td>
                                <td>".$row["purpose"]."</td>
                                <td>".$row["start_time"]."</td>
                                <td>".$row["end_time"]."</td>
                                <td>".$row["request_date"]."</td>
                                <td>".$row["approval_date"]."</td>
                                <td>".$row["date_of_leave"]."</td>
                                <td>".$row["status"]."</td>
                            </tr>";
                    }
                    echo "</table>";
                    // Add Export to PDF button & Back to Home button
                    echo '<div class="button-group">';
                    echo '<a href="quickaction.php?export_pdf=1&request_id=' . $request_id . '" class="form-btn">Export to PDF</a>';
                    echo '<a href="index.php" class="form-btn back-btn">Back to Home</a>';
                    echo '</div>';
                } else {
                    echo "<p class='error-msg'>No results found for the given Request ID.</p>";
                }
                ?>
            <?php } ?>
        </div>
    </div>

    <style>
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .form-btn {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .form-btn:hover {
            background-color: #0056b3;
        }
        .back-btn {
            background-color: #6c757d;
        }
        .back-btn:hover {
            background-color: #5a6268;
        }
    </style>

</body>
</html>
