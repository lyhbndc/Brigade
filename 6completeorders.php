<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "brigade");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT OrderID, Customer, Product, Quantity, Status, Total, Date FROM complete_order WHERE Status = 'Order Completed'";
$result = $conn->query($sql);

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brigade Clothing</title>
    <link rel="stylesheet" href="styles/bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" href="styles/orders.css">
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
                <th>Customer</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['OrderID']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Customer']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Product']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Quantity']) . "</td>";
                    echo "<td><span class='badge badge-success'>" . htmlspecialchars($row['Status']) . "</span></td>";
                    echo "<td>" . htmlspecialchars($row['Total']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                }
            } else {
                echo "<tr><td colspan='7'>No completed orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
   
    </div>


<!-- JavaScript for Sidebar Toggle -->
<script>
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const hamburger = document.getElementById('hamburger');

    hamburger.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        if (sidebar.classList.contains('active')) {
            sidebar.style.transform = 'translateX(0)';
            sidebar.style.zIndex = '1001'; // Ensure it covers content
            content.style.marginLeft = '0'; // No margin
        } else {
            sidebar.style.transform = 'translateX(-100%)'; // Hide off-screen
            content.style.marginLeft = '0'; // Reset margin
            sidebar.style.zIndex = ''; // Reset zIndex
        }
    });

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
