<?php
session_start();
// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Adjust path as needed for autoload

$conn = mysqli_connect("localhost", "root", "", "brigade");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT OrderID, Product, Quantity, Status, Total, Date, Email FROM refund_order WHERE Status IN ('Refunded', 'Order Refunded')";

$result = $conn->query($sql);

if (isset($_POST['refund'])) {
    $orderId = $_POST['order_id'];
    $refundAmount = $_POST['refund_amount'];
    $userEmail = $_POST['user_email'];

    // Process the refund (you would integrate PayMongo API or your logic here)
    // Refund logic here (use PayMongo API or your refund process)

    // Update the database to mark the order as refunded
    $updateQuery = "UPDATE refund_order SET Status = 'Order Refunded' WHERE OrderID = '$orderId'";
    if (mysqli_query($conn, $updateQuery)) {
        // Send refund email to the user
        sendRefundEmail($userEmail, $refundAmount);
        echo "Refund processed successfully and email sent.";
    } else {
        echo "Error processing refund: " . mysqli_error($conn);
    }
}

function sendRefundEmail($userEmail, $refundAmount) {

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.mailersend.net'; // Update this with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'MS_QkjTfQ@trial-pq3enl6w3n042vwr.mlsender.net'; // SMTP username
        $mail->Password = 'fAtQJCLJh8TX4VSX'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Disable debug output (set to 0 to suppress all debug information)
        $mail->SMTPDebug = 0; // Debug levels: 0 = off, 1 = client messages, 2 = client and server messages
        $mail->Debugoutput = 'html'; // Output debug information in HTML format (if needed)

        // Recipients
        $mail->setFrom('MS_QkjTfQ@trial-pq3enl6w3n042vwr.mlsender.net', 'Brigade');
        $mail->addAddress($userEmail); // Customer's email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Refund Processed Successfully";
        $mail->Body    = "Your refund of $refundAmount has been successfully processed.";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brigade Clothing</title>
    <link rel="stylesheet" href="styles/bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" href="styles/orders.css?v=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  
</head>
<body>
    <div class="sidebar">
        <a><img src="assets/Untitled design.png" class="footer-logo"></a>
        <a href="6dashboard.php">Dashboard</a>
        <a href="6inventory.php">Stocks</a>
        <a href="6onprocess.php">On Process</a>
        <a href="6completeorders.php">Complete Orders</a>
        <a href="6cancelorders.php">Cancel Orders</a>
        <a href="6refundorders.php">Refund Orders</a>

        <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'superadmin'])): ?>
            <a href="6employees.php">Employees</a>
        <?php endif; ?>

        <a href="logout.php" class="logout-button">Logout</a>
    </div>

    <table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Total</th>
            <th>Date</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Determine if the button should be disabled
                $isRefunded = ($row['Status'] === 'Refunded');
                $isDoneRefunded = ($row['Status'] === 'Order Refunded');
                
                // Set the status badge color based on order status
                if ($isRefunded) {
                    $statusBadgeClass = 'badge-warning'; // Yellow (similar to refund button)
                } elseif ($isDoneRefunded) {
                    $statusBadgeClass = 'badge-success'; // Green (Completed)
                } else {
                    $statusBadgeClass = 'badge-primary'; // Default badge color
                }
                
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['OrderID']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Product']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Quantity']) . "</td>";
                echo "<td><span class='badge $statusBadgeClass'>" . htmlspecialchars($row['Status']) . "</span></td>";
                echo "<td>" . htmlspecialchars($row['Total']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                echo "<td>
                        <form method='POST'>
                            <input type='hidden' name='order_id' value='" . $row['OrderID'] . "' />
                            <input type='hidden' name='refund_amount' value='" . $row['Total'] . "' />
                            <input type='hidden' name='user_email' value='" . $row['Email'] . "' />
                            <button type='submit' name='refund' class='btn btn-warning btn-sm' " . ($isDoneRefunded ? 'disabled' : '') . ">Refund</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No Refund orders found.</td></tr>";
        }
        ?>
    </tbody>
</table>

</div>


<!-- JavaScript for Sidebar Toggle -->
<script>


    // Monthly Sales Data from PHP
const monthlySalesData = <?php echo json_encode($monthlySalesData); ?>;
const months = Object.keys(monthlySalesData);
const sales = Object.values(monthlySalesData);

// Render the Monthly Sales Chart as a Line Chart
const salesChartCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesChartCtx, {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Monthly Sales',
            data: sales,
            backgroundColor: 'rgba(0, 123, 255, 0.2)',
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 1.5,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Sales (Total)'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Month'
                }
            }
        }
    }
});
    

    const orderSummary = <?php echo json_encode($orderSummary); ?>;

    // Order Status Pie Chart
    const orderStatusChartCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(orderStatusChartCtx, {
        type: 'pie',
        data: {
            labels: Object.keys(orderSummary),
            datasets: [{
                data: Object.values(orderSummary),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)', // Pending
                    'rgba(54, 162, 235, 0.5)', // Processing
                    'rgba(255, 206, 86, 0.5)', // Shipped
                    'rgba(75, 192, 192, 0.5)'  // Delivered
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
<script>
    // JavaScript to make the navbar opaque when scrolling
    window.addEventListener('scroll', function() {
        const mainNav = document.querySelector('.main_nav_container');
        
        if (window.scrollY > 50) { // Adjust the scroll threshold as needed
            mainNav.classList.add('opaque');
        } else {
            mainNav.classList.remove('opaque');
        }
    });
</script>
</body>
</html>