<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "brigade");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch today's date
$currentDate = date('Y-m-d');

// Initialize variables
$dailySales = 0;
$monthlyOrders = 0;

// Calculate daily sales for completed orders only
$sqlDailySales = "SELECT SUM(Total) as daily_total FROM `order` WHERE Date = '$currentDate' AND Status = 'Order Completed'";
$resultDailySales = $conn->query($sqlDailySales);
if ($resultDailySales->num_rows > 0) {
    $row = $resultDailySales->fetch_assoc();
    $dailySales = $row['daily_total'] ?? 0;
}

// Calculate number of completed orders for the current month
$currentMonth = date('Y-m');
$sqlMonthlyOrders = "SELECT COUNT(*) as order_count FROM `order` WHERE DATE_FORMAT(Date, '%Y-%m') = '$currentMonth' AND Status = 'Order Completed'";
$resultMonthlyOrders = $conn->query($sqlMonthlyOrders);
if ($resultMonthlyOrders->num_rows > 0) {
    $row = $resultMonthlyOrders->fetch_assoc();
    $monthlyOrders = $row['order_count'] ?? 0;
}

// Calculate monthly sales for completed orders only
$sqlMonthlySales = "SELECT SUM(Total) as monthly_total FROM `order` WHERE DATE_FORMAT(Date, '%Y-%m') = '$currentMonth' AND Status = 'Order Completed'";
$resultMonthlySales = $conn->query($sqlMonthlySales);
if ($resultMonthlySales->num_rows > 0) {
    $row = $resultMonthlySales->fetch_assoc();
    $monthlySales = $row['monthly_total'] ?? 0;
}

// Fetch order summary for the pie chart
$orderSummary = [];
$sqlOrders = "SELECT Status, COUNT(*) as count FROM `order` GROUP BY Status";
$resultOrders = $conn->query($sqlOrders);
if ($resultOrders->num_rows > 0) {
    while ($row = $resultOrders->fetch_assoc()) {
        $orderSummary[$row['Status']] = $row['count'];
    }
}

$monthlySalesData = array_fill_keys(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], 0);
$sqlMonthlyData = "SELECT DATE_FORMAT(Date, '%Y-%m') as month, SUM(Total) as total FROM `order` WHERE Status = 'Order Completed' GROUP BY month ORDER BY month ASC";
$resultMonthlyData = $conn->query($sqlMonthlyData);
if ($resultMonthlyData->num_rows > 0) {
    while ($row = $resultMonthlyData->fetch_assoc()) {
        $dateObj = DateTime::createFromFormat('Y-m', $row['month']);
        $monthName = $dateObj->format('M'); // Convert month to short month name (e.g., 'Jan')
        $monthlySalesData[$monthName] = $row['total'];
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
    <link rel="stylesheet" href="styles/dashboard_styles.css">
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

<div class="content" id="content">
    <div class="hamburger" id="hamburger">

    </div>
    <h2 class="text-center">Dashboard</h2>

    <!-- Overview Cards -->
    <div class="row text-center mb-2">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Daily Sales</h6>
                    <p class="card-text">₱ <?php echo number_format($dailySales, 2); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Sales This Month</h6>
                    <p class="card-text">₱ <?php echo number_format($monthlySales, 2); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Orders</h6>
                    <p class="card-text"><?php echo $monthlyOrders; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Combined Monthly Sales Box and Chart -->
    <div class="row mb-2">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Monthly Sales</h6>
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Combined Order Status Box and Chart -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Order Status</h6>
                    <p class="card-text">Summary of current orders</p>
                    <div class="chart-container">
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
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